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

        ProcessPdf::dispatch($media->id, $media->getPath());

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
