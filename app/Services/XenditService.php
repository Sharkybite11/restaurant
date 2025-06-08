<?php

namespace App\Services;

use Xendit\Xendit;
use Illuminate\Support\Facades\Config;

class XenditService
{
    public function __construct()
    {
        Xendit::setApiKey(Config::get('xendit.api_key'));
    }

    /**
     * Create a new invoice
     *
     * @param array $data
     * @return array
     */
    public function createInvoice(array $data)
    {
        try {
            $params = [
                'external_id' => $data['external_id'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'invoice_duration' => 86400, // 24 hours in seconds
                'customer' => [
                    'given_names' => $data['customer_name'],
                    'email' => $data['customer_email'],
                ],
                'success_redirect_url' => $data['success_url'] ?? null,
                'failure_redirect_url' => $data['failure_url'] ?? null,
                'items' => $data['items'] ?? [],
                'fees' => $data['fees'] ?? [],
            ];

            return \Xendit\Invoice::create($params);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create Xendit invoice: ' . $e->getMessage());
        }
    }

    /**
     * Get invoice details
     *
     * @param string $invoiceId
     * @return array
     */
    public function getInvoice(string $invoiceId)
    {
        try {
            return \Xendit\Invoice::retrieve($invoiceId);
        } catch (\Exception $e) {
            throw new \Exception('Failed to retrieve Xendit invoice: ' . $e->getMessage());
        }
    }

    /**
     * Expire an invoice
     *
     * @param string $invoiceId
     * @return array
     */
    public function expireInvoice(string $invoiceId)
    {
        try {
            return \Xendit\Invoice::expire($invoiceId);
        } catch (\Exception $e) {
            throw new \Exception('Failed to expire Xendit invoice: ' . $e->getMessage());
        }
    }

    /**
     * Create a payment channel
     *
     * @param array $data
     * @return array
     */
    public function createPaymentChannel(array $data)
    {
        try {
            $params = [
                'type' => $data['type'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'currency' => $data['currency'] ?? 'PHP',
                'minimum_amount' => $data['minimum_amount'] ?? null,
                'maximum_amount' => $data['maximum_amount'] ?? null,
            ];

            return \Xendit\PaymentChannel::create($params);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create payment channel: ' . $e->getMessage());
        }
    }
} 