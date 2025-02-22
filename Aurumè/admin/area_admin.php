<?php
session_start();
include '../includes/database.php'; // Assicurati che questo file imposti correttamente la connessione in $conn

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);


// Gestione del logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: area_admin.php');
    exit();
}

// Gestione del login dopo aver effettuato il submit delle credenziali nel form di login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Ricavo le credenziali inserite nel form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Recupero le credenziali salvate sul database
    $query = 'SELECT id, username, password 
                FROM admin 
                WHERE username = $1';
    $stmt = pg_prepare($conn, 'admin_login', $query);
    $result = pg_execute($conn, 'admin_login', array($username));

    // Verifica delle credenziali
    if ($row = pg_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
        } else {
            $_SESSION['error'] = 'Username o password errati, riprova.';
        }
    } else {
        $_SESSION['error'] = 'Username o password errati, riprova.';
    }
}


/**
 * Gestione immagini prodotti (upload e spostamento del file)
 */
function handleFileUpload($targetDir) {
    $files = $_FILES['filename'];
    // Verifico se il file è stato caricato correttamente senza errori
    if (isset($files) && $files['error'] === UPLOAD_ERR_OK) {
        // Ricavo il nome del file caricato
        $filename = basename($files['name']);
        
        // Verifico che il file sia in formato PNG o JPG
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
            return ['error' => 'Errore: il file deve essere in formato PNG o JPG.'];
        }
        
        // Costruisce il percorso completo del file di destinazione
        $target_file = rtrim(__DIR__ . "/" . $targetDir, '/') . '/' . $filename;

        // Sposta il file caricato nella directory di destinazione
        if (!move_uploaded_file($files['tmp_name'], $target_file)) {
            error_log('Errore nel caricamento del file: ' . print_r($files, true));
            return ['error' => 'Errore nel caricamento del file. Verifica il percorso e i permessi.'];
        }
        
        // Restituisce il nome del file caricato con successo
        return ['filename' => $filename];
    }
    
    // Restituisce un messaggio di errore se nessun file è stato caricato o se c'è stato un errore nell'upload
    return ['error' => "Nessun file caricato o errore nell'upload."];
}

