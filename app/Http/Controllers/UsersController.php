<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\User;
use Auth;

class UsersController extends Controller
{
    //
    public function apiUser(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        return new UserResource($user);
    }

    public function index()
    {
        return view('user.index');
    }
}
