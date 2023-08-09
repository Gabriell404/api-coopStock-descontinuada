<?php
namespace App\Http\Services;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsuarioService {
    public function listar() {
        return User::with('perfils')->paginate(10);
    }

    public function findById(int $id)
    {
        return User::findOrFail($id);
    }

    public function getRole(string $role): string {
        return Roles::where('nome', $role)->first()->descricao;
    }
}