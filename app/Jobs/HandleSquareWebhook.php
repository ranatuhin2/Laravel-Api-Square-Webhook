<?php

namespace App\Jobs;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleSquareWebhook extends SpatieProcessWebhookJob implements ShouldQueue
{
    public function handle(): void
    {
        $payload = $this->webhookCall->payload;
        $payment = $payload['data']['object']['payment'] ?? null;

        if ($payment) {
            $orderId   = $payment['order_id'] ?? null;
            $paymentId = $payment['id'] ?? null;
            $status    = strtoupper($payment['status'] ?? 'UNKNOWN'); // COMPLETED, FAILED, etc.
            $amount    = $payment['amount_money']['amount'] ?? 0;

            // Convert Square status to local status
            $finalStatus = match ($status) {
                'COMPLETED' => 'success',
                'FAILED', 'CANCELED' => 'failed',
                'PENDING', 'APPROVED' => 'pending',
                default => 'unknown',
            };

            //Store or update order
            Order::updateOrCreate(
                ['order_id' => $orderId],
                [
                    'payment_id' => $paymentId,
                    'amount'     => $amount,
                    'status'     => $finalStatus,
                ]
            );

            Log::info("Stored Square Order {$orderId} with status: {$finalStatus}");
        } else {
            Log::warning('No payment object in webhook payload');
        }
    }
}
