<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\TrackingEvent;
use App\Models\TrackingLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function track(Request $request, string $code): RedirectResponse|JsonResponse
    {
        $trackingLink = TrackingLink::where('unique_code', $code)
            ->with(['program', 'product'])
            ->first();

        if (!$trackingLink) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid tracking link.'], 404);
            }
            return redirect('/')->with('error', 'Invalid tracking link.');
        }

        // Check if program is active
        $program = $trackingLink->program;
        if (!$program || !$program->is_active) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Program is not active.'], 404);
            }
            return redirect('/')->with('error', 'Program is not active.');
        }

        // Record click event
        TrackingEvent::create([
            'tracking_link_id' => $trackingLink->id,
            'event_type' => 'click',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
            'metadata' => [
                'query_params' => $request->query(),
            ],
        ]);

        // Handle Pay Per View (PPV) program type
        if ($program->program_type === 'view') {
            $this->createConversionAndCommission($trackingLink, $program, $request, 'view');
        }

        // Determine redirect URL - priority: product URL > program default URL
        $redirectUrl = $trackingLink->product?->website_url ?? $program->default_url;

        if (empty($redirectUrl)) {
            // If no URL configured, show error
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Landing page URL not configured.'], 404);
            }
            return response('Landing page URL not configured. Please set a default URL on the program or product.', 404);
        }

        // Append tracking parameters for cookie setting
        $separator = str_contains($redirectUrl, '?') ? '&' : '?';
        $redirectUrl .= $separator . 'ref=' . $trackingLink->unique_code;

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Click tracked successfully.',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl);
    }

    public function conversion(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tracking_code' => ['required', 'string'],
            'order_id' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'type' => ['nullable', 'in:sale,lead'],
            'metadata' => ['nullable', 'array'],
        ]);

        $trackingLink = TrackingLink::where('unique_code', $validated['tracking_code'])
            ->with(['program'])
            ->first();

        if (!$trackingLink) {
            return response()->json(['message' => 'Invalid tracking code.'], 404);
        }

        $program = $trackingLink->program;
        if (!$program || !$program->is_active) {
            return response()->json(['message' => 'Program is not active.'], 404);
        }

        $conversionType = $validated['type'] ?? ($program->program_type === 'lead' ? 'lead' : 'sale');

        // Check if conversion already exists for this order
        if (!empty($validated['order_id'])) {
            $existingConversion = Conversion::whereHas('trackingEvent', function ($q) use ($trackingLink) {
                $q->where('tracking_link_id', $trackingLink->id);
            })->where('order_id', $validated['order_id'])->first();

            if ($existingConversion) {
                return response()->json([
                    'message' => 'Conversion already recorded for this order.',
                    'conversion' => $existingConversion,
                ], 409);
            }
        }

        $conversion = $this->createConversionAndCommission(
            $trackingLink,
            $program,
            $request,
            $conversionType,
            $validated['amount'],
            $validated['order_id'] ?? null,
            $validated['metadata'] ?? null
        );

        return response()->json([
            'message' => 'Conversion recorded successfully.',
            'conversion' => $conversion,
        ], 201);
    }

    private function createConversionAndCommission(
        TrackingLink $trackingLink,
        AffiliateProgram $program,
        Request $request,
        string $type,
        float $amount = 0,
        ?string $orderId = null,
        ?array $metadata = null
    ): Conversion {
        // Record conversion event
        $trackingEvent = TrackingEvent::create([
            'tracking_link_id' => $trackingLink->id,
            'event_type' => 'conversion',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
            'metadata' => array_merge($metadata ?? [], ['type' => $type, 'amount' => $amount]),
        ]);

        // Create conversion record
        $conversion = Conversion::create([
            'tracking_event_id' => $trackingEvent->id,
            'conversion_value' => $amount,
            'order_id' => $orderId,
            'conversion_data' => $metadata,
            'created_at' => now(),
        ]);

        // Calculate and create commission
        $commissionAmount = $program->calculateCommission($amount);

        Commission::create([
            'user_id' => $trackingLink->user_id,
            'conversion_id' => $conversion->id,
            'amount' => $commissionAmount,
            'status' => 'pending',
        ]);

        return $conversion;
    }
}
