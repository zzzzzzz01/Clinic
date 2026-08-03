<div class="pagination">
    <div class="pagination-info">
        @if(method_exists($rooms, 'firstItem'))
            {{ $rooms->firstItem() }} - {{ $rooms->lastItem() }} / {{ $rooms->total() }} @lang('words.records')
        @else
            @lang('words.total') {{ $rooms->count() }} @lang('words.records')
        @endif
    </div>

    <div class="pagination-controls">

        {{-- Previous --}}
        <button class="page-btn"
            {{ $rooms->onFirstPage() ? 'disabled' : '' }}
            onclick="window.location='{{ $rooms->previousPageUrl() }}'">
            <i class="fas fa-chevron-left"></i>
        </button>

        @php
            $current = $rooms->currentPage();
            $last = $rooms->lastPage();
        @endphp

        {{-- First page --}}
        @if($current > 2)
            <button class="page-btn"
                onclick="window.location='{{ $rooms->url(1) }}'">
                1
            </button>
        @endif

        {{-- Left dots --}}
        @if($current > 3)
            <span class="page-dots">...</span>
        @endif

        {{-- Pages around current --}}
        @for($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
            <button class="page-btn {{ $i == $current ? 'active' : '' }}"
                onclick="window.location='{{ $rooms->url($i) }}'">
                {{ $i }}
            </button>
        @endfor

        {{-- Right dots --}}
        @if($current < $last - 2)
            <span class="page-dots">...</span>
        @endif

        {{-- Last page --}}
        @if($current < $last - 1)
            <button class="page-btn"
                onclick="window.location='{{ $rooms->url($last) }}'">
                {{ $last }}
            </button>
        @endif

        {{-- Next --}}
        <button class="page-btn"
            {{ $rooms->hasMorePages() ? '' : 'disabled' }}
            onclick="window.location='{{ $rooms->nextPageUrl() }}'">
            <i class="fas fa-chevron-right"></i>
        </button>

    </div>
</div>