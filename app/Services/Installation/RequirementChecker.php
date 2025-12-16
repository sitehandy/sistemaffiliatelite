<?php

namespace App\Services\Installation;

class RequirementChecker
{
    public function check(): array
    {
        return [
            'php' => $this->checkPhpVersion(),
            'extensions' => $this->checkExtensions(),
            'permissions' => $this->checkPermissions(),
            'server' => $this->checkServerRequirements(),
        ];
    }

    public function allPassed(): bool
    {
        $results = $this->check();

        if (!$results['php']['passed']) {
            return false;
        }

        foreach ($results['extensions'] as $ext) {
            if (!$ext['passed'] && $ext['required']) {
                return false;
            }
        }

        foreach ($results['permissions'] as $perm) {
            if (!$perm['passed']) {
                return false;
            }
        }

        return true;
    }

    private function checkPhpVersion(): array
    {
        $required = '8.2.0';
        $current = PHP_VERSION;

        return [
            'required' => $required,
            'current' => $current,
            'passed' => version_compare($current, $required, '>='),
        ];
    }

    private function checkExtensions(): array
    {
        $extensions = [
            ['name' => 'BCMath', 'extension' => 'bcmath', 'required' => true],
            ['name' => 'Ctype', 'extension' => 'ctype', 'required' => true],
            ['name' => 'cURL', 'extension' => 'curl', 'required' => true],
            ['name' => 'DOM', 'extension' => 'dom', 'required' => true],
            ['name' => 'Fileinfo', 'extension' => 'fileinfo', 'required' => true],
            ['name' => 'JSON', 'extension' => 'json', 'required' => true],
            ['name' => 'Mbstring', 'extension' => 'mbstring', 'required' => true],
            ['name' => 'OpenSSL', 'extension' => 'openssl', 'required' => true],
            ['name' => 'PCRE', 'extension' => 'pcre', 'required' => true],
            ['name' => 'PDO', 'extension' => 'pdo', 'required' => true],
            ['name' => 'PDO MySQL', 'extension' => 'pdo_mysql', 'required' => true],
            ['name' => 'Session', 'extension' => 'session', 'required' => true],
            ['name' => 'Tokenizer', 'extension' => 'tokenizer', 'required' => true],
            ['name' => 'XML', 'extension' => 'xml', 'required' => true],
            ['name' => 'Redis', 'extension' => 'redis', 'required' => false],
            ['name' => 'GD', 'extension' => 'gd', 'required' => false],
            ['name' => 'Imagick', 'extension' => 'imagick', 'required' => false],
        ];

        return array_map(function ($ext) {
            return [
                'name' => $ext['name'],
                'passed' => extension_loaded($ext['extension']),
                'required' => $ext['required'],
            ];
        }, $extensions);
    }

    private function checkPermissions(): array
    {
        $directories = [
            storage_path(),
            storage_path('app'),
            storage_path('framework'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ];

        return array_map(function ($dir) {
            return [
                'path' => str_replace(base_path(), '', $dir),
                'passed' => is_writable($dir),
            ];
        }, $directories);
    }

    private function checkServerRequirements(): array
    {
        return [
            [
                'name' => 'mod_rewrite',
                'passed' => $this->checkModRewrite(),
                'message' => 'Required for URL rewriting',
            ],
            [
                'name' => 'proc_open',
                'passed' => function_exists('proc_open'),
                'message' => 'Required for queue processing',
            ],
            [
                'name' => 'symlink',
                'passed' => function_exists('symlink'),
                'message' => 'Required for storage links',
            ],
        ];
    }

    private function checkModRewrite(): bool
    {
        if (function_exists('apache_get_modules')) {
            return in_array('mod_rewrite', apache_get_modules());
        }

        // Assume enabled if not Apache or cannot check
        return true;
    }
}
