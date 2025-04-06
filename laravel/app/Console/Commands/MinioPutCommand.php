<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\text;

class MinioPutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:put {--key=}';

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
        $key = $this->option('key');
        $dir = strlen($key) ? $key : \Carbon\Carbon::now()->format('Ymd-His-v');
        $path = sprintf('%s/%s', $dir, 'README.md');
        Storage::disk('s3')->put($path, File::get(app_path() . '/../README.md'), 'public');
    }
}
