<?php
    require '../stripe/vendor/autoload.php';
    require '../includes/database.php';

    // Chiavi API Stripe
    \Stripe\Stripe::setApiKey('sk_test_51QsnxdK1LdU5EUe8xz8URqknCOVOgyugYJJzmHwKnRIRYVXkpO1yKky7xH65YiQW2NvPObjBh9hkdJK8QY7nYfaM00YHaoNYhz'); // Secret Key

    // Debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Imposta l'intestazione per JSON
    header('Content-Type: application/json');

    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);    //Accesso non autorizzato
        echo json_encode(['error' => 'Utente non autenticato']);
        exit;
    }
    $user_id = $_SESSION['user_id'];

    // Calcolo il totale del carrello lato server 
    $query_total = "SELECT SUM(p.prezzo * c.quantita) AS total
                                FROM carrello c 
                                JOIN prodotti p ON c.id_prodotto = p.id 
                                WHERE c.id_utente = $1";
    pg_prepare($conn, "calcola_totale", $query_total);
    $result_total = pg_execute($conn, "calcola_totale", array($user_id));
    $totale = pg_fetch_result($result_total, 0, 'total');

    // Converti l'importo in centesimi
    $totale = $totale * 100;

    try {
        // Crea un Payment Intent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $totale,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
            'description' => 'Aurumè: Pagamento ordine'
        ]);
    
        // Restituisci la client_secret in JSON
        echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
    
    } catch (Exception $e) {
        // In caso di errore, restituisci il messaggio in JSON
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>