<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function roles()
    {
        return $this->hasMany('App\Role');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
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
