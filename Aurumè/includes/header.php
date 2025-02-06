<!DOCTYPE html>
<html>
    <head lang="it">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php
            if (isset($title)) 
                echo '<title>' . $title . ' | Aurumè Official Store</title>'; 
        ?>

        <link rel="stylesheet" href="resources/css/config.css">
        <link rel="stylesheet" href="resources/css/header.css">
        <link rel="stylesheet" href="resources/css/footer.css">
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

        <?php
            if (isset($cssFile)) 
                echo '<link rel="stylesheet" href="' . $cssFile . '">';

            // Verifica se una sessione è già stata avviata
            if (session_status() == PHP_SESSION_NONE) {
                session_start();  // Avvia la sessione solo se non è già attiva
            }     
        ?>
        
    </head>
    <body>
    <header id="navbar">
        

        <!--<div class="container" onclick="myFunction(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                </div>-->

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href='index.php'>Home</a>
            <a href='catalogo.php'>Catalogo</a>
            <a href='faq.php'>FAQ</a>
        </div>

        

        <!-- Aggiungi tutto il contenuto della pagina all'interno di questo div se vuoi che la side nav spinga il contenuto della pagina a destra (non utilizzato se vuoi solo che la sidenav si sovrapponga alla pagina -->
        <div id="main">
            <!-- Usa qualsiasi elemento per aprire la sidenav -->
            <span onclick="openNav()">
                <div class="left-icons">
                    <!--Icona del menu--> 
                    <i class="fi fi-rs-bars-sort">  Menu</i>
                    
                </div>
            </span>
        </div>
        
        <div class="header-title"><a href="index.php">A U R U M È</a></div>
        <div class="right-icons">
                <!-- Icona della lente di ingrandimento -->
                <i class="fi fi-rs-search"></i>

                <!-- Controllo se l'utente è loggato -->
                <?php if (isset($_SESSION["user_name"])): ?>
                        <!-- Icona dell'omino stilizzato -->
                        <a href="javascript:void(0)" class="user-icon" onclick="toggleMenu()">
                            <i class="fi fi-rs-user">
                                <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                            </i> 
                        </a>
                    <div class="sub-menu-wrap" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                            </div>
                            <hr>

                            <a href="area_utente.php" class="sub-menu-link">
                                <img src="resources/img/profile.png" alt="Area Utente">
                                <p>Area Utente</p>
                                <span>></span>
                            </a>
                            <a href="action/logout.php" class="sub-menu-link">
                                <img src="resources/img/logout.png" alt="Logout">
                                <p>Logout</p>
                                <span>></span>
                            </a>
                        </div>
                    </div>
                    <script src="resources/js/header.js"></script>
                <?php else: ?>
                    <!-- Icona dell'omino stilizzato -->
                    <a href="autenticazione.php"><i class="fi fi-rs-user"></i></a>
                <?php endif; ?>
            <!-- Icona della borsa per il carrello -->
            <a href="carrello.php"><i class="fi fi-rs-shopping-bag"></i></a>
        </div>
    </header>
    <script>
    function myFunction(x) {
    x.classList.toggle("change");
    }
    </script>




    <script>
        /* Imposta la larghezza della navigazione laterale al 20% della larghezza della pagina */
        function openNav() {
            // Di quanto deve uscire la sidebar
            document.getElementById("mySidenav").style.width = "20%";

            // Cambia il colore di sfondo del body
            document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
            //document.body.style.color = "black";

            // Cambia il colore di sfondo dell'header
            document.querySelector("header").style.backgroundColor = "rgba(0,0,0,0.5)";
            //document.querySelector("header").style.color = "black";

            // Cambia il colore di sfondo del footer
            document.querySelector("footer").style.backgroundColor = "rgba(0,0,0,0.5)";
            //document.querySelector("footer").style.color = "black";

        }

        /* Imposta la larghezza della navigazione laterale a 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.body.style.backgroundColor = "whitesmoke";
            document.querySelector("header").style.backgroundColor = "var(--first-color)";
            document.querySelector("footer").style.backgroundColor = "var(--third-color)";
        }
    </script>

    <script>
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        document.getElementById("navbar").style.top = "0";
    } else {
        document.getElementById("navbar").style.top = "-90px";
    }
    prevScrollpos = currentScrollPos;
    }
    </script>