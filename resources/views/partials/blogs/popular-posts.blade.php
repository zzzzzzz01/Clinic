<div class="sidebar-widget wow fadeInUp">
    <h4 class="sidebar-widget-title">@lang('words.popular_posts')</h4>
    
    @foreach($popularPosts as $popularPost)
    <div class="popular-post-item">
        <div class="popular-post-image">
            <img src="{{ $popularPost['image'] }}" alt="{{ $popularPost['title'] }}">
        </div>
        <div class="popular-post-info">
            <a href="{{ route('blogs.detail', $popularPost['id']) }}" class="popular-post-title">{{ $popularPost['title'] }}</a>
            <span class="popular-post-date"><i class="fa fa-calendar-alt"></i> {{ $popularPost['created_at'] }}</span>
        </div>
    </div>
    @endforeach
</div>