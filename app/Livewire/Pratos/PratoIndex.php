<?php

namespace App\Livewire\Pratos;

use App\Models\Categoria;
use App\Models\Prato;
use Livewire\Component;
use Livewire\WithPagination;

class PratoIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $categoriaFilter = '';
    public $nome = '';
    public $desc = '';
    public $preco = '';
    public $id_categoria = '';
    public $pratoId = null;
    public $isModalOpen = false;
    public $isEditMode = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoriaFilter' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id',
        ];
    }

    protected $messages = [
        'nome.required' => 'O nome do prato é obrigatório.',
        'nome.max' => 'O nome do prato não pode ter mais que 255 caracteres.',
        'desc.required' => 'A descrição do prato é obrigatória.',
        'desc.max' => 'A descrição do prato não pode ter mais que 255 caracteres.',
        'preco.required' => 'O preço do prato é obrigatório.',
        'preco.numeric' => 'O preço deve ser um valor numérico.',
        'preco.min' => 'O preço não pode ser negativo.',
        'id_categoria.required' => 'Selecione uma categoria.',
        'id_categoria.exists' => 'A categoria selecionada não existe.',
    ];

    public function openModal()
    {
        $this->isModalOpen = true;
        $this->isEditMode = false;
        $this->nome = '';
        $this->desc = '';
        $this->preco = '';
        $this->pratoId = null;

        // Seleciona a primeira categoria por padrão
        $primeiraCategoria = Categoria::first();
        if ($primeiraCategoria) {
            $this->id_categoria = $primeiraCategoria->id;
        }

        $this->resetErrorBag();
    }

    public function openEditModal($id)
    {
        $prato = Prato::findOrFail($id);
        $this->pratoId = $prato->id;
        $this->nome = $prato->nome;
        $this->desc = $prato->desc;
        $this->preco = $prato->preco;
        $this->id_categoria = $prato->id_categoria;
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
            $prato = Prato::findOrFail($this->pratoId);
            $prato->update([
                'nome' => $this->nome,
                'desc' => $this->desc,
                'preco' => $this->preco,
                'id_categoria' => $this->id_categoria,
            ]);
            session()->flash('message', 'Prato atualizado com sucesso!');
        } else {
            Prato::create([
                'nome' => $this->nome,
                'desc' => $this->desc,
                'preco' => $this->preco,
                'id_categoria' => $this->id_categoria,
            ]);
            session()->flash('message', 'Prato criado com sucesso!');
        }

        $this->closeModal();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoriaFilter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $prato = Prato::findOrFail($id);

        // Verifica se existem pedidos vinculados ao prato
        if ($prato->pedidos()->count() > 0) {
            $this->addError('delete', 'Este prato não pode ser excluído pois possui pedidos vinculados.');
            return;
        }

        $prato->delete();
        session()->flash('message', 'Prato excluído com sucesso!');
    }

    public function render()
    {
        $pratosQuery = Prato::with('categoria')
            ->where('nome', 'like', '%' . $this->search . '%');

        if ($this->categoriaFilter) {
            $pratosQuery->where('id_categoria', $this->categoriaFilter);
        }
        $pratos = $pratosQuery->orderBy('nome')->paginate(10);

        return view('livewire.pratos.prato-index', [
            'pratos' => $pratos,
            'categorias' => Categoria::orderBy('nome')->get(),
        ])->title('Pratos');
    }
}
