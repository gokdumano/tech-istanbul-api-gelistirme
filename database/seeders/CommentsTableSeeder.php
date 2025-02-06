<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Http;

use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://dummyjson.com/comments', [
            'limit'  => 0,
            'select' => ['body', 'user', 'postId']
        ]);

        $comments = $response->json()['comments'];
        
        foreach ($comments as $comment) {
            Comment::create([
                'body'    => $comment['body'],
                'user_id' => $comment['user']['id'],
                'post_id' => $comment['postId']
            ]);
        }
    }
}
