<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $pino = User::findOrFail(1);
        return $pino->roles->first()->pivot->idea_id;
    }
}
