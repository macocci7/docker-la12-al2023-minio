<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MinitGetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Minio Url';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('s3')->allFiles('/');
        
        if (empty($files)) {
            echo "No files found in the bucket." . PHP_EOL;
        }
        
        echo count($files) . " files found." . PHP_EOL;
        foreach ($files as $file) {
            echo Storage::disk('s3')->url($file) . PHP_EOL;
        }
    }
}
