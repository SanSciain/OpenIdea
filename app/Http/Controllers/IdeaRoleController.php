<?php

namespace App\Http\Controllers;

use App\Models\IdeaRole;
use Illuminate\Http\Request;

class IdeaRoleController extends Controller
{
    public function index()
    {
        $idea_role = IdeaRole::find(1);
        return $idea_role->users;


        // return [$idea_role->users, $idea_role->diomerda];
        // $idea_roles = IdeaRole::all();
        // foreach ($idea_roles as $value) {
        //     $value->users;
        // }
        // return $idea_roles;
    }
}
