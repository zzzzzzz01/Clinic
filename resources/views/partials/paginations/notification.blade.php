<div class="pagination">
    <div class="pagination-info">
        {{ $notifications->firstItem() }} - {{ $notifications->lastItem() }} / {{ $notifications->total() }} @lang('words.records')
    </div>
    <div class="pagination-controls">
        @if($notifications->onFirstPage())
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
        @else
            <a href="{{ $notifications->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
        @endif

        @foreach(range(1, $notifications->lastPage()) as $page)
            @if($page == $notifications->currentPage())
                <button class="page-btn active">{{ $page }}</button>
            @elseif($page >= $notifications->currentPage() - 2 && $page <= $notifications->currentPage() + 2)
                <a href="{{ $notifications->url($page) }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        @if($notifications->hasMorePages())
            <a href="{{ $notifications->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        @else
            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
        @endif
    </div>
</div>