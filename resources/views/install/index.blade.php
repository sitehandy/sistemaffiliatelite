<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Install - Affiliate Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
                Affiliate Management System
            </h1>
            <p class="text-center text-gray-600 mb-8">Installation Wizard</p>

            <!-- Progress Steps -->
            <div class="flex justify-between mb-8">
                <div class="step" data-step="1">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold step-circle">1</div>
                    <span class="text-xs mt-1 block text-center">Terms</span>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="h-1 w-full bg-gray-300 step-line"></div>
                </div>
                <div class="step" data-step="2">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold step-circle">2</div>
                    <span class="text-xs mt-1 block text-center">Requirements</span>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="h-1 w-full bg-gray-300 step-line"></div>
                </div>
                <div class="step" data-step="3">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold step-circle">3</div>
                    <span class="text-xs mt-1 block text-center">Database</span>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="h-1 w-full bg-gray-300 step-line"></div>
                </div>
                <div class="step" data-step="4">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold step-circle">4</div>
                    <span class="text-xs mt-1 block text-center">Admin</span>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="h-1 w-full bg-gray-300 step-line"></div>
                </div>
                <div class="step" data-step="5">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold step-circle">5</div>
                    <span class="text-xs mt-1 block text-center">Complete</span>
                </div>
            </div>

            <!-- Step 1: Terms & Conditions -->
            <div id="step-1" class="step-content">
                <h2 class="text-xl font-semibold mb-4">Terms & Conditions</h2>
                <p class="text-gray-600 mb-4">Please read and accept the following terms and conditions before proceeding with the installation.</p>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-64 overflow-y-auto text-sm text-gray-700 mb-4">
                    <h3 class="font-bold text-lg mb-3">End User License Agreement (EULA)</h3>

                    <p class="mb-3">By installing and using this Affiliate Management System ("Software"), you agree to be bound by the following terms and conditions:</p>

                    <h4 class="font-semibold mt-4 mb-2">1. License Grant</h4>
                    <p class="mb-3">Subject to the terms of this Agreement, the licensor grants you a non-exclusive, non-transferable license to install and use the Software for your business purposes.</p>

                    <h4 class="font-semibold mt-4 mb-2">2. Permitted Use</h4>
                    <ul class="list-disc list-inside mb-3 space-y-1">
                        <li>Install the Software on a single server or hosting account</li>
                        <li>Use the Software for managing your affiliate marketing programs</li>
                        <li>Customize the Software to suit your business needs</li>
                        <li>Create unlimited affiliate programs, products, and affiliates</li>
                    </ul>

                    <h4 class="font-semibold mt-4 mb-2">3. Restrictions</h4>
                    <ul class="list-disc list-inside mb-3 space-y-1">
                        <li>You may not redistribute, resell, or sublicense the Software</li>
                        <li>You may not remove or alter any proprietary notices or labels</li>
                        <li>You may not use the Software for illegal or unethical purposes</li>
                        <li>You may not reverse engineer or decompile the Software</li>
                    </ul>

                    <h4 class="font-semibold mt-4 mb-2">4. Data & Privacy</h4>
                    <p class="mb-3">You are responsible for the data collected and stored by the Software. Ensure compliance with applicable data protection laws (GDPR, CCPA, etc.) in your jurisdiction.</p>

                    <h4 class="font-semibold mt-4 mb-2">5. Disclaimer of Warranties</h4>
                    <p class="mb-3">THE SOFTWARE IS PROVIDED "AS IS" WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED. THE LICENSOR DOES NOT WARRANT THAT THE SOFTWARE WILL BE ERROR-FREE OR UNINTERRUPTED.</p>

                    <h4 class="font-semibold mt-4 mb-2">6. Limitation of Liability</h4>
                    <p class="mb-3">IN NO EVENT SHALL THE LICENSOR BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE SOFTWARE.</p>

                    <h4 class="font-semibold mt-4 mb-2">7. Support & Updates</h4>
                    <p class="mb-3">Technical support and software updates may be provided at the discretion of the licensor. Support terms are subject to change without notice.</p>

                    <h4 class="font-semibold mt-4 mb-2">8. Termination</h4>
                    <p class="mb-3">This license is effective until terminated. Your rights under this license will terminate automatically if you fail to comply with any of its terms.</p>

                    <h4 class="font-semibold mt-4 mb-2">9. Governing Law</h4>
                    <p class="mb-3">This Agreement shall be governed by and construed in accordance with the laws of the jurisdiction in which the licensor operates.</p>

                    <p class="mt-4 font-medium">By clicking "I Accept", you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.</p>
                </div>

                <div class="flex items-center mb-4">
                    <input type="checkbox" id="accept-terms" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="accept-terms" class="ml-3 text-gray-700">
                        I have read and agree to the <strong>Terms & Conditions</strong> and <strong>End User License Agreement</strong>
                    </label>
                </div>

                <div class="mt-6 flex justify-end">
                    <button id="btn-accept-terms" onclick="acceptTerms()" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        I Accept - Continue Installation
                    </button>
                </div>
            </div>

            <!-- Step 2: Requirements -->
            <div id="step-2" class="step-content hidden">
                <h2 class="text-xl font-semibold mb-4">Server Requirements</h2>
                <div id="requirements-list" class="space-y-2">
                    <div class="text-center py-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
                        <p class="mt-2 text-gray-600">Checking requirements...</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-between">
                    <button onclick="goToStep(1)" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Back
                    </button>
                    <div>
                        <button id="btn-check-requirements" onclick="checkRequirements()" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                            Check Requirements
                        </button>
                        <button id="btn-next-2" onclick="goToStep(3)" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 ml-2 hidden">
                            Next Step
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Database & Environment -->
            <div id="step-3" class="step-content hidden">
                <h2 class="text-xl font-semibold mb-4">Database & Environment Configuration</h2>
                <form id="database-form" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Application Name</label>
                            <input type="text" name="app_name" value="Affiliate Management System" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Application URL</label>
                            <input type="url" name="app_url" value="{{ url('/') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h3 class="font-medium">Database Settings</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Database Host</label>
                            <input type="text" name="db_host" value="127.0.0.1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Database Port</label>
                            <input type="text" name="db_port" value="3306" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Database Name</label>
                        <input type="text" name="db_database" value="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Database Username</label>
                            <input type="text" name="db_username" value="root" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Database Password</label>
                            <input type="password" name="db_password" value="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                        </div>
                    </div>

                    <div id="db-status" class="hidden p-3 rounded"></div>
                </form>
                <div class="mt-6 flex justify-between">
                    <button id="btn-back-3" onclick="goToStep(2)" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Back
                    </button>
                    <div>
                        <button id="btn-test-db" onclick="testDatabase()" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
                            Test Connection
                        </button>
                        <button id="btn-save-env" onclick="saveEnvironment()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 ml-2" disabled>
                            Save & Continue
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Admin Account -->
            <div id="step-4" class="step-content hidden">
                <h2 class="text-xl font-semibold mb-4">Create Admin Account</h2>
                <form id="admin-form" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Admin Name</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required minlength="8">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" required minlength="8">
                    </div>
                    <div id="admin-status" class="hidden p-3 rounded"></div>
                </form>
                <div class="mt-6 flex justify-between">
                    <button id="btn-back-4" onclick="goToStep(3)" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Back
                    </button>
                    <button id="btn-create-admin" onclick="createAdmin()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                        Create Admin & Finish
                    </button>
                </div>
            </div>

            <!-- Step 5: Complete -->
            <div id="step-5" class="step-content hidden">
                <div class="text-center py-8">
                    <div class="text-green-500 mb-4">
                        <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Installation Complete!</h2>
                    <p class="text-gray-600 mb-6">Your Affiliate Management System has been successfully installed.</p>
                    <a href="/" class="bg-blue-500 text-white px-8 py-3 rounded hover:bg-blue-600 inline-block">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            Powered By <a href="https://sistemaffiliate.com" target="_blank" class="text-blue-500 hover:text-blue-700 hover:underline">Sistem Affiliate</a>. All Rights Reserved.
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Terms checkbox handler
        document.getElementById('accept-terms').addEventListener('change', function() {
            document.getElementById('btn-accept-terms').disabled = !this.checked;
        });

        function acceptTerms() {
            if (document.getElementById('accept-terms').checked) {
                goToStep(2);
                checkRequirements();
            }
        }

        // Helper function to disable button with loading state
        function setButtonLoading(button, loading, originalText = null) {
            if (loading) {
                button.disabled = true;
                button.dataset.originalText = button.innerHTML;
                button.innerHTML = `<span class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>`;
                button.classList.add('opacity-75', 'cursor-not-allowed');
            } else {
                button.disabled = false;
                button.innerHTML = originalText || button.dataset.originalText || button.innerHTML;
                button.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        }

        async function checkRequirements() {
            const btn = document.getElementById('btn-check-requirements');
            setButtonLoading(btn, true);

            const container = document.getElementById('requirements-list');
            container.innerHTML = '<div class="text-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div><p class="mt-2 text-gray-600">Checking requirements...</p></div>';

            try {
                const response = await fetch('/install/requirements');
                const data = await response.json();

                let html = '';

                // PHP Version
                html += `<div class="flex items-center justify-between p-2 ${data.results.php.passed ? 'bg-green-50' : 'bg-red-50'} rounded">
                    <span>PHP Version (${data.results.php.required}+)</span>
                    <span class="${data.results.php.passed ? 'text-green-600' : 'text-red-600'}">${data.results.php.current} ${data.results.php.passed ? '✓' : '✗'}</span>
                </div>`;

                // Extensions
                html += '<h4 class="font-medium mt-4 mb-2">PHP Extensions</h4>';
                data.results.extensions.forEach(ext => {
                    const status = ext.passed ? 'text-green-600' : (ext.required ? 'text-red-600' : 'text-yellow-600');
                    const bg = ext.passed ? 'bg-green-50' : (ext.required ? 'bg-red-50' : 'bg-yellow-50');
                    html += `<div class="flex items-center justify-between p-2 ${bg} rounded mb-1">
                        <span>${ext.name} ${!ext.required ? '(optional)' : ''}</span>
                        <span class="${status}">${ext.passed ? '✓' : '✗'}</span>
                    </div>`;
                });

                // Permissions
                html += '<h4 class="font-medium mt-4 mb-2">Directory Permissions</h4>';
                data.results.permissions.forEach(perm => {
                    html += `<div class="flex items-center justify-between p-2 ${perm.passed ? 'bg-green-50' : 'bg-red-50'} rounded mb-1">
                        <span>${perm.path}</span>
                        <span class="${perm.passed ? 'text-green-600' : 'text-red-600'}">${perm.passed ? 'Writable ✓' : 'Not Writable ✗'}</span>
                    </div>`;
                });

                container.innerHTML = html;

                if (data.passed) {
                    document.getElementById('btn-check-requirements').classList.add('hidden');
                    document.getElementById('btn-next-2').classList.remove('hidden');
                } else {
                    setButtonLoading(btn, false);
                }
            } catch (error) {
                container.innerHTML = '<div class="text-red-500">Error checking requirements: ' + error.message + '</div>';
                setButtonLoading(btn, false);
            }
        }

        async function testDatabase() {
            const btn = document.getElementById('btn-test-db');
            setButtonLoading(btn, true);

            const form = document.getElementById('database-form');
            const formData = new FormData(form);
            const data = {
                host: formData.get('db_host'),
                port: formData.get('db_port'),
                database: formData.get('db_database'),
                username: formData.get('db_username'),
                password: formData.get('db_password')
            };

            const status = document.getElementById('db-status');
            status.className = 'p-3 rounded bg-yellow-50 text-yellow-700';
            status.textContent = 'Testing connection...';
            status.classList.remove('hidden');

            try {
                const response = await fetch('/install/database/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                });

                const text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Response was not JSON:', text);
                    throw new Error('Server returned an invalid response. Check your server configuration.');
                }

                if (result.success) {
                    status.className = 'p-3 rounded bg-green-50 text-green-700';
                    status.textContent = result.message;
                    document.getElementById('btn-save-env').disabled = false;
                } else {
                    status.className = 'p-3 rounded bg-red-50 text-red-700';
                    status.textContent = result.message || 'Database connection failed';
                }
                setButtonLoading(btn, false);
            } catch (error) {
                status.className = 'p-3 rounded bg-red-50 text-red-700';
                status.textContent = 'Error: ' + error.message;
                console.error('Database test error:', error);
                setButtonLoading(btn, false);
            }
        }

        async function saveEnvironment() {
            const btn = document.getElementById('btn-save-env');
            const btnBack = document.getElementById('btn-back-3');
            const btnTest = document.getElementById('btn-test-db');
            setButtonLoading(btn, true);
            btnBack.disabled = true;
            btnBack.classList.add('opacity-50', 'cursor-not-allowed');
            btnTest.disabled = true;
            btnTest.classList.add('opacity-50', 'cursor-not-allowed');

            const form = document.getElementById('database-form');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            const status = document.getElementById('db-status');
            status.className = 'p-3 rounded bg-yellow-50 text-yellow-700';
            status.textContent = 'Saving configuration and running migrations...';

            try {
                // Save environment
                let response = await fetch('/install/environment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                });
                let text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Response was not JSON:', text);
                    throw new Error('Server returned an invalid response');
                }

                if (!result.success) {
                    throw new Error(result.message);
                }

                status.textContent = 'Running database migrations...';

                // Run migrations
                response = await fetch('/install/migrations', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                result = await response.json();

                if (!result.success) {
                    throw new Error(result.message);
                }

                status.className = 'p-3 rounded bg-green-50 text-green-700';
                status.textContent = 'Configuration saved and migrations completed!';

                setTimeout(() => goToStep(4), 1000);
            } catch (error) {
                status.className = 'p-3 rounded bg-red-50 text-red-700';
                status.textContent = 'Error: ' + error.message;
                setButtonLoading(btn, false);
                btnBack.disabled = false;
                btnBack.classList.remove('opacity-50', 'cursor-not-allowed');
                btnTest.disabled = false;
                btnTest.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        async function createAdmin() {
            const btn = document.getElementById('btn-create-admin');
            const btnBack = document.getElementById('btn-back-4');
            setButtonLoading(btn, true);
            btnBack.disabled = true;
            btnBack.classList.add('opacity-50', 'cursor-not-allowed');

            const form = document.getElementById('admin-form');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            const status = document.getElementById('admin-status');
            status.className = 'p-3 rounded bg-yellow-50 text-yellow-700';
            status.textContent = 'Creating admin account...';
            status.classList.remove('hidden');

            try {
                let response = await fetch('/install/admin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                });
                let text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Response was not JSON:', text);
                    throw new Error('Server returned an invalid response');
                }

                if (!result.success) {
                    throw new Error(result.message);
                }

                status.textContent = 'Finalizing installation...';

                // Finalize
                response = await fetch('/install/finalize', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                text = await response.text();
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Response was not JSON:', text);
                    throw new Error('Server returned an invalid response');
                }

                if (!result.success) {
                    throw new Error(result.message);
                }

                goToStep(5);
            } catch (error) {
                status.className = 'p-3 rounded bg-red-50 text-red-700';
                status.textContent = 'Error: ' + error.message;
                console.error('Admin creation error:', error);
                setButtonLoading(btn, false);
                btnBack.disabled = false;
                btnBack.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        function goToStep(step) {
            // Hide all step contents
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            // Show target step
            document.getElementById('step-' + step).classList.remove('hidden');

            // Update progress indicators
            document.querySelectorAll('.step').forEach((el, index) => {
                const stepNum = index + 1;
                const circle = el.querySelector('.step-circle');
                if (stepNum < step) {
                    circle.className = 'w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold step-circle';
                } else if (stepNum === step) {
                    circle.className = 'w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold step-circle';
                } else {
                    circle.className = 'w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold step-circle';
                }
            });
        }
    </script>
</body>
</html>
