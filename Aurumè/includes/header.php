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
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">

    <?php
      if (isset($cssFile))
          echo '<link rel="stylesheet" href="' . $cssFile . '">';
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
    ?>

    <script src="https://js.stripe.com/v3/"></script>
  </head>

    <div id="mySidenav" class="sidenav">
        <div class="classeChiudi">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <p onclick="closeNav()">Chiudi</p>
        </div>
        <h2 class="titoli">I nostri prodotti</h2>
        <a href="catalogo.php" class="collegamenti">Anelli</a>
        <a href="catalogo.php" class="collegamenti">Collane</a>
        <a href="catalogo.php" class="collegamenti">Bracciali</a>
        <a href="catalogo.php" class="collegamenti">Orecchini</a>
        <a href="catalogo.php" class="collegamenti">Orologi</a>
        <!-- <a href="index.php" class="collegamenti">Home</a> -->
        <!-- <a href="catalogo.php" class="collegamenti">Catalogo</a> -->

        <div class="containerSotto">
            <a href="faq.php" class="collSotto">FAQ</a>
            <a href="la_nostra_storia.php" class="collSotto">La nostra storia</a>
            <a href="contatti.php" class="collSotto">Contatti</a>
            <a href="termini_condizioni.php" class="collSotto">Termini e condizioni</a>
        </div>
    </div>


  <body>
    <header id="navbar">
      <script src="resources/js/header.js"></script>

      

      <!-- Sezione per aprire la sidebar -->
      <div id="main">
        <span onclick="openNav()">
          <div class="left-icons">
            <i class="fi fi-rs-bars-sort">  Menu</i>
          </div>
        </span>
      </div>

      <div class="header-title"><a href="index.php">A U R U M È</a></div>
      <div class="right-icons">
        <i class="fi fi-rs-search"></i>
        <?php if (isset($_SESSION["user_name"])): ?>
          <a href="javascript:void(0)" class="user-icon" onclick="toggleMenu()">
            <i class="fi fi-rs-user"><?php echo htmlspecialchars($_SESSION["user_name"]); ?></i>
          </a>
          <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
              <div class="user-info"><?php echo htmlspecialchars($_SESSION["user_name"]); ?></div>
              <hr>
              <a href="area_utente.php" class="sub-menu-link">
                <img src="resources/img/profile.png" alt="Area Utente">
                <p>Area Utente</p>
                <span></span>
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
          <a href="autenticazione.php"><i class="fi fi-rs-user"></i></a>
        <?php endif; ?>
        <a href="carrello.php"><i class="fi fi-rs-shopping-bag"></i></a>
      </div>
    </header>

    <!-- Overlay: elemento necessario per l'effetto blur -->
    <div id="overlay" class="overlay" onclick="closeNav()"></div>

    <script>
      function myFunction(x) {
        x.classList.toggle("change");
      }
    </script>

    <!-- Script adattato (unione del secondo pezzo) -->
    <script>
      // Selezione di tutti i figli di <body> tranne <header> e l'overlay
      document.querySelectorAll("body > *:not(header):not(#overlay):not(#mySidenav)");

      function openNav() {
        // Imposta la larghezza della sidebar
        document.getElementById("mySidenav").style.width = "21%";
        document.getElementById("mySidenav").style.left = "0";
        // Mostra l'overlay
        document.getElementById("overlay").style.display = "block";

        //Disabilita lo scroll verticale della pagina
        document.body.style.overflow = 'hidden';

        // Applica il blur a tutti i figli di <body> tranne <header> e l'overlay
        document.querySelectorAll("body > *:not(header):not(#overlay):not(#mySidenav)").forEach(function(el) {
          el.classList.add("blur-effect");
        });
      }

      function closeNav() {
        // Ripristina la larghezza della sidebar
        // document.getElementById("mySidenav").style.width = "0";
         document.getElementById("mySidenav").style.left = "-21%";
        // Nasconde l'overlay
        document.getElementById("overlay").style.display = "none";

        //Abilita lo scroll verticale della pagina
        document.body.style.overflow = '';

        // Rimuove il blur da tutti i figli di <body> tranne <header> e l'overlay
        document.querySelectorAll("body > *:not(header):not(#overlay):not(#mySidenav)").forEach(function(el) {
          el.classList.remove("blur-effect");
        });
      }
    </script>