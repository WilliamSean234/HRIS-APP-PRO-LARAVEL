<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    
    /**
     * Konstanta yang menentukan rute kemana user akan di-redirect setelah login.
     * Diubah menjadi '/index' sesuai permintaan.
     */
    public const HOME = '/index'; 

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // ... (sisanya dari boot method)
    }
}