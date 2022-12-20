<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\IdeaRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




use Illuminate\Database\Eloquent\ModelNotFoundException;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ideas = Idea::all();
        return response([$ideas]);
    }

    public function indexOwned()
    {
        $user = Auth::user();
        $ideas = Idea::where('user_id', $user->id)->get();
        return response([$ideas]);
    }


    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $tags = Tag::all();
    //     return response([$tags]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $idea = new Idea;
        $request->validate($this->getValidationRules());
        $data = $request->all();
        $idea->fill($data);
        $idea->slug = Idea::generateIdeaSlugFromTitle($idea->title);
        $idea->user_id = $user->id;
        $idea->save();


        if (isset($data['tags'])) {
            $idea->tags()->sync($data['tags']);
        };

        if (isset($data['roles'])) {
            foreach ($data['roles'] as $role_id) {
                $idea->roles()->attach([$role_id => ['assigned' => false]]);
            }
        };

        return $idea;
        // // return redirect()->route('admin.ideas.show', ['idea' => $idea->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $idea = Idea::where('slug', '=', $slug)->firstOrFail();
            return [$idea, $idea->tags, $idea->roles];
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function showOwned($slug)
    {
        // try {
        //     $idea = Idea::where('slug', '=', $slug)->firstOrFail();
        //     $user = Auth::user();
        //     if ($idea->user_id === $user->id) {
        //         $idea_role_users = $idea->roles->map(function ($role) {
        //             // return IdeaRole::where('idea_id', $this->idea->id)->where('role_id', $role->id)->first()->users;
        //             return $this->idea;
        //         });
        //         return [$idea, $idea->tags, $idea->roles, $idea_role_users];
        //     } else if ($idea) {
        //         return null;
        //     }
        // } catch (ModelNotFoundException $e) {
        //     throw $e;
        // }

        $idea = Idea::where('slug', '=', $slug)->firstOrFail();
        $user = Auth::user();
        if ($idea->user_id === $user->id) {
            $idea_role_users = $idea->roles->map(function ($role) use ($idea) {
                return IdeaRole::where('idea_id', $idea->id)->where('role_id', $role->id)->first()->users;
            });
            return [$idea, $idea->tags, $idea->roles, $idea_role_users];
        } else if ($idea) {
            return null;
        }
    }

    public function updateAssignedUserToRole(Request $request, $slug)
    {
        return $request->all();
        $idea = Idea::where('slug', '=', $slug)->firstOrFail();
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $idea = Idea::findOrFail($id);

    //     $response = Gate::inspect('update', $idea);

    //     if ($response->allowed()) {
    //         return view('admin.ideas.edit', compact('idea'));
    //     } else {
    //         return view('admin.policy', compact("response"));
    //     }
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate($this->getValidationRules());
        $data = $request->all();
        try {
            $idea = Idea::where('slug', '=', $slug)->firstOrFail();
            $user = Auth::user();
            if ($idea->user_id === $user->id) {
                if ($data['title'] !== $idea->title) {
                    $data['slug'] = Idea::generateIdeaSlugFromTitle($data['title']);
                }
                $idea->update($data);
                $idea->save();
                if (isset($data['tags'])) {
                    $idea->tags()->sync($data['tags']);
                } else {
                    $idea->tags()->sync([]);
                }
                if (isset($data['roles'])) {
                    $idea->roles()->sync($data['roles']);
                    // foreach ($data['roles'] as $role_id) {
                    //     // check if it is already assigned 
                    //     $idea->roles()->attach([$role_id => ['assigned' => false]]);
                    //     // $idea->roles()->attach($role_id);
                    // }
                } else {
                    $idea->roles()->sync([]);
                }
                return $idea;
            } else if ($idea) {
                return null;
            }
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        try {
            $idea = Idea::where('slug', '=', $slug)->firstOrFail();
            $user = Auth::user();
            if ($idea->user_id === $user->id) {
                $idea->tags()->sync([]);
                $idea->roles()->sync([]);
                $idea->delete();
                return true;
            } else if ($idea) {
                return null;
            }
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }


    private function getValidationRules()
    {
        return [
            'title' => 'required|max:255',
            'text' => 'required',
        ];
    }
}
