<dialog class="notification-modal" id="detailModal">
    <div class="modal-header">
        <h3>@lang('words.detail')</h3>
        <button class="close-btn" onclick="closeDetailModal()">✕</button>
    </div>
    <div class="modal-body">
        <div id="detailContent">
            @foreach($histories as $index => $history)
                <div id="detail-{{ $loop->index }}" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="notification-label">@lang('words.medicine')</label>
                            <div class="form-control">{{ $medicine->name }}</div>
                        </div>
                        <div class="form-group">
                            <label class="notification-label">@lang('words.supplier')</label>
                            <div class="form-control">{{ $medicine->supplier->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="notification-label">@lang('words.receive_date')</label>
                            <div class="form-control">{{ $history->receive_date ? date('d.m.Y H:i', strtotime($history->receive_date)) : '-' }}</div>
                        </div>
                        <div class="form-group">
                            <label class="notification-label">@lang('words.stock_boxes')</label>
                            <div class="form-control">{{ number_format($history->quantity_boxes) }}</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="notification-label">@lang('words.pieces_per_box')</label>
                            <div class="form-control">{{ number_format($history->pieces_per_box) }}</div>
                        </div>
                        <div class="form-group">
                            <label class="notification-label">@lang('words.total_pieces')</label>
                            <div class="form-control">{{ number_format($history->total_pieces) }}</div>
                        </div>
                    </div>  
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="notification-label">@lang('words.status')</label>
                            <div class="form-control">
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="notification-label">@lang('words.user')</label>
                            <div class="form-control">{{ $history->user->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="notification-label">@lang('words.notes')</label>
                        <div class="form-control">{{ $history->notes ?? '-' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeDetailModal()">@lang('words.cancel')</button> 
    </div>
</dialog>