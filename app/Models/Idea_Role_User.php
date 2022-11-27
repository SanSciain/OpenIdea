<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Idea_Role_User extends Pivot
{
    protected $table = 'idea_role_user';
    protected $primaryKey = ['idea_id', 'role_id', 'user_id'];
    public $incrementing = false;
}