// Gestione delle operazioni (solo se loggato)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operation'])) {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: area_admin.php');
        exit();
    }

    switch ($_POST['operation']) {

        /* Operazione: Cambio Credenziali */
        case 'change_admin_credentials':
            // Recupero le credenziali inserite nel form
            $new_admin_username = trim($_POST['new_admin_username']);
            $old_admin_password = trim($_POST['old_admin_password']);
            $new_admin_password = trim($_POST['new_admin_password']);
            
            // Recupero la password salvata nel database
            $query_select = "SELECT password 
                        FROM admin 
                        WHERE id = $1";
            pg_prepare($conn, "recupera_password_admin", $query_select);
            $result_select = pg_execute($conn, "recupera_password_admin", array($_SESSION["admin_id"]));
            
            // Confronto le password
            if ($row = pg_fetch_assoc($result_select)) {
                $current_admin_password = $row['password'];
                
                if (!password_verify($old_admin_password, $current_admin_password)) {
                    // Password vecchia non corretta
                    $message = "La vecchia password non è corretta.";
                } else {
                    // Cambio credenziali
                    $new_hashed_password = password_hash($new_admin_password, PASSWORD_DEFAULT);
                    $query_update = "UPDATE admin 
                                SET username = $1, password = $2 
                                WHERE id = $3";
                    pg_prepare($conn, "update_admin_both", $query_update);
                    $result_update = pg_execute($conn, "update_admin_both", array($new_admin_username, $new_hashed_password, $_SESSION["admin_id"]));
                    if ($result_update) {
                        // Cambio credenziali andato a buon fine
                        // Mostro un alert tramite javascript e ricarico la pagina
                        session_unset();
                        session_destroy();
                        echo "<script>
                                alert('Cambio credenziali effettuato con successo!');
                                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                            </script>";
                        exit();
                    } else {
                        // Errore durante il cambio username
                        $message = "Errore durante l'aggiornamento delle credenziali.";
                    } 
                }
            } else {
                $message = "Errore: amministratore non trovato.";
            }
            break;

        /* Operazione: Aggiornamento Prodotto */
        case 'update_product':
            // Recupero i dati del prodotto dal form
            $product_id = $_POST['product_id'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            // Directory di destinazione per il caricamento del file
            $target_dir = '../resources/img/catalogue/';

            // Verifico se è stato caricato un nuovo file
            if (isset($_FILES['filename']) && $_FILES['filename']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadResult = handleFileUpload($target_dir);

                // Controlla se ci sono errori nel caricamento del file
                if (isset($uploadResult['error'])) {
                    $message = $uploadResult['error'];
                    break;
                }

                // Ottiene il nome del file caricato
                $filename = $uploadResult['filename'];

                // Prepara la query per aggiornare il prodotto con il nuovo file
                $query = 'UPDATE prodotti 
                            SET filename = $1, prezzo = $2, descrizione = $3, categoria = $4 
                            WHERE id = $5';
                $params = array($filename, $price, $description, $category, $product_id);
            } else {
                // Prepara la query per aggiornare il prodotto senza modificare il file
                $query = 'UPDATE prodotti 
                            SET prezzo = $1, descrizione = $2, categoria = $3 
                            WHERE id = $4';
                $params = array($price, $description, $category, $product_id);
            }

            $result = pg_query_params($conn, $query, $params);
            $message = $result ? "Prodotto aggiornato con successo." : "Errore durante l'aggiornamento del prodotto: " . pg_last_error($conn);
            break;

        /* Operazione: Eliminazione Prodotti */
        case 'delete_products':
            if (!empty($_POST['ids'])) {
                // Recupero gli ID dei prodotti inviati tramite il form
                $product_ids = $_POST['ids'];

                // Itero su ciascun ID di prodotto
                foreach ($product_ids as $id) {
                    // Cancello il prodotto associato all'id
                    $query = "DELETE FROM prodotti 
                                WHERE id = $1";
                    $result = pg_query_params($conn, $query, array($id));
                }
                
                $message = "Prodotti eliminati con successo.";
            } else {
                $message = "Nessun prodotto selezionato per l'eliminazione.";
            }
            break;

        /* Operazione: Aggiunta Prodotto */
        case 'add_product':
            // Recupero i dati del prodotto dal form
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            // Directory di destinazione per il caricamento deli'immagine
            $target_dir = "../resources/img/catalogue/";

            $uploadResult = handleFileUpload($target_dir);

            // Controllo se ci sono errori nel caricamento dell'immagine
            if (isset($uploadResult['error'])) {
                $message = $uploadResult['error'];
                break;
            }

            // Recupero il nome del file caricato
            $filename = $uploadResult['filename'];
            if ($filename === null) {
                $message = "Nessun file selezionato.";
                break;
            }

            // Verifico se tutti i campi richiesti sono stati compilati
            if (empty($_POST['price']) || empty($_POST['description']) || empty($_POST['category'])) {
                $message = "Tutti i campi devono essere compilati.";
                break;
            }

            // Inserisco il nuovo prodotto nel database
            $query = "INSERT INTO prodotti (filename, prezzo, descrizione, categoria) 
                        VALUES ($1, $2, $3, $4)";
            $result = pg_query_params($conn, $query, array($filename, $price, $description, $category));
            $message = $result ? "Prodotto aggiunto con successo." : "Errore durante l'aggiunta del prodotto: " . pg_last_error($conn);
            break;
            
        default:
            $message = "Operazione non valida.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Aurumè | Area Amministratore</title>
    <link rel="stylesheet" href="resources/css/area_admin.css">
</head>
<body>
    <!-- Se non sono loggato come admin -->
    <?php if (!isset($_SESSION['admin_id'])): ?>
        <!-- Form di Login -->
        <h2>Login Amministratore</h2>
        <form method="POST" action="area_admin.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <?php 
        if (isset($_SESSION['error'])) {
            echo "<p>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
    ?>

    <!-- Se sono loggato come admin -->
    <?php else: ?>
        <h2>Area Amministratore</h2>
        <!-- Bottone Logout -->
        <p><a href="area_admin.php?logout=1" class="logout-button">Logout</a></p>
        <?php 
            if (isset($message)) {
                echo "<p>$message</p>";
                $message = '';
            } 
        ?>
        

        <!-- Sezione: Gestione Prodotti -->
        <div class="admin-section">
            <h3>VISUALIZZA E MODIFICA PRODOTTI</h3>

            <!-- Form separato per l'eliminazione multipla -->
            <form id="delete-form" method="POST" action="area_admin.php">
                <input type="hidden" name="operation" value="delete_products">
                <input type="hidden" name="product_ids" id="delete-product-ids">
                <button type="submit">Elimina Selezionati</button>
            </form>

            <!-- Tabella dei prodotti -->
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="selectAll(this)"></th>
                        <th>ID Prodotto</th>
                        <th>Filename</th>
                        <th>Prezzo</th>
                        <th>Descrizione</th>
                        <th>Categoria</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query = "SELECT id, filename, prezzo, descrizione, categoria FROM prodotti";
                    $result = pg_query($conn, $query);

                    if ($result) {
                        if (pg_num_rows($result) > 0) {
                            while ($row = pg_fetch_assoc($result)) {
                                $rowId = $row['id'];
                                echo "<tr id='row-{$rowId}'>";
                                echo    "<td data-label='Seleziona'><input type='checkbox' class='delete-checkbox' form='delete-form' name='ids[]' value='{$rowId}'></td>";
                                echo    "<td data-label='ID Prodotto'>{$rowId}</td>";
                                
                                // Modifica della cella Filename: include area drag & drop e pulsante "Scegli File"
                                echo    "<td data-label='Filename'>";
                                echo        "<div class='file-input-container'>";
                                // Area Drag & Drop con id univoco e attributo data-input che punta al file input
                                echo            "<div id='drop-area-{$rowId}' class='drop-area' data-input='filename-{$rowId}'>";
                                echo                "<p>Trascina qui l'immagine</p>";
                                echo            "</div>";
                                // Pulsante per selezionare il file manualmente
                                echo            "<div class='file-input-wrapper'>";
                                echo                "<label for='filename-{$rowId}'>Scegli File:</label>";
                                echo                "<input type='file' id='filename-{$rowId}' name='filename' form='update-form-{$rowId}' accept='image/png, image/jpeg' disabled>";
                                echo            "</div>";
                                echo        "</div>";
                                echo    "</td>";
                                
                                echo    "<td data-label='Prezzo'><input type='text' name='price' form='update-form-{$rowId}' value='" . htmlspecialchars($row['prezzo']) . "' disabled></td>";
                                echo    "<td data-label='Descrizione'><input type='text' name='description' form='update-form-{$rowId}' value='" . htmlspecialchars($row['descrizione']) . "' disabled></td>";
                                echo    "<td data-label='Categoria'><input type='text' name='category' form='update-form-{$rowId}' value='" . htmlspecialchars($row['categoria']) . "' disabled></td>";
                                
                                echo    "<td data-label='Azioni'>";
                                echo        "<form id='update-form-{$rowId}' method='POST' action='area_admin.php' enctype='multipart/form-data'>";
                                echo            "<input type='hidden' name='operation' value='update_product'>";
                                echo            "<input type='hidden' name='product_id' value='{$rowId}'>";
                                echo            "<button type='button' onclick='enableEdit(\"{$rowId}\")'>Modifica</button> ";
                                echo            "<button type='button' id='save-{$rowId}' style='display:none;' onclick='saveEdit(\"{$rowId}\")'>Salva</button>";
                                echo        "</form>";
                                echo    "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Nessun prodotto trovato.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Errore durante il recupero dei prodotti.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Sezione: Aggiungi Prodotto -->
        <div class="admin-section">
            <h3>AGGIUNGI PRODOTTO</h3>
            <form method="POST" action="area_admin.php" enctype="multipart/form-data">
                <input type="hidden" name="operation" value="add_product">

                <!--Area di Drag and Drop-->
                <div id="drop-area">
                    <p>Trascina qui l'immagine o Scegli File:</p>
                </div>
                <input type="file" id="filename" name="filename" accept="image/png, image/jpeg" required>

                <label for="price">Prezzo:</label>
                <input type="text" id="price" name="price" required>
                <label for="description">Descrizione:</label>
                <input type="text" id="description" name="description" required>
                <label for="category">Categoria:</label>
                <input type="text" id="category" name="category" required>
                <button type="submit">Aggiungi Prodotto</button>
            </form>
        </div>

        <!-- Sezione: Visualizza Clienti Registrati -->
        <div class="admin-section">
            <h3>VISUALIZZA CLIENTI REGISTRATI</h3>
            <?php
                $query = "SELECT id, name, email FROM utenti";
                $result = pg_query($conn, $query);
                if ($result) {
                    if (pg_num_rows($result) > 0) {
                        echo "<ul>";
                        while ($row = pg_fetch_assoc($result)) {
                            echo "<li><b>ID</b>: " . htmlspecialchars($row['id']) . " - <b>Nome</b>: " . htmlspecialchars($row['name']) . " - <b>Email</b>: " . htmlspecialchars($row['email']) . "</li>";
                            echo "<br>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Nessun cliente registrato.</p>";
                    }
                } else {
                    echo "<p>Errore durante il recupero dei clienti registrati.</p>";
                }
            ?>
        </div>

        <!-- Sezione: Visualizza Ordini -->
        <div class="admin-section">
            <h3>VISUALIZZA ORDINI</h3>
            <?php
                // Recupero gli ordini dal database
                $query_ordini = "SELECT id, id_utente, totale, data_creazione
                                    FROM ordini
                                    ORDER BY data_creazione DESC";
                $result_ordini = pg_query($conn, $query_ordini);

                // Recupero i dettagli degli ordini dal database
                $query_dettagli_ordine = "SELECT id_ordine, id_prodotto, quantita
                                            FROM dettagli_ordine
                                            WHERE id_ordine = $1";
                
                
                if ($result_ordini) {
                    if (pg_num_rows($result_ordini) > 0) {
                        // Lista ordinata per gli ordini
                        echo "<ol>";

                        // Per ogni ordine
                        while ($row_ordine = pg_fetch_assoc($result_ordini)) {
                            // Recupero tutti gli attributi dell'ordine
                            $id_ordine = $row_ordine['id'];
                            $id_utente = $row_ordine['id_utente'];
                            $totale = $row_ordine['totale'];
                            $data_creazione = date('Y-m-d H:i:s', strtotime($row_ordine['data_creazione']));

                            echo "<li><b>ID Ordine</b>: " . $id_ordine. " - <b>ID Utente</b>: " . $id_utente. " - <b>Totale</b>: " .$totale. " - <b>Data Creazione</b>: ".$data_creazione. "</li>";

                            // Recupero i dettagli dell'ordine
                            $result_dettagli_ordine = pg_query_params($conn, $query_dettagli_ordine, array( $id_ordine));
                            if ($result_dettagli_ordine) {
                                echo "<ul>";
                                while ($row_dettagli_ordine = pg_fetch_assoc($result_dettagli_ordine)) {
                                    $id_prodotto = $row_dettagli_ordine['id_prodotto'];
                                    $quantita = $row_dettagli_ordine['quantita'];

                                    echo "<li><i>ID Prodotto</i>: " .$id_prodotto. " - <i>Quantità</i>: " .$quantita. "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<p>Errore durante il recupero dei dettagli dell'ordine.</p>";
                            }

                            echo "<br>";
                        }

                        echo "</ol>";
                    } else {
                        echo "<p>Nessun ordine trovato.</p>";
                    }
                } else {
                    echo "<p>Errore durante il recupero degli ordini.</p>";
                } 
            ?>
        </div>

        <!-- Sezione: Cambio Credenziali Amministratore -->
        <div class="admin-section">
            <h3>CAMBIA CREDENZIALI AMMINISTRATORE</h3>
            <form method="POST" action="area_admin.php">
                <input type="hidden" name="operation" value="change_admin_credentials">
                <label for="new_admin_username">Nuovo Username:</label>
                <input type="text" id="new_admin_username" name="new_admin_username" required>
                <label for="old_admin_password">Vecchia Password:</label>
                <input type="password" id="old_admin_password" name="old_admin_password" required>
                <label for="new_admin_password">Nuova Password:</label>
                <input type="password" id="new_admin_password" name="new_admin_password" required>
                <button type="submit">Aggiorna Credenziali</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Collega il file JS esterno -->
    <script src="resources/js/area_admin.js"></script>
</body>
</html>
