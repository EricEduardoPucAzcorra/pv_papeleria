<?php

namespace App\Http\Livewire\Usuarios;

use Livewire\Component;

use App\Models\User;

class Usuarios extends Component
{
    //pribadas no puede visualizarse en la vista
    //publicas si puede visualizarse

    public $usuarios = [];
    public $valor = 0;

    public function render()
    {

        $users = User::all();

        $this->usuarios = $users;

        return view('livewire.usuarios.usuarios');
    }

    public function oprimir(){



        $this->valor ++;
    }
}
