<div id="sidebar" class="hidden lg:block lg:w-1/4 bg-white border-r border-gray-200 flex flex-col">

    <!-- Room Info -->
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <img src="{{ $room['image_url'] ?? 'https://picsum.photos/seed/room/100/100' }}" 
                     alt="Room Image" 
                     class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500 ring-opacity-30">
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900">{{ $room['name'] ?? 'Unknown Room' }}</h3>
                <p class="text-sm text-gray-500">Room #{{ $room['id'] ?? '0000' }}</p>
            </div>
        </div>
    </div>

    <!-- Participants -->
    <div class="flex-1 overflow-y-auto p-4">
        <h4 class="font-medium text-gray-900 mb-3 flex items-center">
            <i class="fas fa-users mr-2 text-blue-500"></i>
            Participants ({{ count($participants) }})
        </h4>
        
        <div class="space-y-3">
            @foreach($participants as $participant)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">
                                {{ strtoupper(substr($participant['name'] ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">
                                {{ $participant['name'] ?? 'Unknown User' }}
                                @if(($participant['id'] ?? '') === 'customer@mail.com')
                                    <span class="text-blue-500 text-xs">(You)</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $participant['role'] == 0 ? 'Admin' : ($participant['role'] == 1 ? 'Agent' : 'Customer') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>