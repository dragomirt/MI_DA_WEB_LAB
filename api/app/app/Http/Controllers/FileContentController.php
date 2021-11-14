<?php

namespace App\Http\Controllers;

use App\Models\FileContent;
use Illuminate\Http\JsonResponse;

class FileContentController extends \Illuminate\Routing\Controller
{
    public function show($id) {
        if (null === $id) {
            return response()->json([], JsonResponse::HTTP_NOT_FOUND);
        }

        $file_content = FileContent::find($id);

        if (null === $file_content) {
            return response()->json([], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(['content' => $file_content->content]);
    }
}
