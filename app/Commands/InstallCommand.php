<?php

namespace App\Commands;

use function Termwind\render;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install requirements to use this CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $needed_folders = ['/config', '/movies', '/tv', '/transcode'];
        $needed_files = ['/config/database.sqlite'];

        if (! empty($needed_folders)) {
            foreach ($needed_folders as $needed_folder) {
                if (!File::isDirectory($needed_folder)) {
                    File::makeDirectory($needed_folder, 0755, true);
                }
            }
        }

        if (! empty($needed_files)) {
            foreach ($needed_files as $needed_file) {
                if (!File::isFile($needed_file)) {
                    File::put($needed_file, '');
                }
            }
        }

        render(<<<'HTML'
            <div class="py-1 ml-2">
                <div class="px-1 bg-yellow-300 text-black">ZAPP</div>
                <em class="ml-1">
                  Install complete.
                </em>
            </div>
        HTML);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
