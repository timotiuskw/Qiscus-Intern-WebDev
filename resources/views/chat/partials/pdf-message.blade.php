<div class="pdf-message">
    <a href="{{ $media['url'] }}" 
       target="_blank" 
       class="flex items-center p-3 {{ $isCurrentUser ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-100 hover:bg-gray-200' }} rounded-md transition-colors duration-200 group no-underline">
        
        <div class="flex-shrink-0 w-10 h-10 {{ $isCurrentUser ? 'bg-blue-700' : 'bg-red-500' }} rounded flex items-center justify-center mr-3">
            <i class="fas fa-file-pdf text-white"></i>
        </div>
        
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium {{ $isCurrentUser ? 'text-white' : 'text-gray-900' }} truncate">
                {{ $media['filename'] }}
            </p>
            <div class="flex items-center text-xs {{ $isCurrentUser ? 'text-blue-100' : 'text-gray-500' }} mt-1">
                <span>{{ number_format(($media['size'] ?? 0) / 1024 / 1024, 1) }} MB</span>
                @if(isset($media['pages']))
                    <span class="mx-1">•</span>
                    <span>{{ $media['pages'] }} pages</span>
                @endif
            </div>
        </div>
        
        <div class="flex-shrink-0 ml-2">
            <i class="fas fa-download {{ $isCurrentUser ? 'text-blue-100' : 'text-gray-400' }} group-hover:{{ $isCurrentUser ? 'text-white' : 'text-gray-600' }}"></i>
        </div>
    </a>
</div>