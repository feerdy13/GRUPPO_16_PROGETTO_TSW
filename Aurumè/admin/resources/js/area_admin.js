function enableEdit(rowId) {
    var row = document.getElementById(rowId);
    if (row) {
        var inputs = row.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
        }
        var saveBtn = document.getElementById('save-' + rowId);
        if (saveBtn) {
            saveBtn.style.display = 'inline';
        }
    }
}

function saveEdit(rowId) {
    var form = document.getElementById('form-' + rowId);
    if (form) {
        form.submit();
    }
}

function selectAll(source) {
    var checkboxes = document.getElementsByName('product_ids[]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}
