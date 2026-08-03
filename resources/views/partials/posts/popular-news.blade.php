<div class="sidebar-widget">
    <h4 class="sidebar-widget-title">@lang('words.popular_posts')</h4>
    
    @forelse($popularPosts as $post)
    <div class="popular-news-item">
        <div class="popular-news-image">
            <img src="{{ asset('storage/'.$post->photo) }}" alt="{{ $post->title }}">
        </div>
        <div class="popular-news-info">
            <a href="{{ route('posts.show', $post) }}" class="popular-news-title">
                {{ $post->title }}
            </a>
            <span class="popular-news-date">
                <i class="fas fa-calendar-alt"></i> 
                {{ $post->created_at->format('d M Y') }}
            </span>
        </div>
    </div>
    @empty
    <p class="text-muted text-center py-2">@lang('words.no_popular_posts')</p>
    @endforelse
</div>