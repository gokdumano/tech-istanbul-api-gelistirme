<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Http;

use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://dummyjson.com/posts', [
            'limit'  => 0,
            'select' => ['title', 'body', 'userId']
        ]);

        $posts = $response->json()['posts'];

        foreach ($posts as $post) {
            Post::create([
                'title'   => $post['title'],
                'body'    => $post['body'],
                'user_id' => $post['userId']
            ]);
        }
    }
}
