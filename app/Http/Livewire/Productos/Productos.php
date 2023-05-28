<?php

namespace App\Http\Livewire\Productos;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    //Escuchar eventos desde el frontEnd
    protected $listeners = ['eliminar-objeto' => 'destroy'];

    //Variables necesarios para la modal
    public $selected_id;
    public $operationName;

    //Variables del producto
    public $nombre;
    public $sku;
    public $precio;
    public $categoria;
    public $costo;
    public $stock;
    public $inv_min;
    public $imagen;

    //Variables serch
    public $search;

    public function mount()
    {
        $this->selected_id = -1;
        $this->operationName = 'Productos';
        $this->categoria = Categoria::all()->count() > 0 ? Categoria::all()->first()->id : -1;
    }

    public function render()
    {
        if ($this->search) {
            $productos = Producto::orderBy('nombre', 'asc')
                ->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->orWhere('sku', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('categoria', function ($query) {
                    $query->where('nombre', 'LIKE', '%' . $this->search . '%');
                })
                ->paginate(10);
        } else {
            $productos = Producto::orderBy('nombre', 'asc')->paginate(10);
        }

        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        return view('livewire.productos.productos', \compact('productos', 'categorias'));
    }

    //Reiniciar la busqueda
    public function updatingSearch(){
        $this->resetPage();
    }

    public function resetUI()
    {
        $this->selected_id = -1;
        $this->nombre = '';
        $this->sku = '';
        $this->precio = '';
        $this->categoria = -1;
        $this->costo = '';
        $this->stock = '';
        $this->inv_min = '';
        $this->imagen = '';
        $this->resetErrorBag();
    }

    public function edit(Producto $producto)
    {
        $this->selected_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->sku = $producto->sku;
        $this->precio = $producto->precio;
        $this->categoria = $producto->categoria_id;
        $this->costo = $producto->costo;
        $this->stock = $producto->stock;
        $this->inv_min = $producto->minimo_stock;
        //Abrir modal
        $this->emit('modal-operaciones', 'show');
    }

    public function store()
    {
        $this->validate([
            'sku' => 'required|unique:productos,sku',
            'nombre' => 'required|min:3',
            'precio' => 'required|numeric',
            'categoria' => 'required|numeric',
            'costo' => 'required|numeric',
            'stock' => 'required|numeric',
            'inv_min' => 'required|numeric',
        ]);

        if ($this->imagen) {
            //Validar la imagen
            $this->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            //Almacenar la imagen
            $nombreNuevo = \uniqid() . '.' . $this->imagen->extension();

            $this->imagen->storeAs('public/productos', $nombreNuevo);

            $imagen = 'productos/' . $nombreNuevo;
        }

        //Iniciar una transaccion
        DB::beginTransaction();
        try {
            //Crear el producto
            Producto::create([
                'sku' => $this->sku,
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'categoria_id' => $this->categoria,
                'costo' => $this->costo,
                'stock' => $this->stock,
                'minimo_stock' => $this->inv_min,
                'imagen' => $imagen ?? null,
            ]);
            //Confirmar la transaccion
            DB::commit();
            //Mensaje de exito
            $this->emit('producto-creado', 'El producto se ha creado correctamente');
        } catch (\Exception $e) {
            //Cancelar la transaccion
            DB::rollBack();
            //Mensaje de error
            $this->emit('producto-error', 'Ha ocurrido un error al crear el producto');
        }

        //Cerrar la modal
        $this->emit('modal-operaciones', 'hide');
        $this->render();
        $this->resetUI();
    }


    public function update(Producto $producto)
    {
        $this->validate([
            'sku' => 'required|unique:productos,sku,' . $this->selected_id,
            'nombre' => 'required|min:3',
            'precio' => 'required|numeric',
            'categoria' => 'required|numeric',
            'costo' => 'required|numeric',
            'stock' => 'required|numeric',
            'inv_min' => 'required|numeric',
        ]);

        $imagen = $producto->imagen;

        //Validar la imagen
        if ($this->imagen) {
            $this->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($producto->imagen){
                 //Eliminar la imagen anterior
                 \unlink(public_path('storage/' . $producto->imagen));
            }

            //Almacenar la imagen
            $nombreNuevo = \uniqid() . '.' . $this->imagen->extension();

            $this->imagen->storeAs('public/productos', $nombreNuevo);

            $imagen = 'productos/' . $nombreNuevo;

        }

        //Iniciar una transaccion
        DB::beginTransaction();
        try {
            //Actualizar el producto
            $producto->update([
                'sku' => $this->sku,
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'categoria_id' => $this->categoria,
                'costo' => $this->costo,
                'stock' => $this->stock,
                'minimo_stock' => $this->inv_min,
                'imagen' => $imagen,
            ]);
            //Confirmar la transaccion
            DB::commit();
            //Mensaje de exito
            $this->emit('producto-actualizado', 'El producto se ha actualizado correctamente');
        } catch (\Exception $e) {
            //Cancelar la transaccion
            DB::rollBack();
            //Mensaje de error
            $this->emit('producto-error', 'Ha ocurrido un error al actualizar el producto');
        }

        //Cerrar la modal
        $this->emit('modal-operaciones', 'hide');

        $this->resetUI();
    }

    public function destroy(Producto $producto)
    {
        //Elimnar la imagen
        if ($producto->imagen) {
            \unlink(public_path('storage/' . $producto->imagen));
        }

        $producto->delete();
    }
}
