<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        if (!Cache::has('users')) {
            Cache::put('users', [
                ['id' => 1, 'name' => 'Антон', 'email' => 'anton-pavlov@mail.ru'],
                ['id' => 2, 'name' => 'Даниил', 'email' => 'dan-krech@mail.ru'],
                ['id' => 3, 'name' => 'Олег', 'email' => 'oleg-skab@mail.ru'],
                ['id' => 4, 'name' => 'Максим', 'email' => 'max-z@mail.ru']
            ]);
        }
    }
}
