<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use App\Models\PostLike;
use Illuminate\Http\Request;
use App\Notifications\PostCreated; 
use App\Services\PostService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $data = $this->postService->getIndexData();
        return view('dashboard.posts.index', $data);
    }

    public function create()
    {  
        $data = $this->postService->getCreateData();
        return view('dashboard.posts.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title_uz' => 'required',
                'title_ru' => 'required',
                'title_en' => 'required',
                'content_uz' => 'required',
                'content_ru' => 'required',
                'content_en' => 'required',
                'description_uz' => 'required',
                'description_ru' => 'required',
                'description_en' => 'required',
            ]);
    
            if ($request->hasFile('photo')) {
                $name = time() . '_' . $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->storeAs('imagePost', $name, 'public'); 
            }
    
            $post = Post::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'title_uz' => $request->title_uz,
                'title_ru' => $request->title_ru,
                'title_en' => $request->title_en,
                'content_uz' => $request->content_uz,
                'content_ru' => $request->content_ru,
                'content_en' => $request->content_en,
                'description_uz' => $request->description_uz,
                'description_ru' => $request->description_ru,
                'description_en' => $request->description_en,
                'photo' => $path ?? null,
            ]);
    
            if ($request->filled('tags')) {
                $tags = $request->tags;
                if (is_string($tags)) {
                    $tags = array_map('trim', explode(',', $tags));
                }
                $tagIds = array_filter($tags, function($tag) {
                    return !empty($tag) && is_numeric($tag);
                });
                if (!empty($tagIds)) {
                    $post->tags()->attach($tagIds);
                }
            }

            $this->postService->clearPostCache();
    
            $usersToNotify = User::where('id', '!=', auth()->id())->get();
            Notification::send($usersToNotify, new PostCreated($post));
    
            return redirect()->route('posts.index')->with('success', __('words.post.create'));
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())->withInput();
        }
    }

    public function categoryPosts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        // Kategoriyaga tegishli postlarni olamiz
        $posts = Post::where('category_id', $category->id)
                    ->with(['category', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        // Service dan ma'lumotlarni olamiz
        $data = $this->postService->getcategoryPosts();
        
        // $data ni ochib, alohida o'zgaruvchilarga ajratamiz
        $tags = $data['tags'];
        $categories = $data['categories'];
        $popularPosts = $data['popularPosts'];

        return view('dashboard.posts.category-posts', compact('posts', 'tags', 'categories', 'popularPosts', 'category'));
    }

    public function tagPosts($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        // Kategoriyaga tegishli postlarni olamiz
        $posts = Post::where('category_id', $tag->id)
                    ->with(['category', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        // Service dan ma'lumotlarni olamiz
        $data = $this->postService->getcategoryPosts();
        
        // $data ni ochib, alohida o'zgaruvchilarga ajratamiz
        $tags = $data['tags'];
        $categories = $data['categories'];
        $popularPosts = $data['popularPosts'];

        return view('dashboard.posts.tag-posts', compact('posts', 'tags', 'categories', 'popularPosts', 'tag'));
    } 

    public function show(Post $post)
    {
        $popularPosts = Post::where('id', '!=', $post->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(4)
                            ->get();
        
        $categories = Category::withCount('posts')->get();
        $comments = $post->comments; 
        $commentCount = $comments->count();
        $tags = Tag::all();
        $post->increment('views');
        
        return view('dashboard.posts.show', compact('post', 'popularPosts', 'categories', 'tags', 'comments', 'commentCount'));
    }

    public function edit(Post $post) 
    { 
        $data = $this->postService->getCreateData();
        return view('dashboard.posts.edit', compact('data', 'post'));
    }

    public function update(Request $request, Post $post)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title_uz' => 'required|string|max:255',
                'title_ru' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'content_uz' => 'required|string',
                'content_ru' => 'required|string',
                'content_en' => 'required|string',
                'description_uz' => 'required|string',
                'description_ru' => 'required|string',
                'description_en' => 'required|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'required|in:0,1',
            ]);

            $data = [
                'category_id' => $request->category_id,
                'title_uz' => $request->title_uz,
                'title_ru' => $request->title_ru,
                'title_en' => $request->title_en,
                'content_uz' => $request->content_uz,
                'content_ru' => $request->content_ru,
                'content_en' => $request->content_en,
                'description_uz' => $request->description_uz,
                'description_ru' => $request->description_ru,
                'description_en' => $request->description_en,
                'status' => $request->status,
            ];

            if ($request->hasFile('photo')) {
                if ($post->photo && Storage::disk('public')->exists($post->photo)) {
                    Storage::disk('public')->delete($post->photo);
                }
                $name = time() . '_' . $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->storeAs('imagePost', $name, 'public');
                $data['photo'] = $path;
            }

            $post->update($data);

            if ($request->filled('tags')) {
                $tags = $request->tags;
                if (is_string($tags)) {
                    $tags = array_map('trim', explode(',', $tags));
                }
                $tagIds = array_filter($tags, function($tag) {
                    return !empty($tag) && is_numeric($tag);
                });
                if (!empty($tagIds)) {
                    $post->tags()->sync($tagIds);
                } else {
                    $post->tags()->detach();
                }
            } else {
                $post->tags()->detach();
            }

            $this->postService->clearPostCache();

            return redirect()->route('posts.index')->with('success', __('words.post.update'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Post $post)
    {
        try {
            if ($post->photo && Storage::disk('public')->exists($post->photo)) {
                Storage::disk('public')->delete($post->photo);
            }
            $post->tags()->detach();
            $post->likes()->delete();
            $post->delete();
            $this->postService->clearPostCache();
            return redirect()->route('posts.index')->with('success', 'Post muvaffaqiyatli o\'chirildi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

        // Search posts
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([]);
        }
        
        $posts = Post::where('title_uz', 'LIKE', "%{$query}%")
                    ->orWhere('title_ru', 'LIKE', "%{$query}%")
                    ->orWhere('title_en', 'LIKE', "%{$query}%")
                    ->orWhere('description_uz', 'LIKE', "%{$query}%")
                    ->orWhere('description_ru', 'LIKE', "%{$query}%")
                    ->orWhere('description_en', 'LIKE', "%{$query}%")
                    ->orWhere('content_uz', 'LIKE', "%{$query}%")
                    ->orWhere('content_ru', 'LIKE', "%{$query}%")
                    ->orWhere('content_en', 'LIKE', "%{$query}%")
                    ->with(['category', 'comments'])
                    ->withCount('comments')
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get()
                    ->map(function($post) {
                        return [
                            'id' => $post->id,
                            'title' => $post->title,
                            'description' => $post->description,
                            'photo' => $post->photo,
                            'created_at' => $post->created_at,
                            'comments_count' => $post->comments_count,
                            'category' => $post->category ? $post->category->name : null
                        ];
                    });
        
        return response()->json($posts);
    }

    // LIKE - faqat LIKE bosish
    public function like($id)
    {
        try {
            $post = Post::findOrFail($id);
            $userId = auth()->id();

            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            // Mavjud like yoki dislike ni tekshiramiz
            $existing = PostLike::where('post_id', $post->id)
                               ->where('user_id', $userId)
                               ->first();

            if ($existing) {
                // Agar mavjud bo'lsa
                if ($existing->is_liked == 1) {
                    // Like bor -> like ni o'chiramiz
                    $existing->delete();
                } else {
                    // Dislike bor -> like ga o'zgartiramiz (is_liked = 1)
                    $existing->is_liked = 1;
                    $existing->save();
                }
            } else {
                // Yangi like qo'shamiz (is_liked = 1)
                PostLike::create([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                    'is_liked' => 1
                ]);
            }

            // Sonlarni hisoblaymiz
            $likedCount = PostLike::where('post_id', $post->id)->where('is_liked', 1)->count();
            $unlikedCount = PostLike::where('post_id', $post->id)->where('is_liked', 0)->count();

            return response()->json([
                'success' => true,
                'liked_count' => $likedCount,
                'unliked_count' => $unlikedCount
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // DISLIKE - faqat DISLIKE bosish
    public function dislike($id)
    {
        // dd($id);
        try {
            $post = Post::findOrFail($id);
            $userId = auth()->id();

            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            // Mavjud like yoki dislike ni tekshiramiz
            $existing = PostLike::where('post_id', $post->id)
                               ->where('user_id', $userId)
                               ->first();

            if ($existing) {
                // Agar mavjud bo'lsa
                if ($existing->is_liked == 0) {
                    // Dislike bor -> dislike ni o'chiramiz
                    $existing->delete();
                } else {
                    // Like bor -> dislike ga o'zgartiramiz (is_liked = 0)
                    $existing->is_liked = 0;
                    $existing->save();
                }
            } else {
                // Yangi dislike qo'shamiz (is_liked = 0)
                PostLike::create([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                    'is_liked' => 0
                ]);
            }

            // Sonlarni hisoblaymiz
            $likedCount = PostLike::where('post_id', $post->id)->where('is_liked', 1)->count();
            $unlikedCount = PostLike::where('post_id', $post->id)->where('is_liked', 0)->count();

            return response()->json([
                'success' => true,
                'liked_count' => $likedCount,
                'unliked_count' => $unlikedCount
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}