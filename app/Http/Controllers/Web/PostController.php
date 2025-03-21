<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StorePostRequest;
use App\Http\Requests\Web\UpdatePostRequest;
use App\Models\Post;
use Inertia\Inertia;
use App\DTOs\PostDTO;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('posts/index', [
            'posts' => Post::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('posts/create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postDTO = PostDTO::fromRequest($request);
        Post::create([
            'title' => $postDTO->title,
            'content' => $postDTO->content
        ]);
        return to_route('posts.index')->with('success', 'your message,here');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('posts/edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $postDTO = PostDTO::fromRequest($request);
        $post->update([
            'title' => $postDTO->title,
            'content' => $postDTO->content,
        ]);
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('posts.index');
    }
}
