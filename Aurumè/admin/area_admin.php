<?php
session_start();
include '../includes/database.php'; // Assicurati che questo file stabilisca correttamente la connessione ($conn)

// Gestione del logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: area_admin.php");
    exit();
}

// Credenziali predefinite per il primo accesso (attenzione: se usi questi valori, assicurati di inserirli in modo appropriato nel DB)
$default_admin_username = 'admin';
$default_admin_password = 'admin';

// Gestione del login (se non sei loggato viene mostrato il form di login)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Se usi credenziali predefinite (attenzione: questo metodo non effettua un controllo hash)
    if ($username === $default_admin_username && $password === $default_admin_password) {
        $_SESSION["admin_id"] = 1; // ID fittizio per l'amministratore predefinito
        $_SESSION["admin_username"] = $username;
    } else {
        // Cerca l'amministratore nel database
        $query = "SELECT id, username, password FROM admin WHERE username = $1";
        $stmt = pg_prepare($conn, "admin_login", $query);
        $result = pg_execute($conn, "admin_login", array($username));

        if ($row = pg_fetch_assoc($result)) {
            // Usa password_verify per controllare la password hashata
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

// Funzione per gestire il caricamento dei file (usata per i prodotti)
function handleFileUpload($fileField, $targetDir) {
    if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] != UPLOAD_ERR_NO_FILE) {
        $filename = $_FILES[$fileField]['name'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
            return ['error' => "Errore: il file deve essere in formato PNG o JPG."];
        }
        $target_file = $targetDir . basename($filename);
        if (!move_uploaded_file($_FILES[$fileField]['tmp_name'], $target_file)) {
            return ['error' => "Errore nel caricamento del file."];
        }
        return ['filename' => $filename];
    }
    return ['filename' => null];
}

// Gestione delle operazioni (accessibili solo se loggato)
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

        // Recupera la password attuale dal DB per l'amministratore loggato
        $query = "SELECT password FROM admin WHERE id = $1";
        $stmt = pg_prepare($conn, "get_admin_password", $query);
        $result = pg_execute($conn, "get_admin_password", array($_SESSION["admin_id"]));
        if ($row = pg_fetch_assoc($result)) {
            $current_hashed_password = $row['password'];
            // Verifica la vecchia password
            if (!password_verify($old_admin_password, $current_hashed_password)) {
                $message = "La vecchia password non è corretta.";
            } else {
                // Se la nuova password in chiaro è uguale alla vecchia, si intende che si voglia cambiare solo l'username
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
                    // Se la nuova password è diversa, aggiorna sia username che password (hashando la nuova password)
                    $new_hashed_password = password_hash($new_admin_password, PASSWORD_DEFAULT);
                    $query = "UPDATE admin SET username = $1, password = $2 WHERE id = $3";
                    $stmt = pg_prepare($conn, "update_admin_both", $query);
                    $result = pg_execute($conn, "update_admin_both", array($new_admin_username, $new_hashed_password, $_SESSION["admin_id"]));
                    if ($result) {
                        $message = "Credenziali aggiornate con successo. Effettua nuovamente il login.";
                        // Forza il logout se la password è cambiata
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
        $target_dir = "../uploads/";
        $uploadResult = handleFileUpload('filename', $target_dir);
        if (isset($uploadResult['error'])) {
            $message = $uploadResult['error'];
        } else {
            $filename = $uploadResult['filename'];
            if ($filename !== null) {
                $query = "UPDATE prodotti SET filename = $1, prezzo = $2, descrizione = $3, categoria = $4 WHERE id = $5";
                $params = array($filename, $price, $description, $category, $product_id);
            } else {
                $query = "UPDATE prodotti SET prezzo = $1, descrizione = $2, categoria = $3 WHERE id = $4";
                $params = array($price, $description, $category, $product_id);
            }
            $stmt = pg_prepare($conn, "update_product", $query);
            $result = pg_execute($conn, "update_product", $params);
            
            // Debug se la query fallisce
            if (!$result) {
                $error = pg_last_error($conn);
                $message = "Errore durante l'aggiornamento del prodotto: $error";
            } else {
                $message = "Prodotto aggiornato con successo.";
            }
        }
    }
    // Operazione: Eliminazione Prodotti
    elseif ($_POST['operation'] == 'delete_products') {
        if (isset($_POST['product_ids'])) {
            $product_ids = $_POST['product_ids'];
            $query = "DELETE FROM prodotti WHERE id = ANY($1)";
            $stmt = pg_prepare($conn, "delete_products", $query);
            $result = pg_execute($conn, "delete_products", array($product_ids));
            
            // Debug se la query fallisce
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
        $target_dir = "../uploads/";
        $uploadResult = handleFileUpload('filename', $target_dir);
        if (isset($uploadResult['error'])) {
            $message = $uploadResult['error'];
        } else {
            $filename = $uploadResult['filename'];
            if ($filename === null) {
                $message = "Nessun file selezionato.";
            } else {
                $price = $_POST['price'];
                $description = $_POST['description'];
                $category = $_POST['category'];
                
                $query = "INSERT INTO prodotti (filename, prezzo, descrizione, categoria) VALUES ($1, $2, $3, $4)";
                $stmt = pg_prepare($conn, "add_product", $query);
                $result = pg_execute($conn, "add_product", array($filename, $price, $description, $category));
                
                // Debug se la query fallisce
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
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Area Amministratore</title>
    <link rel="stylesheet" href="../resources/css/area_admin.css">
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
                        // Form di aggiornamento (update_product)
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
        // Si assume che la tabella "utenti" contenga i clienti con i campi "id", "name" ed "email"
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

<!-- Richiamiamo il file JS esterno con le funzioni: enableEdit, saveEdit, selectAll -->
<script src="../resources/js/area_utente.js"></script>
</body>
</html>
