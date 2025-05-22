<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Verify the callback token
        $callbackToken = config('services.xendit.callback_token');
        $xenditToken = $request->header('x-callback-token');

        if ($callbackToken !== $xenditToken) {
            Log::error('Invalid Xendit callback token', [
                'received_token' => $xenditToken,
                'expected_token' => $callbackToken
            ]);
            return response()->json(['error' => 'Invalid callback token'], 403);
        }

        $payload = $request->all();
        Log::info('Xendit webhook received', ['payload' => $payload]);

        // Handle different webhook events
        switch ($payload['status']) {
            case 'PAID':
                $this->handlePaidPayment($payload);
                break;
            case 'EXPIRED':
                $this->handleExpiredPayment($payload);
                break;
            case 'FAILED':
                $this->handleFailedPayment($payload);
                break;
            default:
                Log::info('Unhandled Xendit webhook status', ['status' => $payload['status']]);
        }

        return response()->json(['status' => 'success']);
    }

    private function handlePaidPayment($payload)
    {
        $order = Order::where('payment_id', $payload['id'])->first();
        
        if ($order) {
            $order->update([
                'status' => 'paid'
            ]);
            Log::info('Order marked as paid', ['order_id' => $order->id]);
        }
    }

    private function handleExpiredPayment($payload)
    {
        $order = Order::where('payment_id', $payload['id'])->first();
        
        if ($order) {
            $order->update([
                'status' => 'expired'
            ]);
            Log::info('Order payment expired', ['order_id' => $order->id]);
        }
    }

    private function handleFailedPayment($payload)
    {
        $order = Order::where('payment_id', $payload['id'])->first();
        
        if ($order) {
            $order->update([
                'status' => 'failed'
            ]);
            Log::info('Order payment failed', ['order_id' => $order->id]);
        }
    }
} 