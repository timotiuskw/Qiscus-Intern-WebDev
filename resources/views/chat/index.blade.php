@extends('chat.layout')

@section('title', 'Chat Room - Qiscus')

@section('content')
@php
    // Handle null or invalid data
    $room = null;
    $participants = [];
    $comments = [];
    
    if ($chatData && isset($chatData['results']) && !empty($chatData['results'])) {
        $result = $chatData['results'][0]; // Mengambil data pertama dari hasil
        $room = $result['room'] ?? null;
        $participants = $room['participant'] ?? [];
        $comments = $result['comments'] ?? [];
    }
    
    // Fallback jika tidak ada JSON data
    if (!$room) {
        $room = [
            'id' => 12456,
            'name' => 'Chat Room',
            'image_url' => 'https://picsum.photos/seed/default/100/100'
        ];
        $participants = [
            [
                'id' => 'customer@mail.com',
                'name' => 'You',
                'role' => 2
            ]
        ];
    }
@endphp

<!-- Desktop Layout -->
<div class="hidden lg:flex h-screen bg-gray-100 overflow-hidden">
    <!-- Desktop Sidebar -->
    @include('chat.sidebar', compact('room', 'participants'))
    
    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col">
        <!-- Chat Header -->
        @include('chat.header', compact('room', 'participants'))
        
        <!-- Messages Container -->
        @include('chat.messages', compact('comments', 'participants'))
        
        <!-- Message Input -->
        @include('chat.input', compact('room'))
    </div>
</div>

<!-- Mobile Layout (below lg) -->
<div class="lg:hidden flex flex-col full-height bg-gray-100">
    <!-- Mobile Sticky Header -->
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200">
        @include('chat.header', compact('room', 'participants'))
    </div>
    
    <!-- Mobile Messages Container -->
    <div class="flex-1 overflow-y-auto">
        @include('chat.messages', compact('comments', 'participants'))
    </div>
    
    <!-- Mobile Sticky Input -->
    <div class="sticky bottom-0 z-20 bg-white border-t border-gray-200">
        @include('chat.input', compact('room'))
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
@include('chat.mobile-sidebar', compact('room', 'participants'))

@push('scripts')
@include('chat.scripts')
@endpush
@endsection