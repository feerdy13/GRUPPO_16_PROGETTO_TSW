    <!-- Include the header -->
    <?php 
        $title = 'Homepage';
        $cssFile = 'resources/css/index.css';
        include 'includes/header.php'; 
    ?>

    <main>
        <video autoplay loop muted playsinline width="800" height="450">
            <source src="resources/img/" type="video/mp4">
            Il tuo browser non supporta il tag video.
        </video>
    </main>


    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>