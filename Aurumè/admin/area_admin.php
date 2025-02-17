<?php
session_start();
include '../includes/database.php'; // Assicurati che questo file imposti correttamente la connessione in $conn

// Gestione del logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: area_admin.php");
    exit();
}

// Credenziali predefinite per il primo accesso
$default_admin_username = 'admin';
$default_admin_password = 'admin';

// Gestione del login (mostra il form se non sei loggato)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if ($username === $default_admin_username && $password === $default_admin_password) {
        $_SESSION["admin_id"] = 1;
        $_SESSION["admin_username"] = $username;
    } else {
        $query = "SELECT id, username, password FROM admin WHERE username = $1";
        $stmt = pg_prepare($conn, "admin_login", $query);
        $result = pg_execute($conn, "admin_login", array($username));
        if ($row = pg_fetch_assoc($result)) {
            if (password_verify($password, $row["password"])) {
                $_SESSION["admin_id"] = $row["id"];
                $_SESSION["admin_username"] = $row["username"];
            } else {
                $_SESSION['error'] = "Username o password errati, riprova.";
            }
        } else {
            $_SESSION['error'] = "Username o password errati, riprova.";
        }
    }
}

/**
 * Funzione per gestire il caricamento dei file.
 * Usa __DIR__ per costruire un percorso assoluto in base al percorso relativo fornito.
 */
function handleFileUpload($fileField, $targetDir) {
    if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES[$fileField]['name']);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
            return ['error' => "Errore: il file deve essere in formato PNG o JPG."];
        }
        // Costruisce il percorso assoluto: se il file PHP è in "admin/" e la cartella si trova in "../Aurumè/resources/img/catalogue/"
        $target_file = rtrim(__DIR__ . "/" . $targetDir, '/') . '/' . $filename;
        if (!move_uploaded_file($_FILES[$fileField]['tmp_name'], $target_file)) {
            error_log("Errore nel caricamento del file: " . print_r($_FILES[$fileField], true));
            return ['error' => "Errore nel caricamento del file. Verifica il percorso e i permessi."];
        }
        return ['filename' => $filename];
    }
    return ['error' => "Nessun file caricato o errore nell'upload."];
}

// Gestione delle operazioni (disponibile solo se loggato)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operation'])) {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: area_admin.php");
        exit();
    }
    
    // Operazione: Cambio Credenziali
    if ($_POST['operation'] == 'change_admin_credentials') {
        $new_admin_username = trim($_POST['new_admin_username']);
        $old_admin_password = trim($_POST['old_admin_password']);
        $new_admin_password = trim($_POST['new_admin_password']);
        $query = "SELECT password FROM admin WHERE id = $1";
        $stmt = pg_prepare($conn, "get_admin_password", $query);
        $result = pg_execute($conn, "get_admin_password", array($_SESSION["admin_id"]));
        if ($row = pg_fetch_assoc($result)) {
            $current_hashed_password = $row['password'];
            if (!password_verify($old_admin_password, $current_hashed_password)) {
                $message = "La vecchia password non è corretta.";
            } else {
                if ($new_admin_password === $old_admin_password) {
                    $query = "UPDATE admin SET username = $1 WHERE id = $2";
                    $stmt = pg_prepare($conn, "update_admin_username", $query);
                    $result = pg_execute($conn, "update_admin_username", array($new_admin_username, $_SESSION["admin_id"]));
                    if ($result) {
                        $message = "Username aggiornato con successo.";
                        $_SESSION["admin_username"] = $new_admin_username;
                    } else {
                        $message = "Errore durante l'aggiornamento del username.";
                    }
                } else {
                    $new_hashed_password = password_hash($new_admin_password, PASSWORD_DEFAULT);
                    $query = "UPDATE admin SET username = $1, password = $2 WHERE id = $3";
                    $stmt = pg_prepare($conn, "update_admin_both", $query);
                    $result = pg_execute($conn, "update_admin_both", array($new_admin_username, $new_hashed_password, $_SESSION["admin_id"]));
                    if ($result) {
                        $message = "Credenziali aggiornate con successo. Effettua nuovamente il login.";
                        session_unset();
                        session_destroy();
                    } else {
                        $message = "Errore durante l'aggiornamento delle credenziali.";
                    }
                }
            }
        } else {
            $message = "Errore: amministratore non trovato.";
        }
    }
    // Operazione: Aggiornamento Prodotto
    elseif ($_POST['operation'] == 'update_product') {
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $target_dir = "../Aurumè/resources/img/catalogue/";
        // Se viene selezionato un nuovo file, aggiorna anche il campo filename
        if (isset($_FILES['filename']) && $_FILES['filename']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = handleFileUpload('filename', $target_dir);
            if (isset($uploadResult['error'])) {
                $message = $uploadResult['error'];
                goto output;
            } else {
                $filename = $uploadResult['filename'];
                $query = "UPDATE prodotti SET filename = $1, prezzo = $2, descrizione = $3, categoria = $4 WHERE id = $5";
                $params = array($filename, $price, $description, $category, $product_id);
            }
        } else {
            // Nessun nuovo file: aggiorna solo gli altri campi
            $query = "UPDATE prodotti SET prezzo = $1, descrizione = $2, categoria = $3 WHERE id = $4";
            $params = array($price, $description, $category, $product_id);
        }
        $result = pg_query_params($conn, $query, $params);
        if (!$result) {
            $error = pg_last_error($conn);
            $message = "Errore durante l'aggiornamento del prodotto: $error";
        } else {
            $message = "Prodotto aggiornato con successo.";
        }
    }
    // Operazione: Eliminazione Prodotti
    elseif ($_POST['operation'] == 'delete_products') {
        if (isset($_POST['product_ids'])) {
            $product_ids = $_POST['product_ids'];
            $query = "DELETE FROM prodotti WHERE id = ANY($1)";
            $result = pg_query_params($conn, $query, array($product_ids));
            if (!$result) {
                $error = pg_last_error($conn);
                $message = "Errore durante l'eliminazione dei prodotti: $error";
            } else {
                $message = "Prodotti eliminati con successo.";
            }
        } else {
            $message = "Nessun prodotto selezionato per l'eliminazione.";
        }
    }
    // Operazione: Aggiunta Prodotto
    elseif ($_POST['operation'] == 'add_product') {
        $target_dir = "../Aurumè/resources/img/catalogue/";
        $uploadResult = handleFileUpload('filename', $target_dir);
        if (isset($uploadResult['error'])) {
            $message = $uploadResult['error'];
        } else {
            $filename = $uploadResult['filename'];
            if ($filename === null) {
                $message = "Nessun file selezionato.";
            } else {
                if (empty($_POST['price']) || empty($_POST['description']) || empty($_POST['category'])) {
                    $message = "Tutti i campi devono essere compilati.";
                } else {
                    $price = $_POST['price'];
                    $description = $_POST['description'];
                    $category = $_POST['category'];
                    $query = "INSERT INTO prodotti (filename, prezzo, descrizione, categoria) VALUES ($1, $2, $3, $4)";
                    $result = pg_query_params($conn, $query, array($filename, $price, $description, $category));
                    if (!$result) {
                        $error = pg_last_error($conn);
                        $message = "Errore durante l'aggiunta del prodotto: $error";
                    } else {
                        $message = "Prodotto aggiunto con successo.";
                    }
                }
            }
        }
    }
}
output:
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Area Amministratore</title>
    <link rel="stylesheet" href="resources/css/area_admin.css">
