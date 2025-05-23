<div>
    <!-- Cabeçalho -->
    <div class="bg-white dark:bg-zinc-800 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-zinc-600 dark:text-zinc-400 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0L5.4 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6">
                        </path>
                    </svg>
                    <flux:heading size="lg">Meu Carrinho</flux:heading>
                </div>
                <div class="flex items-center space-x-4">
                    <flux:button wire:click="voltarAoCardapio" variant="outline" icon="arrow-left">
                        Voltar ao Cardápio
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensagens de Flash -->
    @if (session()->has('message'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg p-4 flex items-center"
                role="alert">
                <svg class="h-5 w-5 mr-2 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg p-4 flex items-center"
                role="alert">
                <svg class="h-5 w-5 mr-2 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($itensCarrinho->isEmpty())
            <!-- Carrinho Vazio -->
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0L5.4 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Carrinho vazio</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Você ainda não adicionou nenhum item ao seu
                    carrinho.</p>
                <div class="mt-6">
                    <flux:button wire:click="voltarAoCardapio" variant="primary">
                        Ver Cardápio
                    </flux:button>
                </div>
            </div>
        @else
            <!-- Lista de Itens do Carrinho -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Itens do Carrinho -->
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <flux:heading size="sm">Itens do Carrinho ({{ $itensCarrinho->count() }})</flux:heading>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($itensCarrinho as $item)
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $item->prato->nome }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->prato->desc }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Categoria:
                                                {{ $item->prato->categoria->nome }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">R$
                                                {{ number_format($item->prato->preco, 2, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <!-- Controles de Quantidade -->
                                            <div class="flex items-center space-x-2">
                                                <flux:button wire:click="diminuirQuantidade({{ $item->id }})" size="xs"
                                                    variant="outline" icon="minus" class="rounded-full"></flux:button>
                                                <span
                                                    class="font-medium text-zinc-900 dark:text-zinc-100 w-8 text-center">{{ $item->qtd }}</span>
                                                <flux:button wire:click="aumentarQuantidade({{ $item->id }})" size="xs"
                                                    variant="outline" icon="plus" class="rounded-full"></flux:button>
                                            </div>
                                            <!-- Subtotal -->
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    R$ {{ number_format($item->prato->preco * $item->qtd, 2, ',', '.') }}
                                                </p>
                                            </div>
                                            <!-- Botão Remover -->
                                            <flux:button wire:click="confirmarRemoverItem({{ $item->id }})" variant="danger"
                                                size="xs" icon="trash"></flux:button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Resumo do Pedido -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 sticky top-4">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <flux:heading size="sm">Resumo do Pedido</flux:heading>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Subtotal</span>
                                <span class="text-zinc-900 dark:text-zinc-100">R$
                                    {{ number_format($valorTotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">
                                <div class="flex justify-between text-base font-medium">
                                    <span class="text-zinc-900 dark:text-zinc-100">Total</span>
                                    <span class="text-zinc-900 dark:text-zinc-100">R$
                                        {{ number_format($valorTotal, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 space-y-3 border-t border-gray-200 dark:border-gray-700">
                            <flux:button wire:click="abrirModalFinalizarPedido" variant="primary" icon="check"
                                class="w-full">
                                Finalizar Pedido
                            </flux:button>
                            <flux:button wire:click="confirmarLimparCarrinho" variant="danger" icon="trash" class="w-full">
                                Limpar Carrinho
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Confirmar Finalização -->
    @if($modalFinalizarPedido)
        <div
            class="fixed inset-0 bg-zinc-600/50 dark:bg-zinc-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="w-full max-w-md bg-white dark:bg-zinc-800 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="md" class="text-center">Finalizar Pedido</flux:heading>
                </div>

                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <p class="text-zinc-600 dark:text-zinc-400 text-center mb-4">
                        Tem certeza que deseja finalizar este pedido?
                    </p>

                    <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-4 mb-6">
                        <div class="text-zinc-600 dark:text-zinc-300 text-sm">
                            <p class="mb-1"><strong>Total de itens:</strong> {{ $itensCarrinho->sum('qtd') }}</p>
                            <p><strong>Valor total:</strong> R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <flux:button wire:click="fecharModalFinalizarPedido" variant="ghost" class="w-full">
                            Cancelar
                        </flux:button>
                        <flux:button wire:click="finalizarPedido" variant="primary" class="w-full">
                            Confirmar
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Confirmar Remoção de Item -->
    @if($modalRemoverItem)
        <div
            class="fixed inset-0 bg-zinc-600/50 dark:bg-zinc-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="w-full max-w-md bg-white dark:bg-zinc-800 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="md" class="text-center">Remover Item</flux:heading>
                </div>

                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <p class="text-zinc-600 dark:text-zinc-400 text-center mb-4">
                        Tem certeza que deseja remover este item do carrinho?
                    </p>

                    <div class="flex space-x-3">
                        <flux:button wire:click="fecharModalRemoverItem" variant="ghost" class="w-full">
                            Cancelar
                        </flux:button>
                        <flux:button wire:click="removerItem" variant="danger" class="w-full">
                            Remover
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Confirmar Limpar Carrinho -->
    @if($modalLimparCarrinho)
        <div
            class="fixed inset-0 bg-zinc-600/50 dark:bg-zinc-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="w-full max-w-md bg-white dark:bg-zinc-800 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="md" class="text-center">Limpar Carrinho</flux:heading>
                </div>

                <div class="p-6">
                    <div class="flex justify-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <p class="text-zinc-600 dark:text-zinc-400 text-center mb-4">
                        Tem certeza que deseja remover <strong>todos os itens</strong> do carrinho?
                    </p>

                    <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-4 mb-6">
                        <div class="text-zinc-600 dark:text-zinc-300 text-sm">
                            <p class="mb-1"><strong>Total de itens:</strong> {{ $itensCarrinho->sum('qtd') }}</p>
                            <p><strong>Valor total:</strong> R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <flux:button wire:click="fecharModalLimparCarrinho" variant="ghost" class="w-full">
                            Cancelar
                        </flux:button>
                        <flux:button wire:click="limparCarrinho" variant="danger" class="w-full">
                            Limpar Carrinho
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>