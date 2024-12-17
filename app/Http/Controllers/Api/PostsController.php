<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('publication_date', 'desc')->get();
        return $this->sendResponse(PostResource::collection($posts), 'Posts retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|unique:posts',
            'content' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'publication_date' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $post = Post::create($input);

        return $this->sendResponse(new PostResource($post), 'Post created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }
        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|unique:posts,title,' . $post->id,
            'content' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'publication_date' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $post->title = $input['title'];
        $post->content = $input['content'];
        $post->author_id = $input['author_id'];
        $post->category_id = $input['category_id'];
        $post->publication_date = $input['publication_date'];
        $post->save();

        return $this->sendResponse(new PostResource($post), 'Post updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return $this->sendResponse([], 'Post deleted successfully.');
    }
}
