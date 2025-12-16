<x-mail::message>
# Payout Completed

Hello {{ $payout->user->name }},

Your payout request has been processed and completed.

## Payout Details
- **Amount:** ${{ number_format($payout->total_amount, 2) }}
- **Payment Method:** {{ ucfirst($payout->paymentMethod?->type ?? 'N/A') }}
- **Processed On:** {{ $payout->processed_at?->format('M d, Y H:i') ?? now()->format('M d, Y H:i') }}
@if($payout->transaction_id)
- **Transaction ID:** {{ $payout->transaction_id }}
@endif

The funds should arrive in your account according to your payment method's processing time.

<x-mail::button :url="route('affiliate.payouts.index')">
View Payout History
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
