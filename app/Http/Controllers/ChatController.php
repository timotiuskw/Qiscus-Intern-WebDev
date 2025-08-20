<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $jsonPath = storage_path('app/extended_chat_data.json');

        if (file_exists($jsonPath)) {
            $chatData = json_decode(file_get_contents($jsonPath), true);
        } else {
            $chatData = null;
        }
        
        return view('chat.index', compact('chatData'));
    }
    
    public function sendMessage(Request $request)
    {
        try {
            Log::info('Send message request received', [
                'message' => $request->message,
                'room_id' => $request->room_id,
                'has_files' => $request->hasFile('files')
            ]);

            $request->validate([
                'message' => 'nullable|string|max:1000',
                'room_id' => 'required',
                'files.*' => 'nullable|file|max:10240'
            ]);

            if (empty($request->message) && !$request->hasFile('files')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Message or file is required'
                ], 400);
            }

            $media = null;
            if ($request->hasFile('files')) {
                $file = $request->file('files')[0];
                $media = $this->processUploadedFile($file);
                Log::info('File processed', ['media' => $media]);
            }

            $messageType = $media ? $this->getMessageType($media['mime_type']) : 'text';

            // Simulasi menambahkan pesan ke JSON nya
            $newMessage = [
                'id' => 'msg_' . uniqid(),
                'type' => $messageType,
                'message' => $request->message ?? '',
                'sender' => 'customer@mail.com',
                'timestamp' => now()->toISOString(),
                'status' => 'sent',
                'media' => $media
            ];

            Log::info('Message created', ['message' => $newMessage]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $newMessage
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', ['errors' => $e->errors()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Send message error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function processUploadedFile($file)
    {
        try {
            $directory = 'chat_media';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($directory, $filename, 'public');
            
            Log::info('File stored', ['path' => $path]);

            $media = [
                'url' => Storage::url($path),
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ];
            
            // Mengambil metadata file untuk display nantinya
            if (str_starts_with($file->getMimeType(), 'image/')) {
                try {
                    $imageSize = getimagesize($file->getRealPath());
                    $media['width'] = $imageSize[0] ?? null;
                    $media['height'] = $imageSize[1] ?? null;
                } catch (\Exception $e) {
                    Log::warning('Could not get image size', ['error' => $e->getMessage()]);
                }
                $media['thumbnail'] = $media['url'];
                
            } elseif (str_starts_with($file->getMimeType(), 'video/')) {
                $media['duration'] = 0; // Seharusnya extract video duration asli
                $media['thumbnail'] = 'https://picsum.photos/400/225';
                
            } elseif ($file->getMimeType() === 'application/pdf') {
                $media['pages'] = 1; // Seharusnya extract pages dari pdf asli
                $media['thumbnail'] = 'https://picsum.photos/200/260';
            }
            
            return $media;
            
        } catch (\Exception $e) {
            Log::error('File processing error:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    
    private function getMessageType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) return 'image';
        if (str_starts_with($mimeType, 'video/')) return 'video';
        if ($mimeType === 'application/pdf') return 'pdf';
        return 'file';
    }
}
