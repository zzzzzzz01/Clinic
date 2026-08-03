<x-layouts.main.app>
<link href="{{ asset('temp/css/blogs.css') }}" rel="stylesheet">
 

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown">Yangiliklar</h3>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Bosh sahifa</a></li> 
            <li class="breadcrumb-item"><a href="{{ route('blogs.page') }}">Yangiliklar</a></li> 
            <li class="breadcrumb-item active text-primary">{{ $category->name }}</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Blog Start -->
<div class="container">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Yangiliklar</h4>
            </div>
            <h1 class="news-section-description">Shifoxonamizdagi Yangi Loyihalar va Yangilanishlar</h1>
            <p class="news-card-excerpt">
                Shifoxonamizda sodir bo'layotgan so'nggi yangiliklardan xabardor bo'ling.
                Yangi jihozlar, mutaxassislar, xizmatlar va sog'liqni saqlash bo'yicha foydali maslahatlar.
            </p>
        </div>
        
        <!-- News Wrapper -->
        <div class="news-wrapper">
            <!-- News Main -->
            <div class="news-main">
                <div class="news-grid">  

                    @foreach($posts as $post)
                    <div class="blog-item rounded wow fadeInUp">
                        <div class="blog-img">
                            <img src="{{ asset('storage/'.$post->photo) }}" alt="{{ $post->title }}">
                            <span class="news-category">{{ $post->category->name }}</span>
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
                <div class="pagination">
                    <div class="pagination-info">
                        {{ $posts->firstItem() }} - {{ $posts->lastItem() }} / {{ $posts->total() }} @lang('words.records')
                    </div>
                    <div class="pagination-controls">
                        @if($posts->onFirstPage())
                            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        @else
                            <a href="{{ $posts->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @foreach(range(1, $posts->lastPage()) as $page)
                            @if($page == $posts->currentPage())
                                <button class="page-btn active">{{ $page }}</button>
                            @elseif($page >= $posts->currentPage() - 2 && $page <= $posts->currentPage() + 2)
                                <a href="{{ $posts->url($page) }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                        @endif
                    </div>
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