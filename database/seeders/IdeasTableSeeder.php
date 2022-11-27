<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class IdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 5; $i++) {
            $idea = new Idea();
            $idea->title = $faker->realText($maxNbChars = 10);
            $idea->slug = Idea::generateIdeaSlugFromTitle($idea->title);
            $idea->text = $faker->realText($maxNbChars = 100);
            $idea->user_id = $faker->numberBetween(1, User::count());
            $idea->save();
            $tags = [];
            for ($j = 0; $j < Tag::count(); $j++) {
                $tags[] = ($faker->numberBetween(1, Tag::count()));
            }
            $idea->tags()->sync($tags);
            // $idea->tags()->sync([1, 2]);

            $roles = [];
            for ($j = 0; $j < Role::count(); $j++) {
                $roles[] = ($faker->numberBetween(1, Role::count()));
            }
            $idea->roles()->sync($roles);
            // $idea->roles()->sync([1, 2]);
        }
    }
}
