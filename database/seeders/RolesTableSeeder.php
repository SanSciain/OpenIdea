<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['developer', 'artist', 'project manager', 'designer'];

        foreach ($roles as $item) {
            $role = new Role();
            $role->name = $item;
            $role->save();
        }
    }
}
