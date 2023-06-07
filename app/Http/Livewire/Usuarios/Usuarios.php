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

    public function mount()
    {
        // $this->selected_id = -1;
        $this->operationName = 'Usuarios';
        // $this->categoria = Categoria::all()->count() > 0 ? Categoria::all()->first()->id : -1;
    }

    //pribadas no puede visualizarse en la vista
    //publicas si puede visualizarse

    //public $usuarios = [];
    public $valor = 0;
    public $bandera = '';

    public function render()
    {
        $users = [];

        if ($this->search) {
            $users = User::orderBy('nombre', 'asc')
                ->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->orWhere('apellido', 'LIKE', '%' . $this->search . '%')
               
                ->paginate(10);

                
        } else {
            $users = User::orderBy('nombre', 'asc')->paginate(10);
            
        }


        //$user = User::all();

        $usuarios = $users;

        return view('livewire.usuarios.usuarios', compact('usuarios'));
    }

    public function resetForm(){
        $this->nombre='';
        $this->apellido='';
        $this->email='';
        $this->telefono='';
        $this->password='';
        $this->imagen='';
        $this->estatus='ACTIVO';
    }

    public function closeform(){
        $this->resetForm();
        $this->emit('usuarios', 'hide');
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
        //valida datos
        $this->validate([
            'nombre' => 'required|min:3',
            'apellido' => 'required|min:2',
            'email' => 'required|min:3',
            'telefono' => 'required|min:3',
            'password' => 'required|min:3',

        ]);
        //valida en especiico la imagen tipo file
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
                'imagen' => $imagen ?? null,
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
        $this->resetForm();
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
        //$this->imagen = $usuario['imagen'];
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
                'estatus'=> $this->estatus
            ]);
            //Confirmar la transaccion
            DB::commit();
            //Mensaje de exito
            //$this->emit('producto-creado', 'El usuario se ha actualizado correctamente');
        } catch (\Exception $e) {
            //Cancelar la transaccion
            DB::rollBack();
            //Mensaje de error
            ///$this->emit('usuario-error', 'Ha ocurrido un error al actualizar el usuario');
        }

        //Cerrar la modal
        $this->emit('usuarios', 'hide');

        $this->render();

        $this->resetForm();


    }

    public function activar($id){
        $usuario = User::find($id);
        $usuario->estatus = 'ACTIVO';
        $usuario->update();
    }
    public function desactivar($id){
        $usuario = User::find($id);
        $usuario->estatus = 'INACTIVO';
        $usuario->update();

    }

}
