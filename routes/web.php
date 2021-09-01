<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('cashier.webhook');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
    $orders = $request->user()->orders()->latest()->get();

    return view('dashboard', compact('orders'));
})->name('dashboard');

Route::view('/product', 'product')->name('product');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', function (Request $request) {
        return $request->user()
            // ->collectTaxIds()
            ->checkout('price_1JRkJk4MjUVeuXeN0GuUT7CF', [
                'success_url' => route('dashboard').'?checkout=success',
                'cancel_url' => route('product').'?checkout=cancelled',
            ]);
    })->name('checkout');

    Route::get('/subscription', function (Request $request) {
        if ($subscription = $request->user()->subscription()) {
            $invoices = $subscription->invoices();
            $upcomingInvoice = $subscription->upcomingInvoice();
        } else {
            $invoices = [];
            $upcomingInvoice = null;
        }

        return view('subscription', compact('invoices', 'upcomingInvoice'));
    })->name('subscription');

    Route::get('/subscribe/{price}', function (Request $request, $price) {
        return $request->user()
            ->newSubscription('default', $price)
            ->checkout([
                'success_url' => route('subscription').'?checkout=success',
                'cancel_url' => route('subscription').'?checkout=cancelled',
            ]);
    })->name('subscribe');

    Route::get('/swap/{price}', function (Request $request, $price) {
        $request->user()->subscription()->swap($price);

        return redirect()->route('subscription');
    })->name('swap');

    Route::get('/invoice/{invoice}/download', function (Request $request, $invoice) {
        return $request->user()->downloadInvoice($invoice, [
            'vendor' => 'Larashop',
            'street' => 'Rainbow Road 1',
            'location' => '1000 Little Rock, United States',
            'phone' => '+998877665544',
            'email' => 'info@example.com',
            'url' => 'https://larashop.com',
        ], 'larashop-invoice');
    })->name('invoice.download');

    Route::get('/invoice/upcoming/{price?}', function (Request $request, $price = null) {
        if ($price) {
            $invoice = $request->user()->subscription()->previewInvoice($price);
        } else {
            $invoice = $request->user()->subscription()->upcomingInvoice();
        }

        return $invoice->downloadAs('larashop-invoice', [
            'vendor' => 'Larashop',
            'street' => 'Rainbow Road 1',
            'location' => '1000 Little Rock, United States',
            'phone' => '+998877665544',
            'email' => 'info@example.com',
            'url' => 'https://larashop.com',
        ]);
    })->name('invoice.upcoming');

    Route::get('/subscribe-custom', function (Request $request) {
        return $request->user()
            ->newSubscription('default')
            ->price([
                'price_data' => [
                    'product' => 'prod_K7kDWYmH0opBRP',
                    'tax_behavior' => 'inclusive',
                    'currency' => 'EUR',
                    'recurring' => [
                        'interval' => 'month',
                    ],
                    'unit_amount' => $request->user()->rawBasicAmount(),
                ],
            ])
            ->checkout([
                'success_url' => route('subscription').'?checkout=success',
                'cancel_url' => route('subscription').'?checkout=cancelled',
            ]);
    })->name('subscribe.custom');
});
