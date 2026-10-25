<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::firstOrCreate(['slug' => 'stripe'], [
            'name' => 'Stripe (Credit/Debit Cards)',
            'slug' => 'stripe',
            'type' => 'stripe',
            'description' => 'Accept Visa, Mastercard, American Express, and other major cards via Stripe.',
            'config' => [
                'publishable_key' => env('STRIPE_KEY'),
                'secret_key' => env('STRIPE_SECRET'),
                'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 500000.00,
            'fee_percentage' => 2.9,
            'fee_fixed' => 15.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 1,
            'icon' => 'fab fa-stripe',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'paypal'], [
            'name' => 'PayPal',
            'slug' => 'paypal',
            'type' => 'paypal',
            'description' => 'Pay with your PayPal account or credit/debit card via PayPal.',
            'config' => [
                'client_id' => env('PAYPAL_CLIENT_ID'),
                'client_secret' => env('PAYPAL_CLIENT_SECRET'),
                'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 100000.00,
            'fee_percentage' => 3.4,
            'fee_fixed' => 15.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 2,
            'icon' => 'fab fa-paypal',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'nlb_bank'], [
            'name' => 'NLB Bank (Card Payment)',
            'slug' => 'nlb_bank',
            'type' => 'bank_transfer',
            'description' => 'Pay with your NLB Bank card or any Macedonian bank card.',
            'config' => [
                'merchant_id' => env('NLB_MERCHANT_ID'),
                'secret_key' => env('NLB_SECRET_KEY'),
                'terminal_id' => env('NLB_TERMINAL_ID'),
                'return_url' => route('payment.callback', ['gateway' => 'nlb_bank']),
                'cancel_url' => route('payment.cancel', ['gateway' => 'nlb_bank']),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 500000.00,
            'fee_percentage' => 1.5,
            'fee_fixed' => 10.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 3,
            'icon' => 'fas fa-university',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'stopanska_banka'], [
            'name' => 'Stopanska Banka (Card Payment)',
            'slug' => 'stopanska_banka',
            'type' => 'bank_transfer',
            'description' => 'Pay with your Stopanska Banka card.',
            'config' => [
                'merchant_id' => env('STOPANSKA_MERCHANT_ID'),
                'secret_key' => env('STOPANSKA_SECRET_KEY'),
                'terminal_id' => env('STOPANSKA_TERMINAL_ID'),
                'return_url' => route('payment.callback', ['gateway' => 'stopanska_banka']),
                'cancel_url' => route('payment.cancel', ['gateway' => 'stopanska_banka']),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 500000.00,
            'fee_percentage' => 1.5,
            'fee_fixed' => 10.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 4,
            'icon' => 'fas fa-university',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'mnt_bank'], [
            'name' => 'MNT Bank (Card Payment)',
            'slug' => 'mnt_bank',
            'type' => 'bank_transfer',
            'description' => 'Pay with your MNT Bank card.',
            'config' => [
                'merchant_id' => env('MNT_MERCHANT_ID'),
                'secret_key' => env('MNT_SECRET_KEY'),
                'terminal_id' => env('MNT_TERMINAL_ID'),
                'return_url' => route('payment.callback', ['gateway' => 'mnt_bank']),
                'cancel_url' => route('payment.cancel', ['gateway' => 'mnt_bank']),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 500000.00,
            'fee_percentage' => 1.5,
            'fee_fixed' => 10.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 5,
            'icon' => 'fas fa-university',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'tutunska_banka'], [
            'name' => 'Tutunska Banka (Card Payment)',
            'slug' => 'tutunska_banka',
            'type' => 'bank_transfer',
            'description' => 'Pay with your Tutunska Banka card or bank transfer.',
            'config' => [
                'merchant_id' => env('TUTUNSKA_MERCHANT_ID'),
                'secret_key' => env('TUTUNSKA_SECRET_KEY'),
                'terminal_id' => env('TUTUNSKA_TERMINAL_ID'),
                'return_url' => route('payment.callback', ['gateway' => 'tutunska_banka']),
                'cancel_url' => route('payment.cancel', ['gateway' => 'tutunska_banka']),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 500000.00,
            'fee_percentage' => 1.5,
            'fee_fixed' => 10.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 6,
            'icon' => 'fas fa-university',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'sparkasse_bank'], [
            'name' => 'Sparkasse Bank Macedonia (Card Payment)',
            'slug' => 'sparkasse_bank',
            'type' => 'bank_transfer',
            'description' => 'Pay with your Sparkasse Bank Macedonia card.',
            'config' => [
                'merchant_id' => env('SPARKASSE_MERCHANT_ID'),
                'secret_key' => env('SPARKASSE_SECRET_KEY'),
                'terminal_id' => env('SPARKASSE_TERMINAL_ID'),
                'return_url' => route('payment.callback', ['gateway' => 'sparkasse_bank']),
                'cancel_url' => route('payment.cancel', ['gateway' => 'sparkasse_bank']),
            ],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 50.00,
            'max_amount' => 500000.00,
            'fee_percentage' => 1.5,
            'fee_fixed' => 10.00,
            'is_active' => true,
            'is_sandbox' => true,
            'sort_order' => 7,
            'icon' => 'fas fa-university',
        ]);

        PaymentMethod::firstOrCreate(['slug' => 'cash_on_delivery'], [
            'name' => 'Cash on Delivery',
            'slug' => 'cash_on_delivery',
            'type' => 'cash_on_delivery',
            'description' => 'Pay when you receive your order. Available for orders up to 50,000 MKD.',
            'config' => [],
            'supported_currencies' => ['MKD'],
            'supported_countries' => ['MK'],
            'min_amount' => 100.00,
            'max_amount' => 50000.00,
            'fee_percentage' => 0,
            'fee_fixed' => 150.00,
            'is_active' => true,
            'is_sandbox' => false,
            'sort_order' => 6,
            'icon' => 'fas fa-money-bill-wave',
        ]);
    }
}