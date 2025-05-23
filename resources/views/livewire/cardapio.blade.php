<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Cardápio</h1>
            @auth
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Carrinho: <span
                            class="font-semibold text-orange-600 dark:text-orange-400">{{ $totalPedidosUsuario }}</span>
                        itens
                    </span>
                    <a href="{{ route('carrinho.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-orange-400"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Carrinho
                    </a>
                    <a href="{{ route('pedidos.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Meus Pedidos
                    </a>
                </div>
            @endauth
        </div>

        <!-- Filtros e Busca -->
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <label for="busca" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar
                        Pratos</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" wire:model.defer="termoBusca" id="busca"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 sm:text-sm"
                            placeholder="Digite o nome ou descrição do prato">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 md:w-1/3">
                    <div>
                        <label for="preco-de" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço
                            De</label>
                        <input type="number" wire:model.defer="filtroPrecoDe" id="preco-de" min="0" step="0.01"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 sm:text-sm">
                    </div>
                    <div>
                        <label for="preco-para" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço
                            Até</label>
                        <input type="number" wire:model.defer="filtroPrecoPara" id="preco-para" min="0" step="0.01"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 sm:text-sm">
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button wire:click="limparFiltros"
                    class="px-4 py-2 cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                    Limpar Filtros
                </button>
                <button wire:click="buscarPratos"
                    class="px-4 py-2 cursor-pointer text-sm font-medium text-white bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                    Buscar
                </button>
            </div>
        </div>

        <!-- Mensagem Flash -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded"
                role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded"
                role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Categorias - Visíveis apenas quando não está em modo de busca -->
        @if (!$modoBusca)
            <div class="mb-6 flex flex-wrap gap-2">
                @forelse ($categorias as $categoria)
                    <button wire:click="selecionarCategoria({{ $categoria->id }})"
                        class="px-4 py-2 cursor-pointer rounded-md {{ $categoriaAtiva == $categoria->id ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                        {{ $categoria->nome }}
                        <span
                            class="ml-1 px-1.5 py-0.5 text-xs rounded-full {{ $categoriaAtiva == $categoria->id ? 'bg-white text-indigo-600' : 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300' }}">
                            {{ $categoria->pratos->count() }}
                        </span>
                    </button>
                @empty
                    <div class="text-gray-500 dark:text-gray-400">Nenhuma categoria cadastrada</div>
                @endforelse
            </div>
        @endif

        <!-- Resultados da busca - Em modo de busca -->
        @if ($modoBusca)
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Resultados da Busca</h2>
                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ count($pratosEncontrados) }}
                        {{ count($pratosEncontrados) == 1 ? 'prato encontrado' : 'pratos encontrados' }}</span>
                </div>
                @if (count($pratosEncontrados) > 0)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Mostrando todos os pratos que correspondem aos
                        critérios de busca</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @if ($modoBusca)
                <!-- Exibição de pratos no modo de busca (sem agrupar por categorias) -->
                @forelse ($pratosEncontrados as $prato)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition duration-300"
                        wire:click="selecionarPrato({{ $prato->id }})">
                        <div class="p-4 h-full flex flex-col">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $prato->nome }}</h3>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $prato->categoria->nome }}</span>
                            </div>
                            <p class="mt-1 text-gray-600 dark:text-gray-300 flex-grow truncate">{{ $prato->desc }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">R$
                                    {{ number_format($prato->preco, 2, ',', '.') }}</span>
                                <button
                                    class=" cursor-pointer inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800">
                                    Ver detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-gray-500 dark:text-gray-400 text-center py-8">
                        Nenhum prato encontrado com os critérios de busca
                    </div>
                @endforelse
            @else
                <!-- Exibição normal de pratos por categoria -->
                @forelse ($categorias->firstWhere('id', $categoriaAtiva)?->pratos ?? [] as $prato)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition duration-300"
                        wire:click="selecionarPrato({{ $prato->id }})">
                        <div class="p-4 h-full flex flex-col">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $prato->nome }}</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-300 flex-grow truncate">{{ $prato->desc }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">R$
                                    {{ number_format($prato->preco, 2, ',', '.') }}</span>
                                <button
                                    class="cursor-pointer inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800">
                                    Ver detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-gray-500 dark:text-gray-400 text-center py-8">
                        Nenhum prato encontrado nesta categoria
                    </div>
                @endforelse
            @endif
        </div>

        @if ($pratoSelecionado)
            <!-- Modal de detalhes do prato -->
            <div
                class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 flex items-center justify-center z-50">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pratoSelecionado->nome }}</h3>
                            <button wire:click="fecharDetalhesPrato"
                                class="text-gray-500 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600 dark:text-gray-300">{{ $pratoSelecionado->desc }}</p>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">Categoria:
                                {{ $pratoSelecionado->categoria->nome }}
                            </p>
                        </div>
                        <div class="mt-6 flex justify-between items-center">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">R$
                                {{ number_format($pratoSelecionado->preco, 2, ',', '.') }}</span>
                            <button wire:click="adicionarAoPedido({{ $pratoSelecionado->id }})"
                                class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-orange-400 dark:focus:ring-offset-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($categorias->isEmpty() && !$modoBusca)
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                            Não há categorias cadastradas no sistema. Adicione categorias e pratos para visualizá-los no
                            cardápio.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($modoBusca && count($pratosEncontrados) == 0)
            <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            Nenhum prato encontrado com os critérios de busca informados. Tente outros termos ou remova os
                            filtros.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>