<x-layouts.main.website>
    <x-slot:title>
        @lang('words.history') - {{ $medicine->name }}
    </x-slot:title>

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('medicine.inventory') }}" class="text-decoration-none">
                        @lang('words.pharmacy_inventory')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.history')
                    </a>
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-md-0">
                            @lang('words.history') — {{ $medicine->name }}
                        </h4>
                        <small class="text-muted">
                            @lang('words.current_stock'): <strong>{{ number_format($medicine->stock_boxes) }}</strong> 
                            @lang('words.stock_boxes')
                        </small>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-4">
        <div class="inventory-history-table-container">
            <div class="table-wrapper">
                <table id="historyTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('words.receive_date')</th>
                            <th>@lang('words.stock_boxes')</th>
                            <th>@lang('words.pieces_per_box')</th>
                            <th>@lang('words.total_pieces')</th>
                            <th>@lang('words.status')</th>
                            <th>@lang('words.notes')</th>
                            <th>@lang('words.user')</th>
                            <th>@lang('words.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $index => $history)
                            <tr>
                                <td>{{ $histories->firstItem() + $index }}</td>
                                <td class="table-text">{{ $history->receive_date ? date('d.m.Y', strtotime($history->receive_date)) : '-' }}</td>
                                <td class="table-text">{{ number_format($history->quantity_boxes) }}</td>
                                <td class="table-text">{{ number_format($history->pieces_per_box) }}</td>
                                <td class="table-text">{{ number_format($history->total_pieces) }}</td>
                                <td>
                                    @if($history->status == 'completed')
                                        <span class="status-badge" style="background: #e8f5e9; color: #388e3c;">
                                            <i class="fas fa-check-circle"></i> @lang('words.completed')
                                        </span>
                                    @elseif($history->status == 'pending')
                                        <span class="status-badge" style="background: #fff3e0; color: #f57c00;">
                                            <i class="fas fa-clock"></i> @lang('words.pending')
                                        </span>
                                    @elseif($history->status == 'cancelled')
                                        <span class="status-badge" style="background: #ffebee; color: #d32f2f;">
                                            <i class="fas fa-times-circle"></i> @lang('words.cancelled')
                                        </span>
                                    @else
                                        <span class="status-badge" style="background: #e3f2fd; color: #1976d2;">
                                            {{ $history->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="table-text">{{ $history->notes ?? '-' }}</td>
                                <td class="table-text">{{ $history->user->name ?? '-' }}</td>
                                <td>
                                    <div class="action-dropdown" data-dropdown-id="dropdown-{{ $history->id }}">
                                        <span class="action-dots">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </span>
                                        <div class="dropdown-content" id="dropdown-{{ $history->id }}">
                                            <a href="javascript:void(0)" class="text-primary" onclick="openDetailModal({{ $loop->index }})">
                                                <i class="fas fa-eye"></i> @lang('words.detail')
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="9" class="empty-cell text-center">
                                    @lang('words.no_history')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @include('partials.paginations.medicine-receive-history')
        </div>
    </div>

    <!-- Detail Modal -->
    @include('partials.modals.show-modals.medicine-receive-history')

    <script>
        // Dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                const dots = dropdown.querySelector('.action-dots');
                const content = dropdown.querySelector('.dropdown-content');
                
                if (dots && content) {
                    dots.addEventListener('click', function(e) {
                        e.stopPropagation();
                        document.querySelectorAll('.dropdown-content').forEach(menu => {
                            if (menu !== content) {
                                menu.classList.remove('show');
                            }
                        });
                        content.classList.toggle('show');
                    });
                    
                    content.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            });
            
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-content').forEach(menu => {
                    menu.classList.remove('show');
                });
            });
        });
        
        function openDetailModal(index) {
            document.querySelectorAll('#detailContent > div').forEach(function(div) {
                div.style.display = 'none';
            });
            
            const target = document.getElementById('detail-' + index);
            if (target) {
                target.style.display = 'block';
            }
            
            // Scrollni to'xtatish
            document.body.style.overflow = 'hidden';
            
            document.getElementById('detailModal').showModal();
        }
        
        function closeDetailModal() {
            document.getElementById('detailModal').close();
            // Scrollni qayta yoqish
            document.body.style.overflow = '';
        } 
    </script>
</x-layouts.main.website>