<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Idea extends Model
{

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users()
    {
        return $this->BelongsToMany('App\Models\User', 'idea_user');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    protected $fillable = [
        'title',
        'text',
        'slug',
        'user_id',
    ];

    public static function generateIdeaSlugFromTitle($title)
    {
        $base_slug = Str::slug($title, '-');
        $slug = $base_slug;
        $count = 1;
        $find_slug = Idea::where('slug', $slug)->first();
        while ($find_slug) {
            $slug = $base_slug . '-' . $count;
            $find_slug = Idea::where('slug', $slug)->first();
            $count++;
        }
        return $slug;
    }
}
