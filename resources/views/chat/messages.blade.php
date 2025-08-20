<div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-2 bg-gray-50 chat-scroll">
    @forelse($comments as $index => $comment)
        @php
            $participant = collect($participants)->firstWhere('id', $comment['sender'] ?? '');
            $isCurrentUser = ($comment['sender'] ?? '') === 'customer@mail.com';
            $prevComment = $index > 0 ? $comments[$index - 1] : null;
            $showAvatar = $prevComment ? $prevComment['sender'] !== $comment['sender'] : true;
            $messageType = $comment['type'] ?? 'text';
            $media = $comment['media'] ?? null;
            
            $maxWidth = in_array($messageType, ['image', 'video']) ? 'max-w-sm lg:max-w-lg' : 'max-w-xs lg:max-w-md';
        @endphp
        
        <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }}">
            <div class="flex items-start space-x-2 {{ $maxWidth }}">
                @if(!$isCurrentUser)
                    <div class="w-6 h-6 flex-shrink-0">
                        @if($showAvatar)
                            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-medium">
                                    {{ strtoupper(substr($participant['name'] ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endif
                
                <div class="flex flex-col {{ $isCurrentUser ? 'items-end' : 'items-start' }} w-full">
                    @if(!$isCurrentUser && $showAvatar && ($participant['name'] ?? '') !== '')
                        <span class="text-xs text-gray-500 mb-1 px-1">{{ $participant['name'] }}</span>
                    @endif
                    
                    <div class="rounded-lg shadow-sm {{ $isCurrentUser ? 'bg-blue-500 text-white' : 'bg-white text-gray-800 border border-gray-200' }} {{ $messageType !== 'text' ? 'p-2' : 'px-3 py-2' }}">
                        @if($messageType === 'image' && $media)
                            @include('chat.partials.image-message', compact('media', 'comment', 'isCurrentUser'))
                        @elseif($messageType === 'video' && $media)
                            @include('chat.partials.video-message', compact('media', 'comment', 'isCurrentUser'))
                        @elseif($messageType === 'pdf' && $media)
                            @include('chat.partials.pdf-message', compact('media', 'comment', 'isCurrentUser'))
                        @endif
                        
                        @if(!empty($comment['message']))
                            <p class="text-sm leading-relaxed {{ $messageType !== 'text' ? 'px-1 pt-2' : '' }}">
                                {{ $comment['message'] ?? '' }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-1 px-1">
                        <span class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($comment['timestamp'] ?? now())->format('H:i') }}
                            @if($isCurrentUser)
                                @switch($comment['status'] ?? 'sent')
                                    @case('sent')
                                        <i class="fas fa-check text-gray-400 ml-1"></i>
                                        @break
                                    @case('delivered')
                                        <i class="fas fa-check-double text-gray-400 ml-1"></i>
                                        @break
                                    @case('read')
                                        <i class="fas fa-check-double text-blue-400 ml-1"></i>
                                        @break
                                @endswitch
                            @endif
                        </span>
                    </div>
                </div>
                
                @if($isCurrentUser)
                    <div class="w-6 h-6 flex-shrink-0">
                        @if($showAvatar)
                            <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-medium">K</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="flex items-center justify-center h-full">
            <div class="text-center text-gray-500">
                <i class="fas fa-comments text-4xl mb-3 opacity-30"></i>
                <p>No messages yet. Start the conversation!</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-4xl max-h-full">
            <button id="closeImageModal" 
                    type="button"
                    class="absolute -top-12 right-0 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-xl w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200 z-20">
                <i class="fas fa-times"></i>
            </button>
            
            <img id="modalImage" 
                 src="" 
                 alt="" 
                 class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-xl">
            
            <div id="modalCaption" 
                 class="absolute bottom-0 left-0 right-0 text-white text-center bg-black bg-opacity-50 rounded-b-lg p-3">
            </div>
        </div>
    </div>
</div>