<?php

use App\Livewire\Cardapio;
use App\Livewire\Categorias\CategoriaIndex;
use App\Livewire\Pratos\PratoIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard')->name('home');

Route::get('dashboard', Cardapio::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Rotas para Categorias
    Route::get('categorias', CategoriaIndex::class)->name('categorias.index');

    // Rotas para Pratos
    Route::get('pratos', PratoIndex::class)->name('pratos.index');
});

require __DIR__ . '/auth.php';
