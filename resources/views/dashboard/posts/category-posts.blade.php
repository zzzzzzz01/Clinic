<x-layouts.main.website>

<link rel="stylesheet" href="{{ asset('temp2/css/posts.css') }}" />

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
            <li class="breadcrumb-item active">
                <span style="color: #808080;">{{ $category->name }}</span>
            </li>
        </ol>
    </nav>

    <div class="search-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0">{{ $category->name }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="news-wrapper">
    <div class="container">
        <!-- Search and Add Post -->
        <div class="search-post-row">
            <div class="search-input">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="@lang('words.search_news_placeholder')" id="newsSearch">
            </div>
            <a href="{{ route('posts.create') }}" class="add-post-btn">
                <i class="fas fa-plus"></i> <span>@lang('words.add_post')</span>
            </a>
        </div>

        <div class="news-grid">
            <!-- Main News -->
            <div class="news-main">
                <div class="news-cards">
                    @forelse($posts as $post)
                    <div class="news-card">
                        <div class="news-image">
                            <img src="{{ asset('storage/'.$post->photo) }}" alt="{{ $post->title }}">
                            <span class="news-category">{{ $post->category->name ?? __('words.no_category') }}</span>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="fa fa-calendar-alt"></i> {{ $post->created_at->format('d M Y') }}</span>
                                <span><i class="fa fa-comments"></i> {{ $post->comments->count() }} @lang('words.comments')</span>
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="news-title">{{ $post->title }}</a>
                            <p class="news-excerpt">{{ $post->description }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="news-read-more">@lang('words.read_more')</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">@lang('words.no_news')</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="news-sidebar">
                <!-- Popular News -->
                @include('partials.posts.popular-news')

                <!-- Categories -->
                @include('partials.posts.categories')

                <!-- Tags -->
                @include('partials.posts.tags')
            </div>
        </div>
    </div>
</div>

</x-layouts.main.website>