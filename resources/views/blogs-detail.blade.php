<x-layouts.main.app>
 
<link href="{{ asset('temp/css/blogs.css') }}" rel="stylesheet">

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown">{{ $post['title'] }}</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main_page')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blogs.page') }}">@lang('words.news')</a></li>
            <li class="breadcrumb-item active text-primary">{{ Str::limit($post['title'], 30) }}</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Blog Detail Start -->
<div class="container blog-detail-wrapper">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="blog-detail-card"> 
                <div class="blog-img-show">
                    <img src="{{ $formattedPost['image'] }}" alt="{{ $formattedPost['title'] }}" class="blog-detail-image-show"> 
                    <span class="news-category">{{ $formattedPost['category'] }}</span>
                </div>

                
                <div class="post-meta">
                    <span class="post-meta-item">
                        <i class="fa fa-calendar-alt"></i> {{ $formattedPost['created_at'] }}
                    </span>
                    <span class="post-meta-divider">|</span>

                    <span class="post-meta-item">
                        <i class="fa fa-user"></i> {{ $formattedPost['author'] }}
                    </span>
                    <span class="post-meta-divider">|</span>

                    <span class="post-meta-item">
                        <i class="fa fa-eye"></i> {{ $post['views'] }}
                    </span> 

                    <span class="post-meta-divider">|</span>

                    <span class="post-meta-item  like-btn {{ auth()->check() && $post->isLikedByUser(auth()->id()) ? 'liked' : '' }}"
                        onclick="handleLike({{ $post->id }}, this)" style="cursor: pointer;">
                        <i class="fas fa-thumbs-up"></i> 
                        <span class="like-count">{{ $formattedPost['liked'] }}</span>
                    </span>
                    <span class="post-meta-divider">|</span>
                    
                    <span class="post-meta-item dislike-btn {{ auth()->check() && $post->isDislikedByUser(auth()->id()) ? 'disliked' : '' }}"
                        onclick="handleDislike({{ $post->id }}, this)" style="cursor: pointer;">
                        <i class="fas fa-thumbs-down"></i>
                        <span class="dislike-count">{{ $formattedPost['disliked'] }}</span>
                    </span> 
                </div>
                <div class="blog-detail-content">
                    
                    <h1 class="blog-detail-title">{{ $post['title'] }}</h1>
                    
                    <div class="blog-detail-text">
                        {!! $post['content'] !!}
                    </div>
                    
                    <!-- Tags -->
                    @if(isset($post['tags']) && count($post['tags']) > 0)
                    <div class="blog-tags">
                        @foreach($post['tags'] as $tag)
                        <a href="#" class="blog-tag">#{{ $tag['name'] }}</a>
                        @endforeach
                    </div>
                    @endif 
                    
                    <!-- Comments -->
                    <div class="comments-section">
                        <h4 class="comments-title">
                            @lang('words.comments')
                            <span>{{ $post['comments_count'] }}</span>
                        </h4>
                        
                        <!-- Comment Form -->
                        @auth
                        <div class="comment-form">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <textarea placeholder="Fikringizni yozing..." name="message" required></textarea>
                                <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="form-actions">
                                    <button type="submit" class="submit-btn">
                                        @lang('words.send')
                                    </button>
                                </div>
                            </form>
                        </div>
                        @else
                        <div class="alert alert-info">
                            Sharh yozish uchun <a href="{{ route('auth.login') }}">tizimga kiring</a>
                        </div>
                        @endauth
                        
                        <!-- Comments List -->
                        <div class="comments-list">
                            @forelse($formattedPost['comments'] as $comment)
                            <div class="comment-item">
                                <div class="comment-avatar">{{ Str::upper(substr($comment['user_name'], 0, 1)) }}</div>
                                <div class="comment-body">
                                    <div class="comment-user">
                                        {{ $comment['user_name'] }}
                                        @if($comment['is_admin'])
                                        <span class="badge">Admin</span>
                                        @endif
                                        <span class="comment-date">
                                            <i class="fa fa-calendar-alt"></i> {{ $comment['created_at_human'] }}
                                        </span>
                                    </div>
                                    <p class="comment-text">{{ $comment['message'] }}</p>
                                    <div class="comment-actions">
                                        <button onclick="replyComment(this)"><i class="fas fa-reply"></i> Javob</button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted">Hozircha sharhlar mavjud emas. Birinchi bo'lib sharh qoldiring!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="blog-sidebar">
                <!-- Popular Posts -->
                @include('partials.blogs.popular-posts')
                
                <!-- Categories -->
                @include('partials.blogs.categories')
            </div>
        </div>
    </div>
</div>
<!-- Blog Detail End -->

<script src="{{ asset('temp/js/blogs.js') }}"></script>

</x-layouts.main.app>