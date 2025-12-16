<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class IntegrationGuideController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url');
        $trackingEndpoint = $baseUrl . '/track/{code}';
        $conversionEndpoint = $baseUrl . '/api/conversions';
        $cookieDuration = SystemSetting::get('default_cookie_duration', 30);

        return view('admin.integration-guide.index', compact(
            'baseUrl',
            'trackingEndpoint',
            'conversionEndpoint',
            'cookieDuration'
        ));
    }
}
