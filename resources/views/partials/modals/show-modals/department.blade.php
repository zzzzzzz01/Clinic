<dialog id="staffModal" class="notification-modal">
    <div class="modal-header">
        <h3><span id="modalDepartmentName"></span> - @lang('words.staff_list')</h3>
        <button class="close-btn" onclick="closeStaffModal()">✕</button>
    </div>
    <div class="modal-body">
        <div class="staff-table">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('words.full_name')</th>
                        <th>@lang('words.position')</th>
                        <th>@lang('words.status')</th>
                    </tr>
                </thead>
                <tbody id="staffTableBody">
                    <tr><td colspan="4" class="text-center">@lang('words.loading')</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-secondary" onclick="closeStaffModal()">@lang('words.cancel')</button>
    </div>
</dialog>