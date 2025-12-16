<x-mail::message>
# Commission Approved

Hello {{ $commission->user->name }},

Your commission has been approved and added to your available balance.

## Commission Details
- **Amount:** ${{ number_format($commission->amount, 2) }}
- **Date:** {{ $commission->created_at->format('M d, Y') }}

Your current available balance is now ready for withdrawal.

<x-mail::button :url="route('affiliate.payouts.index')">
Request Payout
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
