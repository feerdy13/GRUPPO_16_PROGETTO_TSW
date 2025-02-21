// Abilita la modifica degli input associati al form con id="update-form-<id>"
function enableEdit(id) {
    console.log("enableEdit chiamato per id:", id);
    // Abilita tutti gli input associati al form (che usano l'attributo form)
    var inputs = document.querySelectorAll('[form="update-form-' + id + '"]');
    inputs.forEach(function(input) {
        //rimuove l'attributo "disabled" per permettere la modifica
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
    //ottiene il form tramite il suo id="update-form-<id>"
    var form = document.getElementById('update-form-' + id);
    if (form) {
        form.submit();
    } else {
        console.error("Form non trovato per id " + id);
    }
}

// Seleziona o deseleziona tutte le checkbox per l'eliminazione
function selectAll(source) {
    //seleziona tutte le checkbox con la classe "delete-checkbox"
    var checkboxes = document.querySelectorAll('.delete-checkbox');
    checkboxes.forEach(function(checkbox) {
        //imposta lo stato "checked" in base allo stato della checkbox "source"
        checkbox.checked = source.checked;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // --- Gestione area drop globale (sezione "Aggiungi Prodotto") ---
    var globalDropArea = document.getElementById('drop-area');
    var globalFileInput = document.getElementById('filename');
    if (globalDropArea && globalFileInput) {
        // Clic sull'area per aprire il file input
        globalDropArea.addEventListener('click', function() {
            globalFileInput.click();
        });
    
        // Dragover
        globalDropArea.addEventListener('dragover', function(e) {
            //previene il comportamento di default del browser che potrebbe impedire il drop
            e.preventDefault();
            //impedisce che l'evento si propaghi ad altri elementi
            e.stopPropagation();
            //aggiunge la classe "highlight" per evidenziare l'area
            globalDropArea.classList.add('highlight');
        });
    
        // Dragleave: rimuove la classe evidenziata
        globalDropArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            globalDropArea.classList.remove('highlight');
        });
    
        // Drop: rimuove la classe di evidenza, assegna il file all'input e mostra il nome del file caricato.
        globalDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            globalDropArea.classList.remove('highlight');
    
            var dt = e.dataTransfer;
            var files = dt.files;
            if (files.length > 0) {
                //imposta i file selezionati nell'input file
                globalFileInput.files = files;
                //aggiorna l'area di drop per mostrare il nome del file caricato
                globalDropArea.innerHTML = "<p>File caricato: " + files[0].name + "</p>";
            }
        });
    }
    
    // --- Gestione delle aree drop per ciascuna riga della tabella ---
    // Seleziona tutte le drop-area che hanno l'attributo data-input (usato per associare il file input)
    var tableDropAreas = document.querySelectorAll('.drop-area[data-input]');
    tableDropAreas.forEach(function(dropArea) {
        //ottiene l'id del file input associato dall'attributo "data-input"
        var fileInputId = dropArea.getAttribute('data-input');
        var fileInput = document.getElementById(fileInputId);
        
        // Al clic sull'area, apre il file input associato
        dropArea.addEventListener('click', function() {
            if (fileInput) {
                fileInput.click();
            }
        });
        
        // Dragover: evidenzia l'area e previene il comportamento predefinito
        dropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.add('highlight');
        });
        
        // Dragleave: rimuove l'evidenza visiva dall'area di drop
        dropArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('highlight');
        });
        
        // Drop: rimuove l'evidenza, assegna il file all'input e mostra il nome del file
        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('highlight');
            
            var dt = e.dataTransfer;
            var files = dt.files;
            if (files.length > 0 && fileInput) {
                // Se il file input era disabilitato (in modalità visualizzazione), lo abilitiamo
                fileInput.disabled = false;
                fileInput.files = files;
                dropArea.innerHTML = "<p>File caricato: " + files[0].name + "</p>";
            }
        });
    });
});
