<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class S3Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:s3-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test S3 Uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Http::attach(
            'uploaded_file',
            Storage::get('cat.jpg'),
            'cat.jpg')
        ->post('http://localhost/file');
    }
}
