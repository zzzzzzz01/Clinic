<div class="pagination" id="paginationContainer">
    <div class="pagination-info">
        {{ $pagination['current_page'] ?? 1 }} - {{ $pagination['last_page'] ?? 1 }} / {{ $pagination['total'] ?? 0 }} ta
    </div>
    <div class="pagination-controls"> 
        @if(($pagination['current_page'] ?? 1) > 1)
            <a href="?page={{ $pagination['current_page'] - 1 }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
        @else
            <span class="page-btn disabled"><i class="fas fa-chevron-left"></i></span>
        @endif

        @for($i = 1; $i <= ($pagination['last_page'] ?? 1); $i++)
            @if($i == ($pagination['current_page'] ?? 1))
                <button class="page-btn active">{{ $i }}</button>
            @else
                <a href="?page={{ $i }}" class="page-btn">{{ $i }}</a>
            @endif
        @endfor

        @if(($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1))
            <a href="?page={{ $pagination['current_page'] + 1 }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        @else
            <span class="page-btn disabled"><i class="fas fa-chevron-right"></i></span>
        @endif
    </div>
</div> 