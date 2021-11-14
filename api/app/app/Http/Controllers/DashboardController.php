<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index() {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (null === $user) {
            return response('', \Illuminate\Http\Response::HTTP_FORBIDDEN);
        }

        return view('dashboard', ['user' => $user, 'tokens' => $user->tokens]);
    }
}
