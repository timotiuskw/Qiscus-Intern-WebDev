<script>
$(document).ready(function() {
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Debug: Check if elements exist
    console.log('Chat elements check:', {
        toggleButton: $('#toggleSidebar').length,
        overlay: $('#sidebarOverlay').length,
        sidebar: $('#mobileSidebar').length,
        closeButton: $('#closeSidebar').length,
        messageForm: $('#messageForm').length,
        messageInput: $('#messageInput').length,
        messagesContainer: $('#messagesContainer').length
    });

    // Mobile sidebar functionality
    $(document).on('click', '#toggleSidebar', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Toggle sidebar clicked');
        openMobileSidebar();
    });

    $(document).on('click', '#closeSidebar', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Close sidebar clicked');
        closeMobileSidebar();
    });

    // Close sidebar when clicking overlay
    $(document).on('click', '#sidebarOverlay', function(e) {
        if (e.target === this) {
            console.log('Overlay clicked');
            closeMobileSidebar();
        }
    });

    // Close sidebar with escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$('#sidebarOverlay').hasClass('hidden')) {
            console.log('Escape key pressed');
            closeMobileSidebar();
        }
    });

    function openMobileSidebar() {
        console.log('Opening mobile sidebar...');
        
        // Show overlay
        $('#sidebarOverlay').removeClass('hidden');
        
        // Force reflow
        $('#sidebarOverlay')[0].offsetHeight;
        
        // Add classes with slight delay for animation
        setTimeout(() => {
            $('#sidebarOverlay').addClass('opacity-100');
            $('#mobileSidebar').removeClass('-translate-x-full').addClass('translate-x-0');
        }, 10);
        
        // Prevent body scroll
        $('body').addClass('overflow-hidden');
        
        console.log('Sidebar opened');
    }

    function closeMobileSidebar() {

        // Remove transform classes
        $('#mobileSidebar').removeClass('translate-x-0').addClass('-translate-x-full');
        $('#sidebarOverlay').removeClass('opacity-100');
        
        // Hide overlay after animation
        setTimeout(() => {
            $('#sidebarOverlay').addClass('hidden');
        }, 300);
        
        // Restore body scroll
        $('body').removeClass('overflow-hidden');

    }

    function scrollToBottom() {
        const container = $('#messagesContainer');
        if (container.length) {
            container.animate({
                scrollTop: container[0].scrollHeight
            }, 300);
        }
    }
    
    // Initial scroll to bottom
    scrollToBottom();

    // Fungsi untuk menambahkan chat baru sementara ke website
    function appendMessage(messageData) {
        console.log('Appending message:', messageData);
        
        const isCurrentUser = messageData.sender === 'customer@mail.com';
        const messageTime = new Date().toLocaleTimeString('en-US', { 
            hour12: false, 
            hour: '2-digit', 
            minute: '2-digit' 
        });

        let mediaContent = '';
        if (messageData.media && messageData.type !== 'text') {
            switch (messageData.type) {
                case 'image':
                    mediaContent = `
                        <div class="image-message cursor-pointer group mb-2" 
                             data-image="${messageData.media.url}" 
                             data-caption="${messageData.message || messageData.media.filename}">
                            <div class="relative overflow-hidden rounded-md">
                                <img src="${messageData.media.url}" 
                                     alt="${messageData.media.filename}"
                                     class="block w-full h-auto object-cover transition-transform duration-200 group-hover:scale-105"
                                     style="max-width: 100%; max-height: 200px;">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case 'video':
                    mediaContent = `
                        <div class="video-message w-full mb-2">
                            <div class="relative rounded-md overflow-hidden bg-black shadow-sm">
                                <video controls 
                                       poster="${messageData.media.thumbnail || ''}"
                                       class="block w-full h-auto"
                                       style="min-width: 0; max-width: 100%; min-height: 160px;">
                                    <source src="${messageData.media.url}" type="${messageData.media.mime_type}">
                                    <p class="text-white p-4 text-center">Your browser does not support the video tag.</p>
                                </video>
                            </div>
                        </div>
                    `;
                    break;
                case 'pdf':
                    mediaContent = `
                        <div class="pdf-message mb-2">
                            <a href="${messageData.media.url}" 
                               target="_blank" 
                               class="flex items-center p-3 bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-200 group no-underline">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-700 rounded flex items-center justify-center mr-3">
                                    <i class="fas fa-file-pdf text-white"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate">
                                        ${messageData.media.filename}
                                    </p>
                                    <div class="flex items-center text-xs text-blue-100 mt-1">
                                        <span>${(messageData.media.size / 1024 / 1024).toFixed(1)} MB</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-2">
                                    <i class="fas fa-download text-blue-100 group-hover:text-white"></i>
                                </div>
                            </a>
                        </div>
                    `;
                    break;
            }
        }

        const messageHtml = `
            <div class="flex justify-end message-animate-right">
                <div class="flex items-start space-x-2 max-w-xs lg:max-w-md">
                    <div class="flex flex-col items-end w-full">
                        <div class="rounded-lg shadow-sm bg-blue-500 text-white ${messageData.type !== 'text' ? 'p-2' : 'px-3 py-2'}">
                            ${mediaContent}
                            ${messageData.message ? `<p class="text-sm leading-relaxed ${mediaContent ? 'px-1 pt-2' : ''}">${messageData.message}</p>` : ''}
                        </div>
                        <div class="mt-1 px-1">
                            <span class="text-xs text-gray-400">
                                ${messageTime}
                                <i class="fas fa-check text-gray-400 ml-1"></i>
                            </span>
                        </div>
                    </div>
                    <div class="w-6 h-6 flex-shrink-0">
                        <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-medium">C</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#messagesContainer').append(messageHtml);
        scrollToBottom();
    }

    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        
        const messageInput = $('#messageInput');
        const fileInput = $('#fileInput')[0];
        const message = messageInput.val().trim();
        
        console.log('Message data:', {
            message: message,
            hasFiles: fileInput.files && fileInput.files.length > 0,
            fileCount: fileInput.files ? fileInput.files.length : 0
        });
        
        if (!message && (!fileInput.files || fileInput.files.length === 0)) {
            console.log('Tidak ada pesan atau files untuk dikirim');
            alert('Silakan masukkan pesan atau pilih file untuk dikirim.');
            return;
        }
        
        const formData = new FormData();
        formData.append('message', message);
        formData.append('room_id', {{ $room['id'] ?? 12456 }});
        
        if (fileInput.files && fileInput.files.length > 0) {
            formData.append('files[]', fileInput.files[0]);
            console.log('File attached:', {
                name: fileInput.files[0].name,
                size: fileInput.files[0].size,
                type: fileInput.files[0].type
            });
        }
        
        // Tambah Loading State saat mengirim pesan
        const sendButton = $('#sendMessageBtn');
        const originalHtml = sendButton.html();
        sendButton.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        
        console.log('Sending AJAX request to /chat/send');
        
        $.ajax({
            url: '/chat/send',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    messageInput.val('');
                    fileInput.value = '';
                    $('#selectedFile').addClass('hidden');
                    
                    // Tambahkan pesan ke chat
                    appendMessage(response.data);
                } else {
                    alert('Failed to send message: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'Failed to send message. ';
                
                if (xhr.status === 419) {
                    errorMessage += 'Session expired. Please refresh the page.';
                } else if (xhr.status === 422) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        errorMessage += Object.values(errors).flat().join(', ');
                    } else {
                        errorMessage += 'Validation failed.';
                    }
                } else if (xhr.status === 404) {
                    errorMessage += 'Route not found. Please check your server configuration.';
                } else if (xhr.status >= 500) {
                    errorMessage += 'Server error. Please try again later.';
                } else {
                    errorMessage += xhr.responseJSON?.message || 'Unknown error occurred.';
                }
                
                alert(errorMessage);
            },
            complete: function() {
                sendButton.html(originalHtml).prop('disabled', false);
                console.log('AJAX request completed');
            }
        });
    });

    // Fungsi untuk meng-attach file di chat
    $(document).on('click', '#attachButton', function(e) {
        e.preventDefault();
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            
            $('#selectedFileName').text(`${fileName} (${fileSize} MB)`);
            $('#selectedFile').removeClass('hidden');
        }
    });

    $('#removeFile').on('click', function() {
        $('#fileInput').val('');
        $('#selectedFile').addClass('hidden');
        console.log('File removed');
    });

    // Fungsi Modal Image
    $(document).on('click', '.image-message', function(e) {
        e.preventDefault();
        const imageUrl = $(this).data('image');
        const caption = $(this).data('caption');
        
        $('#modalImage').attr('src', imageUrl).attr('alt', caption);
        $('#modalCaption').text(caption);
        $('#imageModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    $(document).on('click', '#closeImageModal', function(e) {
        e.preventDefault();
        e.stopPropagation();
        closeImageModal();
    });

    // Untuk menutup modal tanpa X
    $(document).on('click', '#imageModal', function(e) {
        if (e.target === this || $(e.target).closest('#modalImage, #modalCaption').length === 0) {
            closeImageModal();
        }
    });

    // Untuk menutup modal ketika pencet Escape
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$('#imageModal').hasClass('hidden')) {
            closeImageModal();
        }
    });

    function closeImageModal() {
        $('#imageModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#modalImage').attr('src', '');
    }

    // Untuk menyembunyikan tombol play ketika video sedang berjalan
    $(document).on('play', 'video', function() {
        $(this).siblings('.video-overlay').hide();
    });

    $(document).on('pause', 'video', function() {
        $(this).siblings('.video-overlay').show();
    });

    // Untuk menghandle enter key to send message
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#messageForm').submit();
        }
    });

    // Handle mobile viewport height changes
    function handleViewportChange() {
        if (window.innerWidth <= 1024) {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }
    }
    
    handleViewportChange();
    
    $(window).on('resize orientationchange', function() {
        setTimeout(handleViewportChange, 100);
        setTimeout(scrollToBottom, 200);
    });
});
</script>