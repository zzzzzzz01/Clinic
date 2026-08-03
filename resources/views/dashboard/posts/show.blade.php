<x-layouts.main.website>

<link rel="stylesheet" href="{{ asset('temp2/css/posts.css') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">  

<div class="container pt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                    <i class="fas fa-home"></i> @lang('words.main.page')
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index') }}" class="text-decoration-none">
                    @lang('words.news')
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" style="color: #808080;" class="text-decoration-none">
                    {{ \Illuminate\Support\Str::limit($post->title, 20) }}
                </a>
            </li> 
        </ol>
    </nav>

    <div class="search-card">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4 class="mb-0">{{ \Illuminate\Support\Str::limit($post->title, 60) }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="container"> 
    <div class="post-grid">
        <!-- ===== MAIN CONTENT ===== -->
        <div class="post-main">
            <!-- Post Card -->
            <div class="post-card">
                @if($post->photo)
                <div class="post-image">
                    <img src="{{ asset('storage/'.$post->photo) }}" alt="{{ $post->title }}">
                    @if($post->category)
                        <span class="post-category">{{ $post->category->name }}</span>
                    @endif
                </div>
                @endif
                <!-- Meta -->
                <div class="post-meta">
                    <span class="post-meta-item">
                        <i class="fas fa-calendar-alt"></i> 
                        {{ $post->created_at->format('d M Y') }}
                    </span>
                    <span class="post-meta-divider">|</span>
                    <span class="post-meta-item">
                        <i class="fas fa-user"></i> 
                        {{ $post->user->name ?? 'Admin' }}
                    </span>
                    <span class="post-meta-divider">|</span>
                    <span class="post-meta-item">
                        <i class="fas fa-eye"></i> 
                        {{ $post->views ?? 0 }}
                    </span>
                    <span class="post-meta-divider">|</span>
                    
                    <!-- LIKE TUGMA -->
                    <span class="post-meta-item like-btn {{ auth()->check() && $post->isLikedByUser(auth()->id()) ? 'liked' : '' }}" 
                        onclick="handleLike({{ $post->id }}, this)" style="cursor: pointer;">
                        <i class="fas fa-thumbs-up"></i>
                        <span class="like-count">{{ $post->likes()->where('is_liked', true)->count() }}</span>
                    </span>

                    <span class="post-meta-divider">|</span>

                    <!-- DISLIKE TUGMA -->
                    <span class="post-meta-item dislike-btn {{ auth()->check() && $post->isDislikedByUser(auth()->id()) ? 'disliked' : '' }}" 
                        onclick="handleDislike({{ $post->id }}, this)" style="cursor: pointer;">
                        <i class="fas fa-thumbs-down"></i>
                        <span class="dislike-count">{{ $post->likes()->where('is_liked', false)->count() }}</span>
                    </span>
                    
                    <span class="post-meta-divider comment">|</span>
                    <span class="post-meta-item comment">
                        <i class="fas fa-comment"></i> 
                        {{ $commentCount }}
                    </span>
                </div>

                <div class="post-content">

                    <!-- Title -->
                    <h1 class="post-title">{{ $post->title }}</h1>
                    
                    <!-- Description -->
                    @if($post->description)
                    <div class="post-description">
                        {{ $post->description }}
                    </div>
                    @endif
                    
                    <div class="post-divider"></div>

                    <!-- Body (Content) -->
                    <div class="post-body">
                        {!! $post->content !!}
                    </div>
                    

                    <!-- Tags -->
                    @if($post->tags && $post->tags->count() > 0)
                    <div class="post-tags">
                        @foreach($post->tags as $tag)
                            <a href="#" class="post-tag">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            @if(auth()->check() && (auth()->user()->id == $post->user_id || auth()->user()->isAdmin()))
            <div class="post-actions-widget mobile">
                <div class="post-action-buttons">
                    <a href="{{ route('posts.edit', $post) }}" class="post-action-btn edit-btn">
                        <i class="fas fa-edit"></i>
                        <span>@lang('words.edit')</span>
                    </a>
                    <a href="#" class="post-action-btn delete-btn" onclick="openDeleteDialog({{ $post->id }}, '{{ $post->title }}')">
                        <i class="fas fa-trash-alt"></i>
                        <span>@lang('words.delete')</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Comments Section -->
            @include('partials.posts.comments')
        </div>

        <!-- ===== SIDEBAR ===== -->
        <div class="post-sidebar">
            
            <!-- POST ACTIONS -->
            @if(auth()->check() && (auth()->user()->id == $post->user_id || auth()->user()->isAdmin()))
            <div class="post-actions-widget network">
                <div class="post-action-buttons">
                    <a href="{{ route('posts.edit', $post) }}" class="post-action-btn edit-btn">
                        <i class="fas fa-edit"></i>
                        <span>@lang('words.edit')</span>
                    </a>
                    <a href="#" class="post-action-btn delete-btn" onclick="openDeleteDialog({{ $post->id }}, '{{ $post->title }}')">
                        <i class="fas fa-trash-alt"></i>
                        <span>@lang('words.delete')</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Popular News -->
            @include('partials.posts.popular-news')
 
            <!-- Categories -->
            @include('partials.posts.categories')

            <!-- Tags -->
            @include('partials.posts.tags')
        </div>
    </div>
</div>  

@include('partials.modals.delete-modals.posts')

<script src="{{ asset('temp2/js/posts.js') }}"></script>

</x-layouts.main.website>