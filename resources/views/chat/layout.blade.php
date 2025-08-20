<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Chat - Qiscus')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        /* Custom scrollbar untuk chat */
        .chat-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .chat-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .chat-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        .chat-scroll::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Animation untuk pesan masuk */
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .message-animate-right { animation: slideInRight 0.3s ease-out; }
        .message-animate-left { animation: slideInLeft 0.3s ease-out; }
        
        /* Mobile sidebar animations */
        #sidebarOverlay {
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
        }
        
        #sidebarOverlay.opacity-100 {
            opacity: 1;
        }
        
        #mobileSidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        /* Prevent body scroll when sidebar is open */
        body.overflow-hidden {
            overflow: hidden;
        }
        
        /* Responsive untuk mobile */
        @media (max-width: 1023px) {
            .mobile-sidebar-open {
                overflow: hidden;
            }
        }
        
        /* Custom viewport units for mobile */
        :root {
            --vh: 1vh;
        }
        
        .full-height {
            height: calc(var(--vh, 1vh) * 100);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen">
        @yield('content')
    </div>
    
    @stack('scripts')
</body>
</html>