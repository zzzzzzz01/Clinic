<!-- Add Medicine Dialog -->
<dialog id="medicineDialog" class="notification-modal">
    <form method="POST" action="{{ route('medicine.receive.pending') }}" id="addMedicineForm">
        @csrf
        <div class="modal-header">
            <h3>@lang('words.add_medicine_dialog_title')</h3>
            <button type="button" class="close-btn" onclick="closeDialog('medicineDialog')" aria-label="Close">✕</button> 
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                    <label for="modalMedicineSelect" class="notification-label">@lang('words.medicine')</label>
                    <select id="modalMedicineSelect" name="medicine_id" class="form-control" required>
                        <option value="">@lang('words.select_medicine')</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}" data-name="{{ $medicine->name }}">
                                {{ $medicine->name }}
                                @if($medicine->strength_value) ({{ $medicine->strength_value }} {{ $medicine->strength_unit }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="modalQuantityBoxes" class="notification-label">@lang('words.stock_boxes')</label>
                    <input type="number" id="modalQuantityBoxes" name="quantity_boxes" class="form-control" min="1" value="1" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="modalPiecesPerBox" class="notification-label">@lang('words.pieces_per_box')</label>
                    <input type="number" id="modalPiecesPerBox" name="pieces_per_box" class="form-control" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label for="modalReceiveDate" class="notification-label">@lang('words.receive_date')</label>
                    <input type="date" id="modalReceiveDate" name="receive_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="notification-label">@lang('words.total_pieces')</label>
                <div class="form-control" style="background-color: #f8f9fa; font-weight: bold;" id="modalTotalPieces">1</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDialog('medicineDialog')">@lang('words.cancel')</button>
            <button type="submit" class="btn-primary">
                @lang('words.save')
            </button>
        </div>
    </form>
</dialog>