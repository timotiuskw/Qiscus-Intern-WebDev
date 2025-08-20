<div class="video-message w-full">
    <div class="relative rounded-md overflow-hidden bg-black shadow-sm">
        <video controls 
               poster="{{ $media['thumbnail'] }}"
               class="block w-full h-auto"
               controlsList="nodownload"
               style="min-width: 0; max-width: 100%; min-height: 160px;">
            <source src="{{ $media['url'] }}" type="{{ $media['mime_type'] }}">
            <p class="text-white p-4 text-center">Your browser does not support the video tag.</p>
        </video>
    </div>
</div>