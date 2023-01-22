<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\IdeaRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaRoleController extends Controller
{
    // public function apply($slug, $role_id)
    // {


    //     try {
    //         $idea_id = Idea::where('slug', $slug)->firstOrFail()->id;
    //         $idea_role = IdeaRole::where('idea_id', $idea_id)->where('role_id', $role_id)->firstOrFail();
    //         $user = Auth::user();
    //         // if ($idea_role->users->isEmpty()) {
    //         //     $idea_role->users()->attach($user);
    //         //     return "success";
    //         // } else if ($idea_role->users->contains('id', $user->id)) {
    //         //     return "Already added";
    //         // } else {
    //         //     $idea_role->users()->attach($user);
    //         //     return "success";
    //         // }

    //         if ($idea_role->users->contains('id', $user->id)) {
    //             return "You already apllied for thi role";
    //         } else {
    //             $idea_role->users()->attach($user);
    //             return "Applied successfully";
    //         }
    //     } catch (ModelNotFoundException $e) {
    //         throw $e;
    //     }
    // }



    // public function unapply($slug, $role_id)
    // {
    //     try {
    //         $idea_id = Idea::where('slug', $slug)->firstOrFail()->id;
    //         $idea_role = IdeaRole::where('idea_id', $idea_id)->where('role_id', $role_id)->firstOrFail();
    //         $user = Auth::user();
    //         $idea_role->users()->detach($user);
    //         return "Unpplied successfully";
    //     } catch (ModelNotFoundException $e) {
    //         throw $e;
    //     }
    // }


    public function applytoggle($slug, $role_id)
    {
        try {
            $idea_id = Idea::where('slug', $slug)->firstOrFail()->id;
            $idea_role = IdeaRole::where('idea_id', $idea_id)->where('role_id', $role_id)->firstOrFail();
            $user = Auth::user();

            if (!$idea_role->assigned) {
                if ($idea_role->users->contains('id', $user->id)) {
                    $idea_role->users()->detach($user);
                    return "Unpplied successfully";
                } else {
                    $idea_role->users()->attach($user);
                    return "Applied successfully";
                }
            } else {
                return "This role is already assigned";
            }
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }
}
