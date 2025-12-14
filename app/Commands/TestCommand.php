<?php

namespace App\Commands;

use function Termwind\render;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = "Log complete!";

        Log::emergency($message);
        Log::alert($message);
        Log::critical($message);
        Log::error($message);
        Log::warning($message);
        Log::notice($message);
        Log::info($message);
        Log::debug($message);

        $this->task("Installing Laravel", function () {
            sleep(1);
            return true;
        });

        $this->task("Doing something else", function () {
            sleep(1);
            return false;
        });

        render(<<<'HTML'
            <div class="py-1 ml-2">
                <div class="px-1 bg-yellow-300 text-black">ZAPP</div>
                <em class="ml-1">
                  Test complete.
                </em>
            </div>
        HTML);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        $schedule->command(static::class)->everyMinute();
    }
}
