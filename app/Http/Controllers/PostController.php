<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPosts()
    {
        return Post::select('id', 'heading', 'description')->get()->toJson();
    }

    public function getPost(Post $post)
    {
        return $post::where('id', $post->id)
            ->with('comments')
            ->limit(1)
            ->get()
            ->toJson();
    }
}
