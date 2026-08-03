<div class="pagination">
    <div class="pagination-info">
        {{ $doctors->firstItem() }} - {{ $doctors->lastItem() }} / {{ $doctors->total() }} @lang('words.records')
    </div>

    <div class="pagination-controls">

        {{-- Previous --}}
        @if($doctors->onFirstPage())
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $doctors->previousPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @php
            $current = $doctors->currentPage();
            $last = $doctors->lastPage();
        @endphp

        {{-- First page --}}
        @if($current > 2)
            <a href="{{ $doctors->url(1) }}" class="page-btn">1</a>
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
                <a href="{{ $doctors->url($i) }}" class="page-btn">{{ $i }}</a>
            @endif
        @endfor

        {{-- Right dots --}}
        @if($current < $last - 2)
            <span class="page-dots">...</span>
        @endif

        {{-- Last page --}}
        @if($current < $last - 1)
            <a href="{{ $doctors->url($last) }}" class="page-btn">{{ $last }}</a>
        @endif

        {{-- Next --}}
        @if($doctors->hasMorePages())
            <a href="{{ $doctors->nextPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif

    </div>
</div>