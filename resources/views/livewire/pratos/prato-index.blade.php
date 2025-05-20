<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold dark:text-white">Pratos</h2> <button wire:click="openModal"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">
                        Novo Prato
                    </button>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif
                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input type="text" wire:model.live="search" placeholder="Buscar pratos..."
                            class="w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <select wire:model.live="categoriaFilter"
                            class="w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Todas as categorias</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-zinc-700 border border-gray-200 dark:border-zinc-600">
                        <thead>
                            <tr>
                                <th
                                    class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 bg-gray-100 dark:bg-zinc-600 text-left text-xs font-semibold text-gray-600 dark:text-zinc-200 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th
                                    class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 bg-gray-100 dark:bg-zinc-600 text-left text-xs font-semibold text-gray-600 dark:text-zinc-200 uppercase tracking-wider">
                                    Descrição
                                </th>
                                <th
                                    class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 bg-gray-100 dark:bg-zinc-600 text-left text-xs font-semibold text-gray-600 dark:text-zinc-200 uppercase tracking-wider">
                                    Preço
                                </th>
                                <th
                                    class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 bg-gray-100 dark:bg-zinc-600 text-left text-xs font-semibold text-gray-600 dark:text-zinc-200 uppercase tracking-wider">
                                    Categoria
                                </th>
                                <th
                                    class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 bg-gray-100 dark:bg-zinc-600 text-left text-xs font-semibold text-gray-600 dark:text-zinc-200 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pratos as $prato)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 dark:text-white">
                                        {{ $prato->nome }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 dark:text-white">
                                        {{ \Illuminate\Support\Str::limit($prato->desc, 50) }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 dark:text-white">
                                        R$ {{ number_format($prato->preco, 2, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600 dark:text-white">
                                        {{ $prato->categoria->nome }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-zinc-600">
                                        <div class="flex space-x-2"> <button wire:click="openEditModal({{ $prato->id }})"
                                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 cursor-pointer">
                                                Editar
                                            </button> <button
                                                wire:click="$dispatch('confirmDeletePrato', { id: {{ $prato->id }} })"
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                            </tr> @empty
                                <tr>
                                    <td colspan="5"
                                        class="py-4 px-4 border-b border-gray-200 dark:border-zinc-600 text-center text-gray-500 dark:text-zinc-400">
                                        Nenhum prato encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pratos->links() }}
                </div>

                @error('delete')
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Modal para criar/editar pratos -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    {{ $isEditMode ? 'Editar Prato' : 'Novo Prato' }}
                                </h3>
                                <div class="mt-4">
                                    <form>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="nome"
                                                    class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                                                    Nome do Prato
                                                </label>
                                                <input type="text" id="nome" wire:model="nome"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                @if ($errors->has('nome'))
                                                    <span class="text-red-500 text-xs">{{ $errors->first('nome') }}</span>
                                                @endif
                                            </div>

                                            <div class="mb-4">
                                                <label for="id_categoria"
                                                    class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                                                    Categoria
                                                </label>
                                                <select id="id_categoria" wire:model="id_categoria"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <option value="">Selecione uma categoria</option>
                                                    @foreach($categorias as $categoria)
                                                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('id_categoria'))
                                                    <span
                                                        class="text-red-500 text-xs">{{ $errors->first('id_categoria') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="desc"
                                                class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                                                Descrição
                                            </label>
                                            <textarea id="desc" wire:model="desc" rows="3"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                                            @if ($errors->has('desc'))
                                                <span class="text-red-500 text-xs">{{ $errors->first('desc') }}</span>
                                            @endif
                                        </div>

                                        <div class="mb-4">
                                            <label for="preco"
                                                class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                                                Preço (R$)
                                            </label>
                                            <input type="number" step="0.01" id="preco" wire:model="preco"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @if ($errors->has('preco'))
                                                <span class="text-red-500 text-xs">{{ $errors->first('preco') }}</span>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"> <button
                            type="button" wire:click="save"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            {{ $isEditMode ? 'Atualizar' : 'Salvar' }}
                        </button> <button type="button" wire:click="closeModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-zinc-600 dark:text-white dark:border-zinc-700 dark:hover:bg-zinc-500 cursor-pointer">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif <!-- Modal de confirmação de exclusão -->
    <div x-data="{ open: false, pratoId: null }" x-init="window.addEventListener('confirm-delete-prato', (event) => {
            open = true; 
            pratoId = event.detail.id;
        })" x-show="open" x-on:confirm-delete-prato.window="open = true; pratoId = $event.detail.id" x-cloak
        class="fixed inset-0 z-20 overflow-y-auto" aria-labelledby="modal-delete-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/75 transition" aria-hidden="true" @click="open = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                                id="modal-delete-title">
                                Confirmar Exclusão
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-zinc-400">
                                    Tem certeza que deseja excluir este prato? Esta ação não pode ser desfeita e todos
                                    os dados associados serão removidos permanentemente.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="$wire.delete(pratoId); open = false;"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Excluir
                    </button>
                    <button type="button" @click="open = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-zinc-600 dark:text-white dark:border-zinc-700 dark:hover:bg-zinc-500 cursor-pointer">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('confirmDeletePrato', (data) => {
                window.dispatchEvent(new CustomEvent('confirm-delete-prato', { detail: data }));
            });
        });

        // Reinicializa os ouvintes após navegação
        document.addEventListener('livewire:navigated', () => {
            Livewire.on('confirmDeletePrato', (data) => {
                window.dispatchEvent(new CustomEvent('confirm-delete-prato', { detail: data }));
            });
        });
    </script>
</div>