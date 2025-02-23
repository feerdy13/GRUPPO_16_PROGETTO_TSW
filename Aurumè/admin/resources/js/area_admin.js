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


/* DRAG AND DROP */
/* 
    Funzione helper per configurare una drop area
    La funzione riceve due parametri: 
        -drop area: l'elemento HTML che fungerà da area per il drag & drop
        -fileInput: l'elemento input di tipo file associato alla drop area
*/
function setupDropArea(dropArea, fileInput) {
    // Clic per aprire il file input
    dropArea.addEventListener('click', function() {
        if (fileInput) {
            fileInput.click();
        }
    });

    //Stoppiamo la propagazione dell'evento click così da non far aprire due volte il file input
    fileInput.addEventListener('click', function(e) {
        e.stopPropagation();
});
    
    /* 
        Aggiunge un event listener per l'evento "dragover" (quando un elemento viene trascinato sopra la drop area).
        Previene il comportamento di default del browser (che potrebbe impedire il drop) e interrompe la propagazione dell'evento.
    */    
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    /* 
        Aggiunge un event listener per l'evento "dragleave" (quando l'elemento trascinato esce dalla drop area).
    */
    dropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    // Drop: rimuove l'evidenza, assegna il file all'input e mostra il nome del file
    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
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
    
    /* Area di drop: sezione "Aggiungi Prodotto */
    const dropAreaAggiungi = document.getElementById('drop-area');
    const inputFileAggiungi = document.getElementById('filename');

    //se entrambi gli elementi esistono, applica la funzione di configurazione
    if (dropAreaAggiungi && inputFileAggiungi) {
        setupDropArea(dropAreaAggiungi, inputFileAggiungi);
    }
    

    /* Area di drop: ciascuna riga della tabella di modifica prodotti */
    // Seleziona tutte le drop-area con l'attributo data-input
    const tableDropAreas = document.querySelectorAll('.drop-area[data-input]');
    // Per ciascuna drop-area, ottieni l'elemento input associato dall'id del file input e applica la funzione di configurazione
    tableDropAreas.forEach(function(dropArea) {
        const fileInputId = dropArea.getAttribute('data-input');
        const fileInput = document.getElementById(fileInputId);
        setupDropArea(dropArea, fileInput);
    });
});