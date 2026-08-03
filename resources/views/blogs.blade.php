<x-layouts.main.app>

<link href="{{ asset('temp/css/blogs.css') }}" rel="stylesheet">

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown">@lang('words.news')</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">@lang('words.main.page')</a></li> 
            <li class="breadcrumb-item active text-primary">@lang('words.news')</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Blog Start -->
<div class="container">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">@lang('words.news')</h4>
            </div>
            <h1 class="news-section-description">@lang('words.news.section_description')</h1>
            <p class="news-card-excerpt">
                @lang('words.news.section_excerpt')
            </p>
        </div>
        
        <!-- News Wrapper -->
        <div class="news-wrapper">
            <!-- News Main -->
            <div class="news-main">
                <div class="news-grid"> 
                    @foreach($paginatedPosts as $post)
                    <div class="blog-item rounded wow fadeInUp">
                        <div class="blog-img">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}">
                            <span class="news-category">{{ $post['category'] }}</span>
                        </div>

                        <div class="blog-content">
                            <div class="blog-content-inner">
                                <div class="news-meta">
                                    <span>
                                        <i class="fa fa-calendar-alt"></i>
                                        {{ $post['created_at'] }}
                                    </span>

                                    <span>
                                        <i class="fa fa-comments"></i>
                                        {{ $post['comments_count'] }} @lang('words.comments')
                                    </span>
                                </div>

                                <a href="{{ $post['url'] }}" class="news-title">
                                    {{ $post['title'] }}
                                </a>

                                <p class="news-excerpt">
                                    {{ $post['description'] }}
                                </p>

                                <a href="{{ route('blogs.detail', $post['id']) }}" class="news-card-btn">
                                    @lang('words.read_more')
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="pagination-wrapper wow fadeInUp">
                    <ul class="pagination-list">
                        @if($paginatedPosts->onFirstPage())
                            <li class="disabled"><span>&laquo;</span></li>
                        @else
                            <li><a href="{{ $paginatedPosts->previousPageUrl() }}">&laquo;</a></li>
                        @endif

                        @for($i = 1; $i <= $paginatedPosts->lastPage(); $i++)
                            @if($i == $paginatedPosts->currentPage())
                                <li class="active"><span>{{ $i }}</span></li>
                            @else
                                <li><a href="{{ $paginatedPosts->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if($paginatedPosts->hasMorePages())
                            <li><a href="{{ $paginatedPosts->nextPageUrl() }}">&raquo;</a></li>
                        @else
                            <li class="disabled"><span>&raquo;</span></li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- News Sidebar -->
            <div class="news-sidebar">
                <!-- Popular Posts -->
                @include('partials.blogs.popular-posts')
                
                <!-- Categories -->
                @include('partials.blogs.categories')
            </div>
        </div>
    </div>
</div>
<!-- Blog End -->

</x-layouts.main.app>