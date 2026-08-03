<div class="pagination">
    <div class="pagination-info">
        {{ $nurses->firstItem() }} - {{ $nurses->lastItem() }} / {{ $nurses->total() }} @lang('words.records')
    </div>

    <div class="pagination-controls">

        {{-- Previous --}}
        @if($nurses->onFirstPage())
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $nurses->previousPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @php
            $current = $nurses->currentPage();
            $last = $nurses->lastPage();
        @endphp

        {{-- First page --}}
        @if($current > 2)
            <a href="{{ $nurses->url(1) }}" class="page-btn">1</a>
        @endif

        {{-- Left dots --}}
        @if($current > 3)
            <span class="page-dots">...</span>
        @endif

        {{-- Current pages --}}
        @for($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
            @if($i == $current)
                <button class="page-btn active">{{ $i }}</button>
            @else
                <a href="{{ $nurses->url($i) }}" class="page-btn">{{ $i }}</a>
            @endif
        @endfor

        {{-- Right dots --}}
        @if($current < $last - 2)
            <span class="page-dots">...</span>
        @endif

        {{-- Last page --}}
        @if($current < $last - 1)
            <a href="{{ $nurses->url($last) }}" class="page-btn">{{ $last }}</a>
        @endif

        {{-- Next --}}
        @if($nurses->hasMorePages())
            <a href="{{ $nurses->nextPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif

    </div>
</div>