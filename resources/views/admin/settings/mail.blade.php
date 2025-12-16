@extends('layouts.app')

@section('title', 'Mail Settings')
@section('page-title', 'Mail Configuration')

@section('content')
    <div class="max-w-3xl">
        @if(config('app.demo_mode'))
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Demo Mode Active</h4>
                        <p class="text-sm text-yellow-700 mt-1">Mail settings cannot be modified in demo mode.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mail Settings Form -->
        <form method="POST" action="{{ route('admin.settings.mail.update') }}" class="bg-white rounded-lg shadow p-6 mb-6">
            @csrf
            @method('PUT')
            <fieldset {{ config('app.demo_mode') ? 'disabled' : '' }}>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">SMTP Configuration</h3>
                <p class="text-sm text-gray-500">Configure your mail server settings for sending emails.</p>
            </div>

            <div class="mb-6">
                <label for="mail_mailer" class="block text-sm font-medium text-gray-700 mb-1">Mail Driver</label>
                <select name="mail_mailer" id="mail_mailer" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_mailer') border-red-500 @enderror">
                    <option value="smtp" {{ $settings['mail_mailer'] === 'smtp' ? 'selected' : '' }}>SMTP</option>
                    <option value="sendmail" {{ $settings['mail_mailer'] === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                    <option value="mailgun" {{ $settings['mail_mailer'] === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                    <option value="ses" {{ $settings['mail_mailer'] === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                    <option value="postmark" {{ $settings['mail_mailer'] === 'postmark' ? 'selected' : '' }}>Postmark</option>
                    <option value="log" {{ $settings['mail_mailer'] === 'log' ? 'selected' : '' }}>Log (Testing)</option>
                </select>
                @error('mail_mailer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                    <input type="text" name="mail_host" id="mail_host" value="{{ $settings['mail_host'] }}"
                        placeholder="smtp.gmail.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_host') border-red-500 @enderror">
                    @error('mail_host')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                    <input type="text" name="mail_port" id="mail_port" value="{{ $settings['mail_port'] }}"
                        placeholder="587"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_port') border-red-500 @enderror">
                    @error('mail_port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                    <input type="text" name="mail_username" id="mail_username" value="{{ $settings['mail_username'] }}"
                        placeholder="your@email.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_username') border-red-500 @enderror">
                    @error('mail_username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                    <input type="password" name="mail_password" id="mail_password" value="{{ $settings['mail_password'] }}"
                        placeholder="••••••••"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_password') border-red-500 @enderror">
                    @error('mail_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">Encryption</label>
                <select name="mail_encryption" id="mail_encryption"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_encryption') border-red-500 @enderror">
                    <option value="tls" {{ $settings['mail_encryption'] === 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ $settings['mail_encryption'] === 'ssl' ? 'selected' : '' }}>SSL</option>
                    <option value="null" {{ $settings['mail_encryption'] === 'null' || $settings['mail_encryption'] === null ? 'selected' : '' }}>None</option>
                </select>
                @error('mail_encryption')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6">

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Sender Information</h3>
                <p class="text-sm text-gray-500">Configure the default sender name and email address.</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">From Email Address</label>
                    <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings['mail_from_address'] }}"
                        placeholder="noreply@example.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_from_address') border-red-500 @enderror">
                    @error('mail_from_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">From Name</label>
                    <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $settings['mail_from_name'] }}"
                        placeholder="My Affiliate System"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('mail_from_name') border-red-500 @enderror">
                    @error('mail_from_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ config('app.demo_mode') ? 'disabled' : '' }}>
                    Save Mail Settings
                </button>
            </div>
            </fieldset>
        </form>

        <!-- Test Mail Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Test Email Configuration</h3>
                <p class="text-sm text-gray-500">Send a test email to verify your mail configuration is working correctly.</p>
            </div>

            <form method="POST" action="{{ route('admin.settings.mail.test') }}" class="flex items-end space-x-4">
                @csrf
                <fieldset {{ config('app.demo_mode') ? 'disabled' : '' }} class="flex-1 flex items-end space-x-4">
                    <div class="flex-1">
                        <label for="test_email" class="block text-sm font-medium text-gray-700 mb-1">Recipient Email</label>
                        <input type="email" name="test_email" id="test_email" required
                            placeholder="test@example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ config('app.demo_mode') ? 'disabled' : '' }}>
                        Send Test Email
                    </button>
                </fieldset>
            </form>
        </div>

        <!-- Common SMTP Configurations -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-sm font-semibold text-blue-900 mb-3">Common SMTP Configurations</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-medium text-blue-800">Gmail</p>
                    <p class="text-blue-700">Host: smtp.gmail.com | Port: 587 | TLS</p>
                </div>
                <div>
                    <p class="font-medium text-blue-800">Outlook/Hotmail</p>
                    <p class="text-blue-700">Host: smtp-mail.outlook.com | Port: 587 | TLS</p>
                </div>
                <div>
                    <p class="font-medium text-blue-800">Yahoo</p>
                    <p class="text-blue-700">Host: smtp.mail.yahoo.com | Port: 587 | TLS</p>
                </div>
                <div>
                    <p class="font-medium text-blue-800">Mailgun</p>
                    <p class="text-blue-700">Host: smtp.mailgun.org | Port: 587 | TLS</p>
                </div>
            </div>
            <p class="mt-3 text-xs text-blue-600">Note: For Gmail, you may need to enable "Less secure app access" or use an App Password.</p>
        </div>
    </div>
@endsection
