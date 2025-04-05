<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\text;

class MinioPutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:put';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload a file to minio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dir = \Carbon\Carbon::now()->format('Ymd-His-v');
        $path = sprintf('%s/%s', $dir, 'README.md');
        Storage::disk('s3')->put($path, app_path() . '/../README.md', 'private');
    }
}
