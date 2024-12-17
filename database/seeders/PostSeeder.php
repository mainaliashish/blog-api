<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id');
        $categories = DB::table('categories')->pluck('id');

        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        if ($response->successful()) {
            $posts = $response->json();

            foreach (array_slice($posts, 0, 6) as $post) {
                DB::table('posts')->insert([
                    'title' => $post['title'],
                    'content' => $post['body'],
                    'author_id' => $users->random(),
                    'publication_date' => Carbon::now()->subDays(rand(1, 30)),
                    'category_id' => $categories->random(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            $this->command->error("Failed to fetch posts from JSONPlaceholder.");
        }
    }
}
