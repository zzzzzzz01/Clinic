<div class="pagination">
            <div class="pagination-info">
                {{ $pagination['first_item'] }} - {{ $pagination['last_item'] }} / {{ $pagination['total'] }} @lang('words.records')
            </div>

            <div class="pagination-controls">
                {{-- Previous --}}
                <button class="page-btn"
                    {{ $pagination['on_first_page'] ? 'disabled' : '' }}
                    onclick="window.location='{{ $pagination['previous_page_url'] }}'">
                    <i class="fas fa-chevron-left"></i>
                </button>

                @php
                    $current = $pagination['current_page'];
                    $last = $pagination['last_page'];
                @endphp

                {{-- First page --}}
                @if($current > 2)
                    <button class="page-btn"
                        onclick="window.location='{{ $pagination['url'](1) }}'">
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
                        onclick="window.location='{{ $pagination['url']($i) }}'">
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
                        onclick="window.location='{{ $pagination['url']($last) }}'">
                        {{ $last }}
                    </button>
                @endif

                {{-- Next --}}
                <button class="page-btn"
                    {{ $pagination['has_more_pages'] ? '' : 'disabled' }}
                    onclick="window.location='{{ $pagination['next_page_url'] }}'">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>