<div class="image-message cursor-pointer group" 
     data-image="{{ $media['url'] }}" 
     data-caption="{{ $comment['message'] ?? $media['filename'] }}">
    
    <div class="relative overflow-hidden rounded-md">
        <img src="{{ $media['thumbnail'] ?? $media['url'] }}" 
             alt="{{ $media['filename'] }}"
             class="block w-full h-auto object-cover transition-transform duration-200 group-hover:scale-105"
             style="max-width: 100%; max-height: 60vh;">
        
        <!-- Hover overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center">
            <i class="fas fa-search-plus text-white text-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
        </div>
    </div>
</div>