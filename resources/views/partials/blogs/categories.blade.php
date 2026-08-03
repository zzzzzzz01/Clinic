<div class="sidebar-widget wow fadeInUp">
    <h4 class="sidebar-widget-title">@lang('words.categories')</h4>
    <ul class="category-list">
        @foreach($categories as $category)
        <li>
            <a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a>
            <span class="category-count">{{ $category->posts_count }}</span>
        </li>
        @endforeach 
    </ul>
</div>