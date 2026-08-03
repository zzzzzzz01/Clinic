<div class="pagination">
    <div class="pagination-info">
        {{ $medicines->firstItem() }} - {{ $medicines->lastItem() }} / {{ $medicines->total() }} @lang('words.records')
    </div>
    <div class="pagination-controls">
        @if($medicines->onFirstPage())
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
        @else
            <a href="{{ $medicines->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
        @endif

        @foreach(range(1, $medicines->lastPage()) as $page)
            @if($page == $medicines->currentPage())
                <button class="page-btn active">{{ $page }}</button>
            @elseif($page >= $medicines->currentPage() - 2 && $page <= $medicines->currentPage() + 2)
                <a href="{{ $medicines->url($page) }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        @if($medicines->hasMorePages())
            <a href="{{ $medicines->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        @else
            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
        @endif
    </div>
</div>