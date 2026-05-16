<div id="bulk-actions-bar" class="alert alert-info py-2 mb-2" style="display:none;">
    <div class="d-flex justify-content-between align-items-center">
        <span><strong id="selected-count">0</strong> items selected</span>
        <div>
            @if(request()->routeIs('*.trash'))
                <button type="button" onclick="bulkAction('bulk-restore')" class="btn btn-success btn-sm mr-1">
                    <i class="fas fa-undo"></i> Restore Selected
                </button>
                <button type="button" onclick="bulkAction('bulk-force-delete')" class="btn btn-danger btn-sm mr-1">
                    <i class="fas fa-times"></i> Delete Permanently
                </button>
            @else
                <button type="button" onclick="bulkAction('bulk-destroy')" class="btn btn-warning btn-sm mr-1">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            @endif
            <button type="button" onclick="clearSelection()" class="btn btn-secondary btn-sm">
                Clear
            </button>
        </div>
    </div>
</div>

<script>
function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    checkboxes.forEach(cb => cb.checked = source.checked);
    updateBulkBar();
}

function updateBulkBar() {
    const checked = document.querySelectorAll('.bulk-checkbox:checked');
    const bar = document.getElementById('bulk-actions-bar');
    const count = document.getElementById('selected-count');
    if (checked.length > 0) {
        bar.style.display = 'block';
        count.textContent = checked.length;
    } else {
        bar.style.display = 'none';
    }
}

function clearSelection() {
    document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = false);
    const selectAll = document.getElementById('select-all');
    if (selectAll) selectAll.checked = false;
    updateBulkBar();
}

function getSelectedIds() {
    const checked = document.querySelectorAll('.bulk-checkbox:checked');
    return Array.from(checked).map(cb => cb.value);
}

function bulkAction(action) {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Please select items first');
        return;
    }

    let confirmMsg = '';
    if (action === 'bulk-restore') {
        confirmMsg = `Restore ${ids.length} selected items?`;
    } else if (action === 'bulk-force-delete') {
        confirmMsg = `Permanently delete ${ids.length} selected items? This cannot be undone!`;
    } else if (action === 'bulk-destroy') {
        confirmMsg = `Move ${ids.length} selected items to trash?`;
    }

    if (!confirm(confirmMsg)) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url()->current() }}/${action}`;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'POST';
    form.appendChild(method);

    ids.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = id;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}
</script>
