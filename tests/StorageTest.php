<?php

namespace Tests\Feature\Environment;

require_once __DIR__ . '/../html/vendor/autoload.php';

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageTest extends TestCase
{
    public function test_minio_put_can_store_file(): void
    {
        $key = \Carbon\Carbon::now()->format('Ymd-His-v');

        // Stores a file to MinIO
        $result = exec(__DIR__ . '/../bin/artisan minio:put --key=' . $key, $output, $retval);
        $this->assertTrue($result !== false);

        // Checks the file stored in MinIO
        // Retrieve the file with Storage facade
        $file = 'README.md';
        $path = sprintf('%s/%s', $key, $file);
        $contents = Storage::disk('s3')->get($path);
        // Compares the retrieved file with the local file
        $file_path = __DIR__ . '/../html/' . $file;
        $this->assertSame($contents, file_get_contents($file_path));
    }

    public function test_minio_get_can_read_storage(): void
    {
        $files = Storage::disk('s3')->allFiles('/');
        $this->assertTrue(!empty($files));
        $expected = [
            count($files) . " files found.",
        ];
        foreach ($files as $file) {
            $expected[] = Storage::disk('s3')->url($file);
        }
        $result = exec(__DIR__ . '/../bin/artisan minio:get', $output, $retval);
        $this->assertTrue($result !== false);
        $this->assertSame($expected, array_slice($output, 4));
        $this->assertSame(0, $retval);
    }
}
