<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of published posts (Blog Index).
     */
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('pages.posts.index', compact('posts'));
    }

    /**
     * Display the specified post (Blog Show).
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get related posts from the same category
        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        // If not enough posts in same category, fill with other posts
        if ($relatedPosts->count() < 3) {
            $additionalPosts = Post::where('is_published', true)
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->merge($additionalPosts);
        }

        return view('pages.posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Upload image for Summernote editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('posts/images', $filename, 'public');
            
            return response()->json([
                'url' => \Illuminate\Support\Facades\Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
