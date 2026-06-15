<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Check if current user is admin
     */
    private function ensureAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }
    }

    /**
     * Get all blogs (admin)
     */
    public function index()
    {
        $this->ensureAdmin();

        return response()->json(
            Blog::with('author:id,name,email')
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    /**
     * Create a new blog post
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $validated['author_id'] = Auth::id();

        if ($request->is_published) {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

        return response()->json([
            'message' => 'Blog created successfully',
            'blog' => $blog->load('author:id,name,email')
        ], 201);
    }

    /**
     * Get a single blog
     */
    public function show(Blog $blog)
    {
        $this->ensureAdmin();

        return response()->json($blog->load('author:id,name,email'));
    }

    /**
     * Update a blog post
     */
    public function update(Request $request, Blog $blog)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Set published_at if publishing for the first time
        if ($request->is_published && !$blog->is_published) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return response()->json([
            'message' => 'Blog updated successfully',
            'blog' => $blog->load('author:id,name,email')
        ]);
    }

    /**
     * Delete a blog post
     */
    public function destroy(Blog $blog)
    {
        $this->ensureAdmin();

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }

    /**
     * Get published blogs (public)
     */
    public function publicIndex()
    {
        return response()->json(
            Blog::with('author:id,name')
                ->published()
                ->orderBy('published_at', 'desc')
                ->get()
        );
    }
}
