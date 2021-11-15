<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends \Illuminate\Routing\Controller
{
    public function files(Request $request)
    {
        $user = $request->user();

        if (null === $user) {
            return response()->json([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $files = $user->files()->load('content');
        return response()->json(['files' => FileResource::collection($files)], JsonResponse::HTTP_OK);
    }
}
