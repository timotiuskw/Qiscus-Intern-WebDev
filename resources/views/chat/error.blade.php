<div class="h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center max-w-md mx-auto p-6">
        <div class="mb-6">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-700 mb-3">Tidak bisa memuat data chat</h2>
            <p class="text-gray-600 mb-4">
                Kami tidak dapat mengambil data chat. Ini mungkin disebabkan oleh:
            </p>
            <ul class="text-left text-gray-600 text-sm space-y-1 mb-6 bg-gray-50 p-4 rounded-lg">
                <li class="flex items-center"><i class="fas fa-wifi text-red-400 mr-2"></i> Masalah konektivitas jaringan</li>
                <li class="flex items-center"><i class="fas fa-server text-red-400 mr-2"></i> Server tidak tersedia sementara</li>
                <li class="flex items-center"><i class="fas fa-code text-red-400 mr-2"></i> Format respons tidak valid</li>
            </ul>
        </div>
        
        <div class="space-y-3">
            <button onclick="window.location.reload()" 
                    class="w-full px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                <i class="fas fa-redo mr-2"></i>
                Coba Lagi
            </button>
        </div>
    </div>
</div>