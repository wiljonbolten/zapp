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
        $database_file = '/config/database.sqlite';

        if (!File::isDirectory(\dirname($database_file))) {
            File::makeDirectory(\dirname($database_file), 0755, true);
        }

        if (!File::isFile($database_file)) {
            File::put($database_file, '');
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
