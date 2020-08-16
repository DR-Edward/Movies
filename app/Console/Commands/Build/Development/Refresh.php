<?php

namespace App\Console\Commands\Build\Development;

use Illuminate\Console\Command;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:development:refresh {--no-data : Whether to seed the database with fake information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It clean the database and the file storage disk and insert fake data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (env('APP_ENV') == 'production') {
            $this->error('Sorry you are in production mode. You can\'t execute this command');
            return 1;
        }

        $this->line('');
        $this->info('- Migrating and Seeding');
        $this->line('');

        $exitCode = $this->call('migrate:refresh', [
            '--seed' => $this->option('no-data') ? false : true
        ]);
        
        if ($exitCode > 0) return $exitCode;

        $this->line('');
        $this->line('');
        $this->info('- Generating Passport Encryption Keys');
        $this->line('');
        $exitCode = $this->call('passport:install', [
            '--force' => true
        ]);

        $this->line('');
        $this->info('- Creating Symbolic link for the File Storage');
        $this->line('');
        $exitCode = $this->call('storage:link');

        return $exitCode;
    }
}
