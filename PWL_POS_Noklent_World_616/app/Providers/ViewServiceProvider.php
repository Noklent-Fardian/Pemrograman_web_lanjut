<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            
            $isLoggedIn = Auth::check();
            
            // Share user data only if authenticated
            $userData = null;
            if ($isLoggedIn) {
                $user = Auth::user();
                $userData = [
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'levelName' => $user->level->level_nama ?? 'User',
                    'levelKode' => $user->level->level_kode ?? 'user',
                ];
            }
            
            $view->with('isLoggedIn', $isLoggedIn);
            $view->with('userData', $userData);
        });
    }
}