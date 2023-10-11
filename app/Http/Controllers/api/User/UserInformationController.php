<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserInformationController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

}