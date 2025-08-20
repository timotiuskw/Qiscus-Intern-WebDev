<div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
    <div class="flex items-center space-x-3">
        <!-- Hamburger untuk mobile -->
        <button id="toggleSidebar" 
                type="button"
                class="lg:hidden w-9 h-9 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                aria-label="Open sidebar">
            <i class="fas fa-bars text-base"></i>
        </button>
        
        <!-- Room info -->
        <div class="flex items-center space-x-3">
            <div class="relative">
                <img src="{{ $room['image_url'] ?? 'https://picsum.photos/seed/room/100/100' }}" 
                    alt="Room Image" 
                    class="w-10 h-10 rounded-full object-cover ring-2 ring-blue-500 ring-opacity-30">
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="font-semibold text-gray-900 truncate">{{ $room['name'] ?? 'Unknown Room' }}</h1>
            </div>
        </div>
    </div>
</div>