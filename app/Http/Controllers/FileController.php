<?php

namespace App\Http\Controllers;

use App\Services\S3Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function __construct(
        private readonly S3Service $s3Service
    ) {
    }

    public function store(Request $request)
    {
        $file = $request->file('uploaded_file'); // Assuming you have an input named 'uploaded_file' in your form

        if ($file && $file->isValid()) {
            $filename = $file->getClientOriginalName();
            $contents = file_get_contents($file->getRealPath());
            $this->s3Service->storeFile($filename, $contents);

            return redirect()->back()->with('status', 'File uploaded successfully to S3!');
        }

        return redirect()->back()->withErrors('Failed to upload file.');
    }
}
