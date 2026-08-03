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
            <li class="breadcrumb-item active">@lang('words.news')</li>
        </ol>
    </nav>

    <div class="search-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0">@lang('words.news')</h4>
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
                <input type="text" 
                       placeholder="@lang('words.search_news_placeholder')" 
                       id="newsSearch"
                       onkeyup="searchPosts(this.value)">
                <button class="clear-search-input" id="clearSearchBtn" onclick="clearSearch()" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <a href="{{ route('posts.create') }}" class="add-post-btn">
                <i class="fas fa-plus"></i> <span>@lang('words.add_post')</span>
            </a>
        </div>

        <!-- Search Results Header -->
        <div id="searchResults" style="display: none;">
            <div class="search-results-header">
                <h5>@lang('words.search_results') <span id="resultCount">0</span></h5>
                <button onclick="clearSearch()" class="clear-search-btn">
                    <i class="fas fa-times"></i> @lang('words.clear')
                </button>
            </div>
        </div>

        <div class="news-grid" id="newsGrid">
            <!-- Main News -->
            <div class="news-main">
                <div class="news-cards" id="newsCards">
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

<!-- ===== JAVASCRIPT ===== -->
<script>
    // Search posts
    function searchPosts(query) {
        const searchResults = document.getElementById('searchResults');
        const resultCount = document.getElementById('resultCount');
        const newsCards = document.getElementById('newsCards');
        const newsGrid = document.getElementById('newsGrid');
        const clearBtn = document.getElementById('clearSearchBtn');
        
        if (query.trim().length === 0) {
            searchResults.style.display = 'none';
            newsGrid.style.display = 'grid';
            clearBtn.style.display = 'none';
            // Asosiy postlarni qayta ko'rsatish
            location.reload();
            return;
        }

        // Tozalash tugmasini ko'rsatish
        clearBtn.style.display = 'flex';

        // AJAX so'rov yuborish
        fetch('/posts/search?q=' + encodeURIComponent(query), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            searchResults.style.display = 'block';
            newsGrid.style.display = 'grid';
            
            resultCount.textContent = data.length;
            
            if (data.length === 0) {
                newsCards.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">@lang('words.no_search_results')</p>
                    </div>
                `;
                return;
            }
            
            // Xuddi asosiy postlar kabi HTML yaratamiz
            let html = '';
            data.forEach(post => {
                html += `
                    <div class="news-card">
                        <div class="news-image">
                            <img src="${post.photo ? '/storage/' + post.photo : '/images/default-post.jpg'}" alt="${post.title}">
                            <span class="news-category">${post.category || '{{ __('words.no_category') }}'}</span>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="fa fa-calendar-alt"></i> ${new Date(post.created_at).toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' })}</span>
                                <span><i class="fa fa-comments"></i> ${post.comments_count || 0} {{ __('words.comments') }}</span>
                            </div>
                            <a href="/posts/${post.id}" class="news-title">${post.title}</a>
                            <p class="news-excerpt">${post.description ? post.description.substring(0, 150) + '...' : ''}</p>
                            <a href="/posts/${post.id}" class="news-read-more">{{ __('words.read_more') }}</a>
                        </div>
                    </div>
                `;
            });
            
            newsCards.innerHTML = html;
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }

    // Clear search
    function clearSearch() {
        const searchInput = document.getElementById('newsSearch');
        const searchResults = document.getElementById('searchResults');
        const newsGrid = document.getElementById('newsGrid');
        const clearBtn = document.getElementById('clearSearchBtn');
        
        searchInput.value = '';
        searchResults.style.display = 'none';
        newsGrid.style.display = 'grid';
        clearBtn.style.display = 'none';
        
        // Sahifani qayta yuklamasdan asosiy postlarni ko'rsatish
        location.reload();
    }

    // Input ichida tozalash tugmasini ko'rsatish/yashirish
    document.getElementById('newsSearch').addEventListener('input', function() {
        const clearBtn = document.getElementById('clearSearchBtn');
        if (this.value.length > 0) {
            clearBtn.style.display = 'flex';
        } else {
            clearBtn.style.display = 'none';
        }
    });

    // Enter tugmasi bosilganda search qilish
    document.getElementById('newsSearch').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            searchPosts(this.value);
        }
    });
</script>

<!-- ===== CSS QO'SHIMCHA ===== -->
<style> 

    .search-input .clear-search-input {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #a0aec0;
        cursor: pointer;
        font-size: 16px;
        padding: 5px;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border-radius: 50%;
        width: 28px;
        height: 28px;
    }

    .search-input .clear-search-input:hover {
        background: #e2e8f0;
        color: #e53e3e;
    }

    .search-results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .search-results-header h5 {
        font-size: 18px;
        font-weight: 600;
        color: #1a202c;
        margin: 0;
    }

    .search-results-header h5 span {
        color: #00BFFF;
        font-weight: 700;
    }

    .clear-search-btn {
        background: white;
        border: 2px solid #cbd5e0;
        padding: 11px 23px;
        border-radius: 8px;
        color: #4a5568;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .clear-search-btn:hover {
        background: #4a5568;
  color: #f7fafc;
  border-color: #a0aec0;
    }

    .add-post-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #00BFFF;
        color: white;
        padding: 12px 25px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .add-post-btn:hover {
        background: #0099cc;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 191, 255, 0.3);
    } 
</style>

</x-layouts.main.website>