<x-mail::message>
# Enrollment Approved

Hello {{ $enrollment->user->name }},

Great news! Your enrollment request for **{{ $enrollment->program->name }}** has been approved.

## Program Details
- **Type:** {{ ucfirst($enrollment->program->program_type) }}
- **Commission:** {{ $enrollment->program->commission_type === 'percentage' ? $enrollment->program->commission_amount . '%' : '$' . number_format($enrollment->program->commission_amount, 2) }}

You can now start creating tracking links and promoting products from this program.

<x-mail::button :url="route('affiliate.links.create')">
Create Tracking Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
