<div class="pagination">
    <div class="pagination-info">
        {{ $histories->firstItem() }} - {{ $histories->lastItem() }} / {{ $histories->total() }} @lang('words.records')
    </div>

    <div class="pagination-controls">

        {{-- Previous --}}
        @if($histories->onFirstPage())
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $histories->previousPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @php
            $current = $histories->currentPage();
            $last = $histories->lastPage();
        @endphp

        {{-- First page --}}
        @if($current > 2)
            <a href="{{ $histories->url(1) }}" class="page-btn">1</a>
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
                <a href="{{ $histories->url($i) }}" class="page-btn">{{ $i }}</a>
            @endif
        @endfor

        {{-- Right dots --}}
        @if($current < $last - 2)
            <span class="page-dots">...</span>
        @endif

        {{-- Last page --}}
        @if($current < $last - 1)
            <a href="{{ $histories->url($last) }}" class="page-btn">{{ $last }}</a>
        @endif

        {{-- Next --}}
        @if($histories->hasMorePages())
            <a href="{{ $histories->nextPageUrl() }}" class="page-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif

    </div>
</div>