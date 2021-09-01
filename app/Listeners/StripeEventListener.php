<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Jobs\SaveOrder;
use Laravel\Cashier\Events\WebhookReceived;

final class StripeEventListener
{
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            dispatch(new SaveOrder($event->payload['data']['object']));
        }
    }
}
