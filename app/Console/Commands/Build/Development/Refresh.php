<?php

namespace App\Console\Commands\Build\Development;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
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
        $this->info('- Cleaning the File Storage');
        $this->line('');
        $directories = Storage::directories();
        $files = Storage::files();
        $this->line('Deleting Files');
        $success = collect($files)->every(function ($file) {
            if ($file == '.gitignore') return true;
            $this->line('Deleting file: '.$file);
            return Storage::delete($file);
        });
        $exitCode = (!$success) ? 1 : 0;
        if ($exitCode > 0) $this->error('Something went wrong when trying to remove the files');
        if ($exitCode > 0) return $exitCode;
        $this->line('Deleting folders');
        $success = collect($directories)->every(function ($directory) {
            if ($directory == 'protected') return true;
            if ($directory == 'public') {
                $this->line('Deleting Files');
                $directories = Storage::directories($directory);
                $files = Storage::files($directory);
                $success_files = collect($files)->every(function ($file) {
                    if ($file == 'public/.gitignore') return true;
                    $this->line('Deleting file: '.$file);
                    return Storage::delete($file);
                });
                if (!$success_files) return false;

                $this->line('Deleting folders');
                $success_directories = collect($directories)->every(function ($directory) {
                    $this->line('Deleting directory: '.$directory);
                    return Storage::deleteDirectory($directory);
                });
                return $success_directories;
            }
            $this->line('Deleting directory: '.$directory);
            return Storage::deleteDirectory($directory);
        });
        $exitCode = (!$success) ? 1 : 0;
        if ($exitCode > 0) $this->error('Something went wrong when trying to remove the folders');
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
