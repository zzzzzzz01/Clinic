<div class="pagination">
    <div class="pagination-info">
        {{ $testPanels->firstItem() }} - {{ $testPanels->lastItem() }} / {{ $testPanels->total() }} @lang('words.test_panels_count')
    </div>
    <div class="pagination-controls">
        @if($testPanels->onFirstPage())
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
        @else
            <a href="{{ $testPanels->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
        @endif

        @foreach(range(1, $testPanels->lastPage()) as $page)
            @if($page == $testPanels->currentPage())
                <button class="page-btn active">{{ $page }}</button>
            @else
                <a href="{{ $testPanels->url($page) }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        @if($testPanels->hasMorePages())
            <a href="{{ $testPanels->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        @else
            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
        @endif
    </div>
</div>