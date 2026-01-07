<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Debug routes - hanya untuk development
if (app()->environment('local')) {
    Route::get('/debug/session', function (Request $request) {
        return [
            'session_id' => session()->getId(),
            'session_data' => session()->all(),
            'auth_check' => auth()->check(),
            'auth_user' => auth()->user(),
            'csrf_token' => csrf_token(),
            'cookies' => $request->cookies->all(),
        ];
    });

    Route::get('/debug/google-test', function () {
        try {
            $config = config('services.google');
            return [
                'google_config' => $config,
                'env_vars' => [
                    'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID'),
                    'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET') ? 'SET' : 'NOT SET',
                    'GOOGLE_REDIRECT_URL' => env('GOOGLE_REDIRECT_URL'),
                ],
                'socialite_available' => class_exists(\Laravel\Socialite\Facades\Socialite::class),
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    });
}