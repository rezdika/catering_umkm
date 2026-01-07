<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.pages.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('user.pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:8|confirmed'
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui!');
    }

    public function orders()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('orderItems.menu')->latest()->paginate(10);
        return view('user.pages.profile.orders', compact('user', 'orders'));
    }

    public function addresses()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->get();
        return view('user.pages.profile.addresses', compact('user', 'addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'notes' => 'nullable|string',
            'is_primary' => 'boolean'
        ]);

        if ($request->is_primary) {
            auth()->user()->addresses()->update(['is_primary' => false]);
        }

        auth()->user()->addresses()->create($request->all());

        return redirect()->route('profile.addresses')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function updateAddress(Request $request, $id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        
        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'notes' => 'nullable|string',
            'is_primary' => 'boolean'
        ]);

        if ($request->is_primary) {
            auth()->user()->addresses()->update(['is_primary' => false]);
        }

        $address->update($request->all());

        return redirect()->route('profile.addresses')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function deleteAddress($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        $address->delete();

        return redirect()->route('profile.addresses')->with('success', 'Alamat berhasil dihapus!');
    }

    public function settings()
    {
        $user = auth()->user();
        $settings = $user->setting ?? $user->setting()->create([]);
        return view('user.pages.profile.settings', compact('user', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'promo_notifications' => 'boolean',
            'language' => 'required|in:id,en',
            'timezone' => 'required|string',
            'dark_mode' => 'boolean'
        ]);

        $user = auth()->user();
        $settings = $user->setting ?? $user->setting()->create([]);
        
        $settings->update([
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications' => $request->has('sms_notifications'),
            'promo_notifications' => $request->has('promo_notifications'),
            'language' => $request->language,
            'timezone' => $request->timezone,
            'dark_mode' => $request->has('dark_mode')
        ]);

        return redirect()->route('profile.settings')->with('success', 'Pengaturan berhasil disimpan!');
    }
}