<div class="bg-white border-t border-gray-200 p-4">
    <form id="messageForm" class="flex items-center space-x-3">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room['id'] ?? 12456 }}">
        
        <!-- File upload -->
        <div class="relative">
            <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf" multiple>
            <button type="button" 
                    id="attachButton"
                    class="w-10 h-10 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full flex items-center justify-center transition-colors" 
                    title="Attach file">
                <i class="fas fa-paperclip"></i>
            </button>
        </div>
        
        <!-- Message input -->
        <div class="flex-1 relative">
            <input type="text" 
                   id="messageInput"
                   name="message" 
                   placeholder="Type a message..." 
                   autocomplete="off"
                   minlength="1"
                   maxlength="1000"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
        </div>
        
        <!-- Send button -->
        <button type="submit" 
                id="sendMessageBtn"
                class="w-12 h-12 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95"
                title="Send message">
            <i class="fas fa-paper-plane text-sm"></i>
        </button>
    </form>
    
    <!-- File preview -->
    <div id="selectedFile" class="hidden mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-paperclip text-blue-500"></i>
                <span id="selectedFileName" class="text-sm text-blue-700 font-medium"></span>
            </div>
            <button type="button" id="removeFile" class="text-red-500 hover:text-red-700 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>