<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class IdeaRole extends Model
{
    protected $table = 'idea_role';


    public function users()
    {
        return $this->belongsToMany(User::class, 'idea_role_user', 'idea_role_id', 'user_id')->withPivot('chosen');
    }

    protected $fillable = [
        'assigned',
    ];

    public $timestamps = false;
}
