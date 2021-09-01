<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Payment;

class SaveOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private array $event
    ) {}

    public function handle(): void
    {
        if (isset($this->event['subscription'])) {
            return;
        }

        if (! $user = Cashier::findBillable($this->event['customer'])) {
            return;
        }

        $lineItems = Cashier::stripe()
            ->checkout
            ->sessions
            ->allLineItems($this->event['id'], ['limit' => 5]);

        $receiptUrl = Cashier::stripe()->paymentIntents->retrieve(
            $this->event['payment_intent'], ['expand' => ['payment_method']]
        )->charges->data[0]->receipt_url;

        $user->orders()->create([
            'items' => collect($lineItems->toArray()['data'])->implode('description', ', '),
            'total' => $this->event['amount_total'],
            'receipt_url' => $receiptUrl,
        ]);
    }
}
