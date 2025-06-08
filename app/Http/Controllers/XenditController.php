<?php

namespace App\Http\Controllers;

use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class XenditController extends Controller
{
    protected $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    /**
     * Create a new invoice
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createInvoice(Request $request)
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'description' => 'required|string',
                'customer_name' => 'required|string',
                'customer_email' => 'required|email',
                'items' => 'array',
                'fees' => 'array',
            ]);

            $data = array_merge($validated, [
                'external_id' => 'INV-' . Str::random(10),
                'success_url' => route('payment.success'),
                'failure_url' => route('payment.failure'),
            ]);

            $invoice = $this->xenditService->createInvoice($data);

            return response()->json([
                'success' => true,
                'data' => $invoice,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Xendit webhook
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->all();
            
            // Verify webhook signature
            $callbackToken = config('xendit.callback_token');
            $xenditSignature = $request->header('x-callback-token');
            
            if ($xenditSignature !== $callbackToken) {
                throw new \Exception('Invalid webhook signature');
            }

            // Handle different webhook events
            switch ($payload['status']) {
                case 'PAID':
                    // Handle successful payment
                    // Update your database, send notifications, etc.
                    break;
                case 'EXPIRED':
                    // Handle expired payment
                    break;
                case 'FAILED':
                    // Handle failed payment
                    break;
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get invoice details
     *
     * @param string $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoice(string $invoiceId)
    {
        try {
            $invoice = $this->xenditService->getInvoice($invoiceId);
            
            return response()->json([
                'success' => true,
                'data' => $invoice,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
} 