<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HealthCheckPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:health-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check system health untuk PDF generation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔍 Checking PDF System Health...');
        $this->newLine();
        
        $status = true;
        
        // 1. Check GD Extension
        $this->info('1. Checking GD Extension...');
        if (extension_loaded('gd')) {
            $this->line('   ✅ GD Extension: Active');
            $gdVersion = gd_info();
            $this->line('   Version: ' . $gdVersion['GD Version']);
        } else {
            $this->error('   ❌ GD Extension: NOT Active - PDF tidak akan berfungsi!');
            $status = false;
        }
        
        // 2. Check required directories
        $this->newLine();
        $this->info('2. Checking Required Directories...');
        
        $dirs = [
            'logo' => public_path('logo'),
            'images' => public_path('images'),
            'storage' => storage_path(),
            'fonts' => storage_path('fonts'),
        ];
        
        foreach ($dirs as $name => $path) {
            if (is_dir($path)) {
                $writable = is_writable($path) ? '(writable)' : '(read-only)';
                $this->line("   ✅ {$name}: {$path} {$writable}");
            } else {
                $this->error("   ❌ {$name}: {$path} NOT FOUND");
                $status = false;
            }
        }
        
        // 3. Check required image files
        $this->newLine();
        $this->info('3. Checking Required Image Files...');
        
        $images = [
            'logo' => public_path('logo/logo-univ.png'),
            'stempel' => public_path('images/stempel.jpg'),
            'ttd' => public_path('images/ttddigital.jpg'),
        ];
        
        foreach ($images as $name => $path) {
            if (file_exists($path)) {
                $size = filesize($path) / 1024; // KB
                $readable = is_readable($path) ? '✅' : '❌';
                $this->line("   {$readable} {$name}: {$path} ({$size}KB)");
            } else {
                $this->error("   ❌ {$name}: {$path} NOT FOUND");
                $status = false;
            }
        }
        
        // 4. Check PHP settings
        $this->newLine();
        $this->info('4. Checking PHP Settings...');
        
        $settings = [
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ];
        
        foreach ($settings as $key => $value) {
            $this->line("   • {$key}: {$value}");
        }
        
        // 5. Check Laravel configuration
        $this->newLine();
        $this->info('5. Checking Laravel Configuration...');
        $this->line('   • APP_DEBUG: ' . config('app.debug'));
        $this->line('   • APP_ENV: ' . config('app.env'));
        $this->line('   • LOG_LEVEL: ' . config('logging.level'));
        
        // Summary
        $this->newLine();
        if ($status) {
            $this->info('✅ System is healthy! PDF generation should work.');
            return 0;
        } else {
            $this->error('❌ System has issues. Please fix them before using PDF feature.');
            return 1;
        }
    }
}
