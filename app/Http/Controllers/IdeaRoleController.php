<?php

namespace App\Http\Controllers;

use App\Models\Idea_Role;
use Illuminate\Http\Request;

class IdeaRoleController extends Controller
{
    public function index()
    {
        // $pino = Idea_Role::all()->map(function (Idea_Role $idea_role) {
        //     return $idea_role->users;
        // });
        // return $pino;
        $pino = Idea_Role::where('idea_id', 1)->where('role_id', 2)->first();
        return $pino->users();
    }
}
