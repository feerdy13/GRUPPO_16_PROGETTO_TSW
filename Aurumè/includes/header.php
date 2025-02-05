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
    <header>
        

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

        

        <!-- Add all page content inside this div if you want the side nav to push page content to 
         the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <!-- Use any element to open the sidenav -->
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
        /* Set the width of the side navigation to 250px */
        function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        }
    </script>