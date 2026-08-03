<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    /**
     * Get all tags with cache
     */
    public function getTags()
    {
        return Cache::remember('tags_list', 3600, function() {
            return Tag::withCount('posts')->get();
        });
    }

    /**
     * Get all categories with cache
     */
    public function getCategories()
    {
        return Cache::remember('categories_list', 3600, function() {
            return Category::withCount('posts')->get();
        });
    }

    /**
     * Get popular posts with cache
     */
    public function getPopularPosts($limit = 5)
    {
        return Cache::remember('popular_posts', 1800, function() use ($limit) {
            return Post::select('id', 'title_uz', 'title_ru', 'title_en', 'photo', 'views', 'created_at')
                ->with('category')
                ->orderBy('views', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get paginated posts with cache
     */
    public function getPosts($perPage = 10)
    {
        $page = request('page', 1);
        $cacheKey = 'posts_page_' . $page;

        return Cache::remember($cacheKey, 600, function() use ($perPage) {
            return Post::select('id', 'title_uz', 'title_ru', 'title_en', 'photo', 'description_uz', 'description_ru', 'description_en', 'category_id', 'created_at')
                ->with(['category', 'comments'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }

    /**
     * Get all post data for index page
     */
    public function getIndexData()
    {
        return [
            'tags' => $this->getTags(),
            'categories' => $this->getCategories(),
            'popularPosts' => $this->getPopularPosts(),
            'posts' => $this->getPosts(),
        ];
    }

    public function getcategoryPosts()
    {
        return [
            'tags' => $this->getTags(),
            'categories' => $this->getCategories(),
            'popularPosts' => $this->getPopularPosts(),
        ];
    }

    public function getCreateData()
    {
        return [
            'tags' => $this->getTags(),
            'categories' => $this->getCategories(), 
        ];
    }
    

    /**
     * Clear all post related cache
     */
    public function clearCache()
    {
        // Clear popular posts
        Cache::forget('popular_posts');
        
        // Clear tags and categories
        Cache::forget('tags_list');
        Cache::forget('categories_list');
        
        // Clear all paginated posts cache
        $keys = Redis::keys('posts_page_*');
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    public function clearPostCache(): void
    {
        // 1. Popular posts cache
        Cache::forget('popular_posts');
        
        // 2. Tags cache
        Cache::forget('tags_list');
        
        // 3. Categories cache
        Cache::forget('categories_list');
        
        // 4. All paginated posts (page 1-20)
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget('posts_page_' . $i);
        }
        
        // 5. Single post cache (agar mavjud bo'lsa)
        // Cache::forget('post_' . $post->id);
    }

    /**
     * Clear post cache by key
     */
    public function clearCacheByKey($key)
    {
        Cache::forget($key);
    }

    public function blogData()
    {
        $posts = Post::with(['category', 'user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);
        
        $formattedPosts = $this->formatPosts($posts);
        
        $popularPosts = $this->formatPosts(
            Post::with(['category', 'user'])
                ->withCount(['comments', 'likes'])
                ->orderByDesc('views')
                ->take(5)
                ->get()
        );
        
        $categories = Category::withCount('posts')->get();
        
        // Pagination ni saqlab qolish uchun
        $paginatedPosts = new \Illuminate\Pagination\LengthAwarePaginator(
            $formattedPosts,
            $posts->total(),
            $posts->perPage(),
            $posts->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return compact('paginatedPosts', 'popularPosts', 'categories');
    }

    public function formatPosts($posts)
    {
        return $posts->map(function ($post) {
            return $this->formatPost($post);
        });
    }

    public function formatPost(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'description' => Str::limit(strip_tags($post->description), 150),
            'image' => asset('storage/' . $post->photo),
            'category' => $post->category?->name,
            'category_slug' => $post->category?->slug,
            'author' => $post->user?->name,
            'views' => $post->views,
            'liked' => $post->likes()->where('is_liked', true)->count(),
            'disliked' => $post->likes()->where('is_liked', false)->count(),
            'likes_count' => $post->likes_count,
            'comments_count' => $post->comments_count,
            'created_at' => $post->created_at->format('d M Y'),
            'created_at_human' => $post->created_at->diffForHumans(),
            'url' => route('blogs.detail', $post->id),
        ];
    }

    /**
     * Get blog detail data
     */
    public function blogDetailData($id)
    {
        $post = Post::with(['category', 'user', 'tags', 'comments.user'])
            ->withCount(['comments', 'likes'])
            ->findOrFail($id);
        
        // Increment views
        $post->increment('views');
        
        $formattedPost = $this->formatPost($post);
        
        // Add content to formatted post
        $formattedPost['content'] = $post->content;
        
        // Add comments to formatted post
        $formattedPost['comments'] = $post->comments->map(function($comment) {
            return [
                'id' => $comment->id,
                'message' => $comment->message,
                'user_name' => $comment->user->name,
                'is_admin' => $comment->user->isAdmin() ?? false,
                'created_at_human' => $comment->created_at->diffForHumans(),
            ];
        });
        
        // Add tags to formatted post
        $formattedPost['tags'] = $post->tags->pluck('name')->toArray();
        
        $popularPosts = $this->formatPosts(
            Post::with(['category', 'user'])
                ->withCount(['comments', 'likes'])
                ->orderByDesc('views')
                ->take(5)
                ->get()
        );
        
        $categories = Category::withCount('posts')->get();
        
        return compact('post', 'popularPosts', 'categories', 'formattedPost');
    }
}