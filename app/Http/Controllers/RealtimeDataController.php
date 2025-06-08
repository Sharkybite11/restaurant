<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RealtimeDataController extends Controller
{
    public function receiveData(Request $request)
    {
        try {
            $data = $request->all();
            
            // Log the received data
            Log::info('Received real-time data:', $data);
            
            // Broadcast the data to all connected clients
            broadcast(new \App\Events\RealtimeDataReceived($data))->toOthers();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Data received successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing real-time data: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error processing data'
            ], 500);
        }
    }
} 