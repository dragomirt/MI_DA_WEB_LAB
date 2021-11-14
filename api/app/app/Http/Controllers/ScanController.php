<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanRequest;
use App\Jobs\ProcessPdf;
use App\Models\FileContent;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

class ScanController
{
    public function scan(ScanRequest $request) {
        $user = Auth::user();

        if (null === $user) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $media = $user->addMediaFromRequest('file')
            ->toMediaCollection('files');

        $media_id = $media->id;

        $filepath = $media->getPath();

        if (null === $filepath) {
            $this->fail(new \Exception("No file available."));
        }

        if (null === $media_id) {
            $this->fail(new \Exception("No media found."));
        }

        $content = null;
        try {
            $content = (new Pdf())
                ->setPdf($filepath)
                ->setOptions(['layout', 'r 96'])
                ->addOptions(['f 1'])
                ->setScanOptions(['-l ron+rus+eng', '--skip-text'])
                ->scan()
                ->decrypt()
                ->text();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());
        }

        $file_content = new FileContent();
        $file_content->media_id = $media_id;
        $file_content->content = $content;
        $file_content->save();

        return response()->json(['content' => $content], JsonResponse::HTTP_OK);
    }
}
