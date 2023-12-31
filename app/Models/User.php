<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'last_login',
        'ip_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function loginSecurity()
    {
        return $this->hasOne(LoginSecurity::class);
    }

    public function perfils()
    {
        return $this->belongsToMany(Perfil::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function adicionaPerfil($perfil){

        if (is_string($perfil)) {
            return $this->perfils()->save(
                Perfil::where('nome', '=', $perfil)->firstOrFail()
            );
        }
        return $this->perfils()->save(
            Perfils::where('nome', '=', $perfil->nome)->firstOrFail()
        );
    }

    public function removePerfil($perfil){
        if (is_string($perfil)) {
            return $this->perfils()->detach(
                Perfil::where('nome', '=', $perfil)->firstOrFail()

            );
        }
        return $this->perfils()->detach(
            Perfil::where('nome', '=', $perfil->nome)->firstOrFail()

        );
    }

    public function existePerfil($perfil){

        if (is_string($perfil)) {
            return $this->perfils->contains('nome', $perfil);
        }

        return $perfil->intersect($this->perfils)->count();

    }

    public static function existePermissao(int|string $permissao, int|string $perfil){

        if (DB::table('perfils_roles')->where('roles_id', $permissao)->where('perfils_id', $perfil)->count()) {

            return true;

        }else{
            return false;
        }

    }

    public function existeAdmin()
    {
        return $this->existePerfil('Master');
    }

}