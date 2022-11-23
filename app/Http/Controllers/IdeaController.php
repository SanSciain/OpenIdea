<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function show($id)
    {
        $idea = Idea::findOrFail($id);
        return $idea;
    }

    public function showOwned($id)
    {
        $user = Auth::user();
        $idea = Idea::findOrFail($id);
        if ($idea->user->id === $user->id) {
            return $idea;
        } else {
            return "you don't own that idea";
        }
        // $idea = Idea::findOrFail($id)->where('user_id', $user->id)->first();
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

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate($this->getValidationRules());
    //     $data = $request->all();
    //     $idea = Idea::findOrFail($id);
    //     if ($data['title'] !== $idea->title) {
    //         $idea->slug = Idea::generateIdeasSlugFromTitle($data["title"]);
    //     }
    //     $idea->update($data);
    //     $idea->save();
    //     return redirect()->route('admin.ideas.show', ['idea' => $idea->id]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $idea = Idea::findOrFail($id);
    //     $response = Gate::inspect('delete', $idea);
    //     if ($response->allowed()) {
    //         $idea->delete();
    //         return redirect()->route('admin.ideas.index');
    //     } else {
    //         return view('admin.policy', compact("response"));
    //     }
    // }


    private function getValidationRules()
    {
        return [
            'title' => 'required|max:255',
            'text' => 'required',
        ];
    }
}
