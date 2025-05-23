<div> <!-- Cabeçalho -->
    <div class="bg-white dark:bg-zinc-800 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-zinc-600 dark:text-zinc-400 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <flux:heading size="lg">Meus Pedidos</flux:heading>
                </div>
                <div class="flex items-center space-x-4">
                    <flux:button href="{{ route('carrinho.index') }}" variant="primary" icon="shopping-cart"
                        wire:navigate>
                        Ver Carrinho
                    </flux:button>
                    <flux:button href="{{ route('cardapio') }}" variant="outline" icon="book-open" wire:navigate>
                        Ver Cardápio
                    </flux:button>
                </div>
            </div>
        </div>
    </div> <!-- Mensagens de Flash -->
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
    @endif <!-- Filtros -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 border border-zinc-200 dark:border-zinc-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <flux:input wire:model.live="search" label="Buscar"
                        placeholder="Buscar por número do pedido ou prato..." icon="magnifying-glass" />
                </div>
                <div>
                    <flux:input type="date" wire:model.live="dateFilter" id="dateFilter" label="Data" />
                </div>
                <div class="flex items-end">
                    <flux:button wire:click="clearFilters" variant="ghost" class="w-full">
                        Limpar Filtros
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($pedidosAgrupados->isEmpty()) <!-- Nenhum Pedido -->
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Nenhum pedido encontrado</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Você ainda não finalizou nenhum pedido.</p>
                <div class="mt-6">
                    <flux:button href="{{ route('cardapio') }}" variant="primary" wire:navigate>
                        Ver Cardápio
                    </flux:button>
                </div>
            </div>
        @else
            <!-- Lista de Pedidos -->
            <div class="space-y-6">
                @foreach($pedidosAgrupados as $numeroPedido => $itensPedido)
                    @php
                        $primeiroPedido = $itensPedido->first();
                        $valorTotal = $itensPedido->sum(function ($item) {
                            return $item->prato->preco * $item->qtd;
                        });
                    @endphp <div
                        class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <!-- Cabeçalho do Pedido -->
                        <div class="px-6 py-4 bg-zinc-100 dark:bg-zinc-700 border-b border-zinc-200 dark:border-zinc-600">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $numeroPedido }}</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        Finalizado em: {{ $primeiroPedido->finalizado_em->format('d/m/Y \à\s H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                                        R$ {{ number_format($valorTotal, 2, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $itensPedido->sum('qtd') }} {{ $itensPedido->sum('qtd') == 1 ? 'item' : 'itens' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Itens do Pedido -->
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($itensPedido as $item)
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                                {{ $item->prato->nome }}</h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $item->prato->desc }}</p>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Categoria:
                                                {{ $item->prato->categoria->nome }}</p>
                                        </div>
                                        <div class="flex items-center space-x-6">
                                            <div class="text-center">
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Qtd</p>
                                                <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $item->qtd }}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Preço Unit.</p>
                                                <p class="font-medium text-zinc-900 dark:text-zinc-100">R$
                                                    {{ number_format($item->prato->preco, 2, ',', '.') }}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Subtotal</p>
                                                <div
                                                    class="inline-flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900 px-2.5 py-0.5">
                                                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">R$
                                                        {{ number_format($item->prato->preco * $item->qtd, 2, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>@endforeach
            </div>
        @endif
    </div>
</div>