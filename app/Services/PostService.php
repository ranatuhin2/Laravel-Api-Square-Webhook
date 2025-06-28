<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function create(CreateRequest $request, Post $post): Post
    {
        $post = $post->forceFill([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $post->save();

        return $post;

    }

    public function update(UpdateRequest $request, Post $post): void
    {
        $post->update([
            'title' => $request->title ?? $post->title,
            'description' => $request->description ?? $post->description,
        ]);

    }
}
