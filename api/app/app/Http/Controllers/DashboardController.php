<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index() {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (null === $user) {
            return response('', \Illuminate\Http\Response::HTTP_FORBIDDEN);
        }

        $files = $user->files();

        return view('dashboard', ['user' => $user, 'token' => $user->tokens->last(), 'files' => $files]);
    }
}
