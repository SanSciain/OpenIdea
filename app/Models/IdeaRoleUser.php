<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IdeaRoleUser extends Pivot
{
    protected $table = 'idea_role_user';

    // protected $fillable = [
    //     'idea_id',
    //     'role_id',
    //     'user_id',
    // ];
}
