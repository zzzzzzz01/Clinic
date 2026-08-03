<div class="pagination">
    <div class="pagination-info">
        {{ $departments->firstItem() }} - {{ $departments->lastItem() }} / {{ $departments->total() }} @lang('words.records')
    </div>
    <div class="pagination-controls">
        @if($departments->onFirstPage())
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
        @else
            <a href="{{ $departments->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
        @endif

        @foreach(range(1, $departments->lastPage()) as $page)
            @if($page == $departments->currentPage())
                <button class="page-btn active">{{ $page }}</button>
            @elseif($page >= $departments->currentPage() - 2 && $page <= $departments->currentPage() + 2)
                <a href="{{ $departments->url($page) }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        @if($departments->hasMorePages())
            <a href="{{ $departments->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        @else
            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
        @endif
    </div>
</div>