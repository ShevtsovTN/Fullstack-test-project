<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws BindingResolutionException
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
            'text' => 'required|string'
        ]);
        $faker = Container::getInstance()->make(Generator::class);
        $author = $faker->name(null);
        $updated_at = now();
        $created_at = now();
        $id = Comment::insertGetId([
            'post_id' => $request->id,
            'content' => $request->text,
            'author' => $author,
            'updated_at' => $updated_at,
            'created_at' => $created_at,
        ]);
        if (!empty($id)) {
            return response([
                'id' => $id,
                'content' => $request->text,
                'author' => $author,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ], 200);
        } else {
            return response('Comment has not been added', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
            'text' => 'required|string'
        ]);
        $comment = Comment::find($request->id);
        $updated_at = now();
        $result = $comment->update([
            'content' => $request->text,
            'updated_at' => $updated_at
        ]);
        if (!empty($result)) {
            return response([
                'id' => $request->id,
                'content' => $request->text,
                'author' => $comment->author,
                'created_at' => $comment->created_at,
                'updated_at' => $updated_at,
            ], 200);
        } else {
            return response('Comment has not been updated', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $id = intval($id);
        Comment::find($id)->delete();
        if (Comment::where('id', $id)->doesntExist()) {
            return response('Comment has been deleted', 200);
        } else {
            return response('Comment has not been deleted', 400);
        }
    }
}
