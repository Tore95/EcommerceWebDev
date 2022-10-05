<?php

function header_sito(){
    
    session_start();
    
    $isAdmin = false;
    $isUser = false;

    if ($_SESSION['ruolo'] === 'amministratore') {
        $isAdmin = true;
    } else if ($_SESSION['ruolo']==='utente') {
        $isUser = true;
    }

?>

    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">E-commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($isUser){ ?>    
                <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrello.php">Carrello</a>
                    </li>
                <?php } ?>    
                    <?php if (!$isAdmin && !$isUser) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="accedi.php">Login</a>
                    </li>
                    <?php
                    } else if ($isUser) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profilo_utente.php">Benvenuto, <?php echo $_SESSION['nome'] ?></a>
                    </li>
                    <?php
                    } else if ($isAdmin) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="amministrazione.php">Amministrazione</a>
                    </li>
                    <?php } ?>
                    <?php if ($isAdmin || $isUser) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Esci</a>
                    </li>
                    <?php } ?>
                </ul>
                <?php if($isUser){ ?>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Cerca..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Cerca</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </nav>

    

<?php

}

?>