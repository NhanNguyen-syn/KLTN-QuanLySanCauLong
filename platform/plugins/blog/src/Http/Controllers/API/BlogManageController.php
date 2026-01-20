<?php

namespace Botble\Blog\Http\Controllers\API;

use Botble\Api\Http\Controllers\BaseApiController;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Tag;
use Illuminate\Http\Request;

/**
 * Blog Admin API Controller
 * Manage Posts, Categories, and Tags
 */
class BlogManageController extends BaseApiController
{
    // =====================
    // POST MANAGEMENT
    // =====================

    public function storePo(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable|in:published,draft,pending',
            'image' => 'nullable|string',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $post = Post::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'] ?? null,
            'status' => $data['status'] ?? 'draft',
            'image' => $data['image'] ?? null,
        ]);

        if (!empty($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $this
            ->httpResponse()
            ->setData($post->load(['categories', 'tags']))
            ->setMessage('Post created successfully')
            ->toApiResponse();
    }

    public function updatePost(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable|in:published,draft,pending',
            'image' => 'nullable|string',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $post->update($data);

        if (isset($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $this
            ->httpResponse()
            ->setData($post->load(['categories', 'tags']))
            ->setMessage('Post updated successfully')
            ->toApiResponse();
    }

    public function destroyPost(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return $this
            ->httpResponse()
            ->setMessage('Post deleted successfully')
            ->toApiResponse();
    }

    // =====================
    // CATEGORY MANAGEMENT
    // =====================

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:published,draft',
            'parent_id' => 'nullable|integer|exists:categories,id',
        ]);

        $category = Category::create($data);

        return $this
            ->httpResponse()
            ->setData($category)
            ->setMessage('Category created successfully')
            ->toApiResponse();
    }

    public function updateCategory(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:published,draft',
            'parent_id' => 'nullable|integer|exists:categories,id',
        ]);

        $category->update($data);

        return $this
            ->httpResponse()
            ->setData($category)
            ->setMessage('Category updated successfully')
            ->toApiResponse();
    }

    public function destroyCategory(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return $this
            ->httpResponse()
            ->setMessage('Category deleted successfully')
            ->toApiResponse();
    }

    // =====================
    // TAG MANAGEMENT
    // =====================

    public function storeTag(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:published,draft',
        ]);

        $tag = Tag::create($data);

        return $this
            ->httpResponse()
            ->setData($tag)
            ->setMessage('Tag created successfully')
            ->toApiResponse();
    }

    public function updateTag(Request $request, int $id)
    {
        $tag = Tag::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:published,draft',
        ]);

        $tag->update($data);

        return $this
            ->httpResponse()
            ->setData($tag)
            ->setMessage('Tag updated successfully')
            ->toApiResponse();
    }

    public function destroyTag(int $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return $this
            ->httpResponse()
            ->setMessage('Tag deleted successfully')
            ->toApiResponse();
    }
}
