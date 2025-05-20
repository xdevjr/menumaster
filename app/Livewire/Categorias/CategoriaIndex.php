<?php

namespace App\Livewire\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriaIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $nome = '';
    public $categoriaId = null;
    public $isModalOpen = false;
    public $isEditMode = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            'nome' => $this->isEditMode
                ? 'required|string|max:255|unique:categorias,nome,' . $this->categoriaId
                : 'required|string|max:255|unique:categorias,nome',
        ];
    }

    protected $messages = [
        'nome.required' => 'O nome da categoria é obrigatório.',
        'nome.unique' => 'Já existe uma categoria com este nome.',
        'nome.max' => 'O nome da categoria não pode ter mais que 255 caracteres.',
    ];

    public function openModal()
    {
        $this->isModalOpen = true;
        $this->isEditMode = false;
        $this->nome = '';
        $this->categoriaId = null;
        $this->resetErrorBag();
    }

    public function openEditModal($id)
    {
        $categoria = Categoria::findOrFail($id);
        $this->categoriaId = $categoria->id;
        $this->nome = $categoria->nome;
        $this->isModalOpen = true;
        $this->isEditMode = true;
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditMode) {
            $categoria = Categoria::findOrFail($this->categoriaId);
            $categoria->update(['nome' => $this->nome]);
            session()->flash('message', 'Categoria atualizada com sucesso!');
        } else {
            Categoria::create(['nome' => $this->nome]);
            session()->flash('message', 'Categoria criada com sucesso!');
        }

        $this->closeModal();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);

        // Verifica se existem pratos vinculados à categoria
        if ($categoria->pratos()->count() > 0) {
            $this->addError('delete', 'Esta categoria não pode ser excluída pois possui pratos vinculados.');
            return;
        }

        $categoria->delete();
        session()->flash('message', 'Categoria excluída com sucesso!');
    }

    public function render()
    {
        return view('livewire.categorias.categoria-index', [
            'categorias' => Categoria::where('nome', 'like', '%' . $this->search . '%')
                ->orderBy('nome')
                ->paginate(10),
        ])->title('Categorias');
    }
}
