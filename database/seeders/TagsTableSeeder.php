<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['game', 'movie', 'code', 'art'];

        foreach ($tags as $item) {
            $tag = new Tag();
            $tag->name = $item;
            $tag->save();
        }
    }
}
