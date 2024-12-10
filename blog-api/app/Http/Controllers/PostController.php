<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{



    public function store(StorePostRequest $request)
    {

        $user = auth()->user();

        $post = Post::create($request->validated() + ['author_id' => $user->id]);

        return response()->json($post, 201);
    }

    public function index(Request $request)
    {
        $cacheKey = 'posts_' . md5(serialize($request->all()));

        $posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Post::query();

            if ($request->has('category')) {
                $query->where('category', $request->category);
            }

            if ($request->has('author')) {
                $query->where('author_id', $request->author);
            }

            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            return $query->paginate(10);
        });

        return response()->json($posts);
    }



    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        return response()->json($post);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        if ($user->id !== $post->author_id ) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post->update($request->validated());

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $user = auth()->user();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        if ($user->id !== $post->author_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $post->comments()->delete();
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
