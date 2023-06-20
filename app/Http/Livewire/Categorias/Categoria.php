<?php

namespace App\Http\Livewire\Categorias;

use Livewire\Component;
use App\Models\Categoria as CategoriaModel;
use Livewire\WithPagination;

class Categoria extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    //Escuchar eventos desde el frontEnd
    protected $listeners = ['eliminar-objeto' => 'destroy'];

    //Variables necesarios para la modal
    public $selected_id;
    public $operationName;

    //variables
    public $nombre;

    public $search;

    public function mount()
    {
        $this->selected_id = -1;
        $this->operationName = 'Categoria';
    }

    public function render()
    {
        $categorias =[];
        if ($this->search) {
            $categorias = CategoriaModel::orderBy('nombre', 'asc')
                ->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->paginate(10);
                
        } else {
            $categorias = CategoriaModel::orderBy('nombre', 'asc')->paginate(10);
            
        }


        return view('livewire.categorias.categoria', compact('categorias'));
    }

    public function resetUI()
    {
        $this->selected_id = -1;
        $this->nombre = '';
        $this->resetErrorBag();
    }

    public function edit(CategoriaModel $categoria)
    {
        $this->selected_id = $categoria->id;
        $this->nombre = $categoria->nombre;

        //abrir modal
        $this->emit('modal-operaciones', 'show');
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|unique:categorias,nombre',
        ]);

        CategoriaModel::create([
            'nombre' => $this->nombre,
        ]);

        $this->resetUI();
        //cerrar modal
        $this->emit('modal-operaciones', 'hide');
    }

    public function update(CategoriaModel $categoria)
    {
        $this->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id,
        ]);

        $categoria->update([
            'nombre' => $this->nombre,
        ]);

        $this->resetUI();
        //cerrar modal
        $this->emit('modal-operaciones', 'hide');
    }

    public function destroy(CategoriaModel $categoria)
    {
        $categoria->delete();
    }
}
