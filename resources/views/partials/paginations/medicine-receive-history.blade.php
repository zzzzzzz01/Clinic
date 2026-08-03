<div class="pagination">
    <div class="pagination-info">
        {{ $histories->firstItem() }} - {{ $histories->lastItem() }} / {{ $histories->total() }} @lang('words.records')
    </div>
    <div class="pagination-controls">
        @if($histories->onFirstPage())
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
        @else
            <a href="{{ $histories->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
        @endif

        @foreach(range(1, $histories->lastPage()) as $page)
            @if($page == $histories->currentPage())
                <button class="page-btn active">{{ $page }}</button>
            @elseif($page >= $histories->currentPage() - 2 && $page <= $histories->currentPage() + 2)
                <a href="{{ $histories->url($page) }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        @if($histories->hasMorePages())
            <a href="{{ $histories->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        @else
            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
        @endif
    </div>
</div>