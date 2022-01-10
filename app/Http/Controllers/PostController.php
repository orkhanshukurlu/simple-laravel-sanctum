<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $posts = auth()->user()->posts;
        return $this->responseData('Success', $posts);
    }

    public function store(CreatePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->only('name'));
        return $this->responseData('Success', $post);
    }

    public function show(Post $post)
    {
        return $this->responseData('Success', $post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->only('name'));
        return $this->responseData('Success', $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return $this->responseMessage('Success', 'Post deleted');
    }
}