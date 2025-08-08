<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the application by running migrations and seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up Application...');

        $this->info('Running migrations...');
        Artisan::call('migrate:fresh');
        $this->info('Migrations completed');

        $this->info('Running seeders...');
        Artisan::call('db:seed');
        $this->info('Seeders completed');

        // Publish Telescope assets
        $this->info('Publishing Telescope assets...');
        Artisan::call('telescope:install');
        $this->info('Telescope assets published');

        $this->info('Clearing and caching configuration...');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        $this->info('Configuration cached');

        $this->info('Clearing and caching routes...');
        Artisan::call('route:clear');
        Artisan::call('route:cache');
        $this->info('Routes cached');

        $this->info('Clearing and caching views...');
        Artisan::call('view:clear');
        $this->info('Views cleared');

        $this->info('Application setup completed successfully!');
        $this->info('');
        $this->info('Default admin credentials:');
        $this->info('Email: admin@taskera.com');
        $this->info('Mobile: +1234567890');
        $this->info('Password: password');
        $this->info('');
        $this->info('You can now start the development server with: php artisan serve');
    }
}
