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

/* 
    Funzione helper per configurare una drop area
    La funzione riceve due parametri: 
        -drop area: l'elemento HTML che fungerà da area per il drop & drop
        -fileInput: l'elemento input di tipo file associato alla drop area
*/
function setupDropArea(dropArea, fileInput) {
    // Clic per aprire il file input
    dropArea.addEventListener('click', function() {
        if (fileInput) {
            fileInput.click();
        }
    });
    
    /* 
        Aggiunge un event listener per l'evento "dragover" (quando un elemento viene trascinato sopra la drop area).
        Previene il comportamento di default del browser (che potrebbe impedire il drop) e interrompe la propagazione dell'evento.
        Aggiunge anche la classe "highlight" per dare un feedback visivo all'utente.
    */    
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropArea.classList.add('highlight');
    });
    
    /* 
        Aggiunge un event listener per l'evento "dragleave" (quando l'elemento trascinato esce dalla drop area).
        Previene il comportamento di default e rimuove la classe "highlight" per eliminare il feedback visivo.
    */
    dropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropArea.classList.remove('highlight');
    });
    
    // Drop: rimuove l'evidenza, assegna il file all'input e mostra il nome del file
    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        //rimuove la classe "highlight" poichè l'operazione di drop è conclusa
        dropArea.classList.remove('highlight');
        
        //ottiene l'oggetto DataTransfer dall'evento e i file trascinati
        var dt = e.dataTransfer;
        var files = dt.files;
        //se c'è almeno un file e l'input è definito
        if (files.length > 0 && fileInput) {
            // Abilita il file input se era disabilitato
            fileInput.disabled = false;
            //assegna i file trascinati all'input file
            fileInput.files = files;
            //aggiorna l'HTML dell'area drop per mostrare il nome del file caricato
            dropArea.innerHTML = "<p>File caricato: " + files[0].name + "</p>";
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    
    /****Configurazione dell'area drop globale (sezione "Aggiungi Prodotto")****/
    //Seleziona l'elemento che fungerà da drop area globale e 'input file associato.
    var globalDropArea = document.getElementById('drop-area');
    var globalFileInput = document.getElementById('filename');

    //se entrambi gli elementi esistono, applica la funzione di configurazione
    if (globalDropArea && globalFileInput) {
        setupDropArea(globalDropArea, globalFileInput);
    }
    
    /****Configurazione delle aree drop per ciascuna riga della tabella****/
    // Seleziona tutte le drop-area con l'attributo data-input
    var tableDropAreas = document.querySelectorAll('.drop-area[data-input]');
    // Per ciascuna drop-area, ottieni l'elemento input associato dall'id del file input e applica la funzione di configurazione
    tableDropAreas.forEach(function(dropArea) {
        var fileInputId = dropArea.getAttribute('data-input');
        var fileInput = document.getElementById(fileInputId);
        setupDropArea(dropArea, fileInput);
    });
});