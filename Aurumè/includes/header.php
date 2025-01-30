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

        <?php
            if (isset($cssFile)) 
                echo '<link rel="stylesheet" href="' . $cssFile . '">';
        ?>
        
    </head>
    <body>
    <header>
        <div class="left-icons">
            <!-- Icona del menu -->
            <i class="fi fi-rs-bars-sort">  Menu</i>
            
        </div>
        <div class="title"><a href="index.php">A U R U M È</a></div>
        <div class="right-icons">
            <!-- Icona della lente di ingrandimento -->
            <i class="fi fi-rs-search"></i>
            <!-- Icona dell'omino stilizzato -->
            <a href=""><i class="fi fi-rs-user"></i></a>
            <!-- Icona della borsa per il carrello -->
            <a href=""><i class="fi fi-rs-shopping-bag"></i></a>
        </div>
    </header>
