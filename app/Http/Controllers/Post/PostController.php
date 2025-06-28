<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = QueryBuilder::for(Post::class)
                ->allowedFilters('id','title','user_id')
                ->allowedIncludes('user')
                ->get();
        return PostResource::collection($posts);
    }

    public function create(CreateRequest $request, PostService $postService, Post $post): Post
    {
        $post = $postService->create($request,$post);
        return $post;
    }


    public function update(UpdateRequest $request, PostService $postService, Post $post): Response
    {
        $postService->update($request,$post);
        return response()->noContent();
    }

    public function delete(Post $post): Response
    {
        $post->delete();
        return response()->noContent();
    }
}
