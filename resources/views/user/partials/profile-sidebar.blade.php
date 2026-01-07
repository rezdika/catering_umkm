<!-- Profile Sidebar -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <!-- Profile Avatar -->
    <div class="text-center mb-6">
        <div class="w-20 h-20 bg-brand-red rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h3 class="font-bold text-lg text-gray-900">{{ $user->name }}</h3>
        <p class="text-gray-500 text-sm">{{ ucfirst($user->role) }}</p>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="space-y-2">
        <a href="{{ route('profile.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('profile.index') ? 'text-white bg-brand-red' : 'text-gray-700 hover:bg-gray-100' }} rounded-md">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Informasi Profile
        </a>
        <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('profile.edit') ? 'text-white bg-brand-red' : 'text-gray-700 hover:bg-gray-100' }} rounded-md">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Profile
        </a>
        <a href="{{ route('profile.orders') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('profile.orders') ? 'text-white bg-brand-red' : 'text-gray-700 hover:bg-gray-100' }} rounded-md">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            Pesanan Saya
        </a>
        <a href="{{ route('profile.addresses') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('profile.addresses') ? 'text-white bg-brand-red' : 'text-gray-700 hover:bg-gray-100' }} rounded-md">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Alamat
        </a>
        <a href="{{ route('profile.settings') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('profile.settings') ? 'text-white bg-brand-red' : 'text-gray-700 hover:bg-gray-100' }} rounded-md">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Pengaturan
        </a>
    </nav>
</div>