<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\UpgradeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpgradeController extends Controller
{
    private UpgradeService $upgradeService;

    public function __construct(UpgradeService $upgradeService)
    {
        $this->upgradeService = $upgradeService;
    }

    /**
     * Show upgrade page
     */
    public function index()
    {
        $installedVersion = $this->upgradeService->getInstalledVersion();
        $latestVersion = $this->upgradeService->getLatestVersion();
        $needsUpgrade = $this->upgradeService->needsUpgrade();
        $pendingMigrations = $this->upgradeService->getPendingMigrations();
        $changes = $this->upgradeService->getChangesSinceInstalled();
        $requirements = $this->upgradeService->checkRequirements();
        $versionHistory = $this->upgradeService->getVersionHistory();

        return view('admin.upgrade.index', compact(
            'installedVersion',
            'latestVersion',
            'needsUpgrade',
            'pendingMigrations',
            'changes',
            'requirements',
            'versionHistory'
        ));
    }

    /**
     * Check upgrade status (AJAX)
     */
    public function check(): JsonResponse
    {
        return response()->json([
            'installed_version' => $this->upgradeService->getInstalledVersion(),
            'latest_version' => $this->upgradeService->getLatestVersion(),
            'needs_upgrade' => $this->upgradeService->needsUpgrade(),
            'pending_migrations' => $this->upgradeService->getPendingMigrations(),
            'requirements' => $this->upgradeService->checkRequirements(),
        ]);
    }

    /**
     * Run upgrade process (AJAX)
     */
    public function run(Request $request): JsonResponse
    {
        // Check requirements first
        $requirements = $this->upgradeService->checkRequirements();
        if (!$requirements['passed']) {
            return response()->json([
                'success' => false,
                'message' => 'System requirements not met. Please check requirements before upgrading.',
                'requirements' => $requirements,
            ], 422);
        }

        // Run upgrade
        $result = $this->upgradeService->runUpgrade();

        return response()->json($result);
    }

    /**
     * Run migrations only (AJAX)
     */
    public function migrate(): JsonResponse
    {
        $result = $this->upgradeService->runMigrations();
        return response()->json($result);
    }

    /**
     * Clear caches (AJAX)
     */
    public function clearCache(): JsonResponse
    {
        $result = $this->upgradeService->clearCaches();
        return response()->json($result);
    }
}
