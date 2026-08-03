<div class="pagination">
    <div class="pagination-info">
        {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} / {{ $paginator->total() }} @lang('words.records')
    </div>

    <div class="pagination-controls">

        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
        @endphp

        {{-- First page --}}
        @if($current > 2)
            <a href="{{ $paginator->url(1) }}" class="page-btn">1</a>
        @endif

        {{-- Left dots --}}
        @if($current > 3)
            <span class="page-dots">...</span>
        @endif

        {{-- Current page va yonidagi sahifalar --}}
        @for($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
            @if($i == $current)
                <button class="page-btn active">{{ $i }}</button>
            @else
                <a href="{{ $paginator->url($i) }}" class="page-btn">{{ $i }}</a>
            @endif
        @endfor

        {{-- Right dots --}}
        @if($current < $last - 2)
            <span class="page-dots">...</span>
        @endif

        {{-- Last page --}}
        @if($current < $last - 1)
            <a href="{{ $paginator->url($last) }}" class="page-btn">{{ $last }}</a>
        @endif

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif

    </div>
</div>