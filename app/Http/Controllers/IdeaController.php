<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tag;
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
            return [$idea, $idea->tags];
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function showOwned($slug)
    {
        try {
            $idea = Idea::where('slug', '=', $slug)->firstOrFail();
            $user = Auth::user();
            if ($idea->user_id === $user->id) {
                return [$idea, $idea->tags];
            } else if ($idea) {
                return null;
            }
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
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
