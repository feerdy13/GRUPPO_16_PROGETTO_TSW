<!-- Include the header -->
    <?php 
        $title = 'Catalogo';
        $cssFile = 'resources/css/catalogo.css';
        include 'includes/header.php'; 
    ?>

    <h2 class="title">La nostra Collezione</h2>
    
    <div class="filters">
        <a href="?filter=bracciali" class="filter-link">bracciali</a>
        <a href="?filter=collane" class="filter-link">collane</a>
        <a href="?filter=orecchini" class="filter-link">orecchini</a>
        <a href="?filter=orologi" class="filter-link">orologi</a>
        <a href="?filter=anelli" class="filter-link">anelli</a>
    </div>







    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>