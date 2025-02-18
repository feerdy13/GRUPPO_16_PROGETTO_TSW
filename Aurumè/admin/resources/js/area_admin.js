// Abilita la modifica degli input associati al form con id="update-form-<id>"
function enableEdit(id) {
    console.log("enableEdit chiamato per id:", id);
    // Abilita tutti gli input associati al form (che usano l'attributo form)
    var inputs = document.querySelectorAll('[form="update-form-' + id + '"]');
    inputs.forEach(function(input) {
        input.disabled = false;
    });
    // Mostra il bottone "Salva" e nascondi quello "Modifica"
    var saveButton = document.getElementById('save-' + id);
    var modifyButton = document.querySelector('#update-form-' + id + ' button[onclick^="enableEdit"]');
    if (saveButton) {
        saveButton.style.display = 'inline-block';
    }
    if (modifyButton) {
        modifyButton.style.display = 'none';
    }
}

// Invia il form di aggiornamento per il prodotto con id="update-form-<id>"
function saveEdit(id) {
    console.log("saveEdit chiamato per id:", id);
    var form = document.getElementById('update-form-' + id);
    if (form) {
        form.submit();
    } else {
        console.error("Form non trovato per id " + id);
    }
}

// Seleziona o deseleziona tutte le checkbox per l'eliminazione
function selectAll(source) {
    var checkboxes = document.querySelectorAll('.delete-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = source.checked;
    });
}

// Invia il form di eliminazione con gli ID dei prodotti selezionati
function submitDeleteForm() {
    console.log("submitDeleteForm chiamato");
    var selected = [];
    var checkboxes = document.querySelectorAll('.delete-checkbox:checked');
    checkboxes.forEach(function(checkbox) {
        selected.push(checkbox.value);
    });
    if (selected.length === 0) {
        alert("Nessun prodotto selezionato per l'eliminazione.");
        return;
    }
    document.getElementById('delete-product-ids').value = JSON.stringify(selected);
    document.getElementById('delete-form').submit();
}
