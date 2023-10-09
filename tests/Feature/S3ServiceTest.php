<?php

namespace Tests\Feature;

use App\Services\S3Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class S3ServiceTest extends TestCase
{
    protected S3Service $s3Service;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('s3'); // Mock the S3 disk
        $this->s3Service = new S3Service();
    }

    /** @test */
    public function testStoreFile()
    {
        $file = UploadedFile::fake()->image($filename = 'logo.png');
        $contents = file_get_contents($file->getRealPath());

        $this->s3Service->storeFile($filename, $contents);
        Storage::disk('s3')->assertExists($filename);
    }

    /** @test */
    public function testRetrieveFile()
    {
        $file = UploadedFile::fake()->image($filename = 'logo.png');
        $contents = file_get_contents($file->getRealPath());
        Storage::disk('s3')->put($filename, $contents);
        $retrievedContent = $this->s3Service->retrieveFile($filename);
        $this->assertEquals($contents, $retrievedContent);
    }

    /** @test */
    public function testFileExists()
    {
        $file = UploadedFile::fake()->image($filename = 'logo.png');
        $contents = file_get_contents($file->getRealPath());
        $this->assertFalse($this->s3Service->fileExists($filename));
        Storage::disk('s3')->put($filename, $contents);
        $this->assertTrue($this->s3Service->fileExists($filename));
    }

    /** @test */
    public function testDeleteFile()
    {
        $file = UploadedFile::fake()->image($filename = 'logo.png');
        $contents = file_get_contents($file->getRealPath());
        Storage::disk('s3')->put($filename, $contents);
        $this->s3Service->deleteFile($filename);
        Storage::disk('s3')->assertMissing($filename);
    }

    // Further tests, like one for `generateTemporaryUrl`, might be more complex due to the signed URL generation.
    // Depending on the criticality, you might decide to skip it or use a more sophisticated method to test.
}
