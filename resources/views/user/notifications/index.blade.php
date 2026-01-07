@extends('user.main')

@section('title', 'Notifikasi')

@section('content')
<section class="py-16 bg-brand-light">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-brand-black">Notifikasi</h2>
                @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('user.notifications.read-all') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-brand-red text-white px-4 py-2 rounded-lg hover:bg-brand-black transition duration-300">
                        Tandai Semua Dibaca
                    </button>
                </form>
                @endif
            </div>

            @forelse($notifications as $notification)
            <div class="border-b border-gray-200 py-4 {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            @php
                                $type = $notification->data['type'] ?? 'default';
                                $iconClass = match($type) {
                                    'feedback_reply' => 'fas fa-comment-dots text-green-600',
                                    'contact_reply' => 'fas fa-reply text-brand-red',
                                    'order_status' => 'fas fa-shopping-bag text-blue-600',
                                    default => 'fas fa-bell text-gray-600'
                                };
                                $bgClass = match($type) {
                                    'feedback_reply' => 'bg-green-100',
                                    'contact_reply' => 'bg-brand-red bg-opacity-10',
                                    'order_status' => 'bg-blue-100',
                                    default => 'bg-gray-100'
                                };
                            @endphp
                            <div class="{{ $bgClass }} rounded-full p-2 mr-3">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-brand-black">{{ $notification->data['title'] ?? 'Notifikasi' }}</h4>
                                <p class="text-sm text-gray-600">{{ $notification->data['message'] ?? '' }}</p>
                            </div>
                        </div>
                        
                        @if(isset($notification->data['reply_message']))
                        <div class="ml-11 bg-gray-50 rounded p-3 mt-2">
                            <p class="text-sm text-gray-700">{{ $notification->data['reply_message'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($notification->data['order_number']))
                        <div class="ml-11 mt-2">
                            <a href="{{ route('user.orders.show', $notification->data['order_id']) }}" class="text-brand-red hover:text-brand-black text-sm font-medium">
                                Lihat Pesanan #{{ $notification->data['order_number'] }}
                            </a>
                        </div>
                        @endif
                        
                        <div class="ml-11 mt-2">
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if(!$notification->read_at)
                        <span class="bg-brand-red text-white text-xs px-2 py-1 rounded-full">Baru</span>
                        <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-brand-red hover:text-brand-black text-sm">
                                Tandai Dibaca
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-bell-slash text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">Belum ada notifikasi</p>
            </div>
            @endforelse

            @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection