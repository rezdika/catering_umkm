<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role === 'admin_keuangan') {
                return redirect()->route('admin.finance.dashboard');
            } elseif (auth()->user()->role === 'staff_dapur') {
                return redirect()->route('admin.kitchen.dashboard');
            } elseif (auth()->user()->role === 'kurir') {
                return redirect()->route('admin.kurir.dashboard');
            }
            
            return redirect()->route('beranda');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function redirectToGoogle()
    {
        try {
            \Log::info('Google OAuth redirect initiated');
            return Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
        } catch (\Exception $e) {
            \Log::error('Google OAuth redirect error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Tidak dapat menghubungkan ke Google. Silakan coba lagi.');
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            \Log::info('Google OAuth Callback - User Data:', [
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email
            ]);
            
            // Cari user berdasarkan email atau google_id
            $user = User::where('email', $googleUser->email)
                       ->orWhere('google_id', $googleUser->id)
                       ->first();
            
            if ($user) {
                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'email_verified_at' => now()
                    ]);
                    \Log::info('Updated existing user with Google ID: ' . $user->email);
                }
                
                // Pastikan user aktif
                if (!$user->is_active) {
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
                }
            } else {
                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 'customer',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'password' => null // Google users don't need password
                ]);
                \Log::info('Created new user from Google: ' . $user->email);
            }

            // Login user dengan remember token
            Auth::login($user, true);
            
            // Regenerate session untuk keamanan
            request()->session()->regenerate();
            
            \Log::info('User logged in successfully via Google: ' . $user->email . ' (Role: ' . $user->role . ')');
            
            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
            } elseif ($user->role === 'admin_keuangan') {
                return redirect()->route('admin.finance.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
            } elseif ($user->role === 'staff_dapur') {
                return redirect()->route('admin.kitchen.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
            } elseif ($user->role === 'kurir') {
                return redirect()->route('admin.kurir.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
            }
            
            // Default redirect untuk customer
            return redirect()->route('beranda')->with('success', 'Login Google berhasil! Selamat datang, ' . $user->name . '!');
            
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Log::error('Google OAuth Invalid State: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Sesi login Google telah berakhir. Silakan coba lagi.');
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'is_active' => true
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}