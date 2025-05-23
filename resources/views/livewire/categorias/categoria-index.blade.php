<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <flux:heading size="lg">Categorias</flux:heading>
                    <flux:button wire:click="openModal" variant="primary" icon="plus">
                        Nova Categoria
                    </flux:button>
                </div> @if (session()->has('message'))
                    <div class="mb-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-lg"
                        role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="mb-6">
                    <flux:input wire:model.live="search" placeholder="Buscar categorias..." icon="magnifying-glass" />
                </div> <!-- Tabela de categorias -->
                <div class="overflow-hidden shadow-sm rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-900">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Nome</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Total de Pratos</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($categorias as $categoria)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $categoria->nome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200">
                                            {{ $categoria->pratos->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <flux:button wire:click="openEditModal({{ $categoria->id }})" variant="outline"
                                            size="sm" icon="pencil">
                                            Editar
                                        </flux:button>
                                        <flux:button wire:click="confirmDelete({{ $categoria->id }})" variant="danger"
                                            size="sm" icon="trash">
                                            Excluir
                                        </flux:button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        Nenhuma categoria encontrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $categorias->links() }}
                </div> @error('delete')
                    <div class="mt-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded-lg"
                        role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div> <!-- Modal para criar/editar categorias -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:transition>
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-zinc-500 dark:bg-zinc-900 bg-opacity-75 dark:bg-opacity-80 transition-opacity"
                    wire:click="closeModal"></div>

                <!-- Modal -->
                <div
                    class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $isEditMode ? 'Editar Categoria' : 'Nova Categoria' }}
                            </h3>
                            <button wire:click="closeModal"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit.prevent="save">
                            <div class="mb-4">
                                <flux:input wire:model="nome" label="Nome da Categoria"
                                    placeholder="Digite o nome da categoria" />
                            </div>

                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">Cancelar</flux:button>
                                <flux:button type="submit" variant="primary">
                                    {{ $isEditMode ? 'Atualizar' : 'Salvar' }}
                                </flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif <!-- Modal de confirmação de exclusão -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:transition>
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-zinc-500 dark:bg-zinc-900 bg-opacity-75 dark:bg-opacity-80 transition-opacity"
                    wire:click="closeDeleteModal"></div>

                <!-- Modal -->
                <div
                    class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                                Confirmar Exclusão
                            </h3>
                            <button wire:click="closeDeleteModal"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-start space-x-3 mb-6">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                    Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita e
                                    todos os dados associados serão removidos permanentemente.
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <flux:button type="button" wire:click="closeDeleteModal" variant="ghost">
                                Cancelar
                            </flux:button>
                            <flux:button type="button" wire:click="delete" variant="danger">
                                Excluir
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>