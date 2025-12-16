<?php

namespace App\Http\Controllers;

use App\Services\Installation\InstallationService;
use App\Services\Installation\RequirementChecker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InstallController extends Controller
{
    private InstallationService $installationService;
    private RequirementChecker $requirementChecker;

    public function __construct(
        InstallationService $installationService,
        RequirementChecker $requirementChecker
    ) {
        $this->installationService = $installationService;
        $this->requirementChecker = $requirementChecker;
    }

    public function index()
    {
        if ($this->installationService->isInstalled()) {
            return redirect('/');
        }

        return view('install.index');
    }

    public function checkRequirements(): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            return response()->json($this->installationService->checkRequirements());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking requirements: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testDatabase(Request $request): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            $validated = $request->validate([
                'host' => ['required', 'string'],
                'port' => ['nullable', 'string'],
                'database' => ['required', 'string'],
                'username' => ['required', 'string'],
                'password' => ['nullable', 'string'],
            ]);

            // Convert port to integer if provided
            if (!empty($validated['port'])) {
                $validated['port'] = (int) $validated['port'];
            }

            return response()->json($this->installationService->testDatabaseConnection($validated));
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveEnvironment(Request $request): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            $validated = $request->validate([
                'app_name' => ['required', 'string', 'max:255'],
                'app_url' => ['required', 'string'],
                'db_host' => ['required', 'string'],
                'db_port' => ['nullable', 'string'],
                'db_database' => ['required', 'string'],
                'db_username' => ['required', 'string'],
                'db_password' => ['nullable', 'string'],
                'mail_host' => ['nullable', 'string'],
                'mail_port' => ['nullable', 'string'],
                'mail_username' => ['nullable', 'string'],
                'mail_password' => ['nullable', 'string'],
                'mail_encryption' => ['nullable', 'string'],
                'mail_from_address' => ['nullable', 'string'],
            ]);

            return response()->json($this->installationService->saveEnvironment($validated));
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving environment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function runMigrations(): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            $result = $this->installationService->runMigrations();

            if ($result['success']) {
                $seedResult = $this->installationService->seedDatabase();
                if (!$seedResult['success']) {
                    return response()->json($seedResult);
                }
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createAdmin(Request $request): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            return response()->json($this->installationService->createAdminUser($validated));
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating admin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testEmail(): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            return response()->json($this->installationService->testEmailConfiguration());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function finalize(): JsonResponse
    {
        try {
            if ($this->installationService->isInstalled()) {
                return response()->json(['error' => 'Already installed'], 403);
            }

            $settingsResult = $this->installationService->initializeSettings();
            if (!$settingsResult['success']) {
                return response()->json($settingsResult);
            }

            return response()->json($this->installationService->finalize());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Finalization failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
