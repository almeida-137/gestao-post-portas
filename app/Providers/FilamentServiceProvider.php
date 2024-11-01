<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::serving(function () {
        //     // Verifica se o usuário está autenticado e é do tipo 'interno'
        //     if (auth()->check() && auth()->user()->type === 'administrador') {
        //         Filament::registerNavigationItems([
        //             NavigationItem::make('aa') // Nome do botão
        //                 ->url('/rota-interna') // URL para onde o botão aponta
        //                 ->icon('heroicon-o-document'), // Ícone do botão
        //         ]);
        //     }
        // });
    }
}
