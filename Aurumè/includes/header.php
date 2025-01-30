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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
    </head>
    <body>
    <header>
        <div class="left-icons">
            <!-- Icona del menu -->
            <i class="fas fa-bars"></i>
        </div>
        <div class="title">Aurumè</div>
        <div class="right-icons">
            <!-- Icona della lente di ingrandimento -->
            <i class="fas fa-search"></i>
            <!-- Icona dell'omino stilizzato -->
            <a href=""><i class="fas fa-user"></i></a>
            <!-- Icona della borsa per il carrello -->
            <a href=""><i class="fas fa-shopping-bag"></i></a>
        </div>
    </header>
