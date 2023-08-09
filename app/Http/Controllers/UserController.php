<?php

namespace App\Http\Controllers;


use App\Http\Services\UsuarioService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\LdapService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct(UsuarioService $usuarioService)
    {
        
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'messagem' => $validator->errors() 
                ], 403);
            }

            $result = LdapService::connect($request->get('email'), $request->get('password'));

            if(!$result)
            {
                return response()->json([
                    'error' => true,
                    'messagem' => 'Email ou senha inválidos.',
                ], 403);
            }

            $user = User::firstOrCreate([
                'email' => $request->get('email'),
            ],[
                'name' => $result['user'],
                'last_login' => now()
            ]);


            Auth::login($user);
            Auth::user()->update([
                'last_login' => Carbon::now()->toDateTimeString(),
                'ip_login' => $request->getClientIp()
            ]);

            $roles = $user->perfils[0]->permissoes->map(function($permissao){
                return $permissao->nome;
            });

            return response()->json([
                'error' => false,
                'messagem' => 'Usuário autenticado!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                    'description' => $result['description'],
                    'roles' => $roles

                ],
                'token' => $user->createToken($user->name, count($roles) === 0 ? ['isadmin'] : $roles->toArray())->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            
            return response()->json([
                'error' => true,
                'messagem' => $th->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $attr = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6'
            ]);

            $user = User::create([
                'name' => $attr['name'],
                'password' => bcrypt($attr['password']),
                'email' => $attr['email'],
            ]);

            return response()->json([
                'errors' => false,
                'token' => $user->createToken($user->email, ['user:createe', 'user:update'])->plainTextToken
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'errors' => true,
                'messagem' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        Session::flush();

        return response()->json([
            'errors' => false,
            'messagem' => 'Usuário desconectado'
        ], 200);

    }
}