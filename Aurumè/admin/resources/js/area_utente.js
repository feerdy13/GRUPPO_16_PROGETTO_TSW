function enableEdit(rowId) {
    var row = document.getElementById(rowId);
    var inputs = row.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = false;
    }
    document.getElementById('save-' + rowId).style.display = 'inline';
}
function saveEdit(rowId) {
    document.getElementById('form-' + rowId).submit();
}
function selectAll(source) {
    var checkboxes = document.getElementsByName('product_ids[]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}