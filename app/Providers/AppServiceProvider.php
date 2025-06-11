<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Chamado; // Importe o modelo Chamado
use App\Policies\ChamadoPolicy; // Importe a ChamadoPolicy
/*use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;*/

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        Chamado::class => ChamadoPolicy::class, // <-- Adicione esta linha
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
