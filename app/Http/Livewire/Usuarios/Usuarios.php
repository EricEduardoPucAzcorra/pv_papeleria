<?php

namespace App\Http\Livewire\Usuarios;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Usuarios extends Component
{

    use WithPagination;
    use WithFileUploads;

    //variables del producto
    public $id_usuario;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $imagen;
    public $estatus;

    //Variables serch
    public $search;

    //pribadas no puede visualizarse en la vista
    //publicas si puede visualizarse

    public $usuarios = [];
    public $valor = 0;
    public $bandera = '';

    public function render()
    {

        $users = User::all();

        $this->usuarios = $users;

        return view('livewire.usuarios.usuarios');
    }

    public function create(){
        $this->emit('usuarios', 'show');
        $this->bandera = 'nuevo';
        $this->nombre='';
        $this->apellido='';
        $this->email='';
        $this->telefono='';
        $this->password='';
        $this->imagen='';
        $this->estatus='ACTIVO';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:3',
            'apellido' => 'required|min:2',
            'email' => 'required|min:3',
            'telefono' => 'required|min:3',
            'password' => 'required|min:3',

        ]);

        if ($this->imagen) {
            //Validar la imagen
            $this->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            //Almacenar la imagen
            $nombreNuevo = \uniqid() . '.' . $this->imagen->extension();

            $this->imagen->storeAs('public/usuarios', $nombreNuevo);

            $imagen = 'usuarios/' . $nombreNuevo;
        }

        
        //Iniciar una transaccion
        DB::beginTransaction();
        try {
            //crear el usuario
            User::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'password' => Hash::make($this->password),
                'imagen' => $imagen,
                
            ]);
            //Confirmar la transaccion
            DB::commit();
            
        } catch (\Exception $e) {
            //Cancelar la transaccion
            DB::rollBack();
            $this->emit('producto-error', 'Ha ocurrido un error al crear el usuario');
        }

        //Cerrar la modal
        $this->emit('usuarios', 'hide');
        $this->render();
        // $this->resetUI();
    }

    public $user = [];

    public function edit($usuario)
    {
        $this->emit('usuarios', 'show');
        $this->bandera='editar';
        $this->id_usuario=$usuario['id'];
        $this->nombre = $usuario['nombre'];
        $this->apellido = $usuario['apellido'];
        $this->email = $usuario['email'];
        $this->telefono = $usuario['telefono'];
        //$this->password = $usuario;
        $this->imagen = $usuario['imagen'];
        $this->estatus = $usuario['estatus'];

       $this->user=$usuario;

    }

    public function update()
    {

        $usuario = User::find($this->id_usuario);

        $this->validate([
            'nombre' => 'required|min:3',
            'apellido' => 'required|min:2',
            'email' => 'required|min:3',
            'telefono' => 'required|min:10',
            'password' => 'required|min:3',
        ]);

        $imagen = $usuario['imagen'];

        //Validar la imagen
        if ($this->imagen) {
            $this->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($usuario['imagen']){
                 //Eliminar la imagen anterior
                 \unlink(public_path('storage/' . $usuario->imagen));
            }

            //Almacenar la imagen
            $nombreNuevo = \uniqid() . '.' . $this->imagen->extension();

            $this->imagen->storeAs('public/usuarios', $nombreNuevo);

            $imagen = 'usuarios/' . $nombreNuevo;

        }

        //Iniciar una transaccion
        DB::beginTransaction();
        try {
            //Actualizar el usuario
            $usuario->update([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'password' => Hash::make($this->password),
                'imagen' => $imagen,
            ]);
            //Confirmar la transaccion
            DB::commit();
            //Mensaje de exito
            //$this->emit('usuario-actualizado', 'El usuario se ha actualizado correctamente');
        } catch (\Exception $e) {
            //Cancelar la transaccion
            DB::rollBack();
            //Mensaje de error
            ///$this->emit('usuario-error', 'Ha ocurrido un error al actualizar el usuario');
        }

        //Cerrar la modal
        $this->emit('usuarios', 'hide');


    }

}
