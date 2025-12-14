<?php

namespace App\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        // $message = "Log complete!";

        // $this->task("Installing Laravel", function () {
        //     sleep(1);
        //     return true;
        // });

        // $this->task("Doing something else", function () {
        //     sleep(1);
        //     return false;
        // });

        // render(<<<'HTML'
        //     <div class="py-1 ml-2">
        //         <div class="px-1 bg-yellow-300 text-black">ZAPP</div>
        //         <em class="ml-1">
        //           Test complete.
        //         </em>
        //     </div>
        // HTML);

        $directory = 'movies';
        $directories = Storage::disk('mount')->allDirectories($directory) ?? [];
        $movies = [];

        foreach ($directories as $movie) {
            $files = Storage::disk('mount')->allFiles($movie);


            foreach ($files as $key => $file) {
                // var_dump($file);
                // var_dump($mimetype = Storage::disk('mount')->mimeType($file));
                // die();
                if (Str::startsWith($mimetype = Storage::disk('mount')->mimeType($file), 'video/')) {
                    $movies[] = [
                        // 'path' => $file->getPathName(),
                        // 'folder' => dirname($file->getPathName()),
                        // 'file' => $file->getFileName(),
                        'file_test' => $file,
                        'mime_type' => $mimetype,
                        'need_transcoding' => !Str::contains($mimetype, 'matroska') && $key !== 0,
                    ];
                }
            }
        }

        foreach ($movies as $movie) {
            // $media = FFMpeg::disk('mount')->open('yesterday.mp3');
            var_dump($movie);
            // die();
        }

        exit(0);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