</head>
<body>
<?php if (!isset($_SESSION['admin_id'])): ?>
    <!-- Form di Login -->
    <h2>Login Amministratore</h2>
    <form method="POST" action="area_admin.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
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
<?php else: ?>
    <h2>Area Amministratore</h2>
    <!-- Bottone Logout -->
    <p><a href="area_admin.php?logout=1" class="logout-button">Logout</a></p>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <!-- Sezione: Gestione Prodotti -->
    <div class="admin-section">
        <h3>Visualizza e Modifica Prodotti</h3>
        <form method="POST" action="area_admin.php">
            <input type="hidden" name="operation" value="delete_products">
            <button type="submit">Elimina Selezionati</button>
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
                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr id='row-{$row['id']}'>";
                        echo "<form id='form-row-{$row['id']}' method='POST' action='area_admin.php' enctype='multipart/form-data'>";
                        echo "<input type='hidden' name='operation' value='update_product'>";
                        echo "<input type='hidden' name='product_id' value='{$row['id']}'>";
                        echo "<td><input type='checkbox' name='product_ids[]' value='{$row['id']}'></td>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>";
                        echo "<span>" . htmlspecialchars($row['filename']) . "</span> ";
                        echo "<input type='file' name='filename' accept='image/png, image/jpeg' disabled>";
                        echo "</td>";
                        echo "<td><input type='text' name='price' value='" . htmlspecialchars($row['prezzo']) . "' disabled></td>";
                        echo "<td><input type='text' name='description' value='" . htmlspecialchars($row['descrizione']) . "' disabled></td>";
                        echo "<td><input type='text' name='category' value='" . htmlspecialchars($row['categoria']) . "' disabled></td>";
                        echo "<td>";
                        echo "<button type='button' onclick='enableEdit(\"row-{$row['id']}\")'>Modifica</button> ";
                        echo "<button type='button' id='save-row-{$row['id']}' style='display:none;' onclick='saveEdit(\"row-{$row['id']}\")'>Salva</button>";
                        echo "</td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Errore durante il recupero dei prodotti.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Sezione: Aggiungi Prodotto -->
    <div class="admin-section">
        <h3>Aggiungi Prodotto</h3>
        <form method="POST" action="area_admin.php" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="add_product">
            <label for="filename">Filename:</label>
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
        <h3>Visualizza Clienti Registrati</h3>
        <?php
        $query = "SELECT id, name, email FROM utenti";
        $result = pg_query($conn, $query);
        if ($result) {
            if (pg_num_rows($result) > 0) {
                echo "<ul>";
                while ($row = pg_fetch_assoc($result)) {
                    echo "<li>ID: " . htmlspecialchars($row['id']) . " - Nome: " . htmlspecialchars($row['name']) . " - Email: " . htmlspecialchars($row['email']) . "</li>";
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

    <!-- Sezione: Cambio Credenziali Amministratore -->
    <div class="admin-section">
        <h3>Cambia Credenziali Amministratore</h3>
        <form method="POST" action="area_admin.php">
            <input type="hidden" name="operation" value="change_admin_credentials">
            <label for="new_admin_username">Nuovo Username:</label>
            <input type="text" id="new_admin_username" name="new_admin_username" required>
            <label for="old_admin_password">Vecchia Password:</label>
            <input type="password" id="old_admin_password" name="old_admin_password" required>
            <label for="new_admin_password">Nuova Password:</label>
            <input type="password" id="new_admin_password" name="new_admin_password" required>
            <p>Nota: Se desideri cambiare solo l'username, inserisci la stessa password nel campo "Nuova Password".</p>
            <button type="submit">Aggiorna Credenziali</button>
        </form>
    </div>
<?php endif; ?>

<!-- Richiama il file JS esterno per le funzioni (enableEdit, saveEdit, selectAll) -->
<script src="resources/js/area_admin.js"></script>
</body>
</html>
