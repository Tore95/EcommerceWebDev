<?php
session_start();
require("config.php");
require("funzioni/paginazione.php");
require("header.php");

// paginazione
$risultatopaginazione = paginazione($_GET['pagina'], 10, $mysqli, "SELECT * FROM prodotti");
// fine paginazione
//devo selezionare tutti gli utenti dalla tabella utenti che corrispondono alla categoria "utente"
// ---------------------------------------------------------------------------------------------- Numero risulati da cui partire | numero risultati da prendere
$risultati_pagina_corrente = $risultatopaginazione['risultati_pagina_corrente'];
$risultati_per_pagina = $risultatopaginazione['risultati_per_pagina'];
$risultato = mysqli_query($mysqli, "SELECT * FROM prodotti ORDER BY id DESC LIMIT $risultati_pagina_corrente,$risultati_per_pagina");

?>

<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="stile.css">
    <title>Benvenuto | E-Commerce - Articoli</title>

</head>


<body>
    <div class="container">
        <header>
            <?php header_sito(); ?>
        </header>
        <!-- Carosello del sito, Prodotti in offerta, promozioni ecc. -->
        <div class="row">
            <div class="col">
                <div id="carouselIndicators" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="risorse/banner_birre.png" class="d-block w-100" alt="birre">
                        </div>
                        <div class="carousel-item">
                            <img src="risorse/banner_panino.png" class="d-block w-100" alt="panini">
                        </div>
                        <div class="carousel-item">
                            <img src="risorse/banner_location.png" class="d-block w-100" alt="locale">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselEIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Precedente</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Successivo</span>
                    </button>
                </div>
            </div>
        </div>
        <form action="carrello.php" method="post">
        <div class="row mt-3">
            <div class="col">
                <h3>Benvenuto! ecco i nostri prodotti:</h3>
                <hr>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            
            <?php while ($prodotto_corrente = mysqli_fetch_array($risultato)) { ?>
            <!-- un ciclo genererà le card di ogni prodotto -->
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                <div class="card mb-3" style="width: 18rem;">
                    <img src="<?php echo $prodotto_corrente['immagine'] ?>" class="card-img-top" alt="<?php echo $prodotto_corrente['nome_prodotto'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $prodotto_corrente['nome_prodotto'] ?></h5>
                        <p class="card-text"><?php echo $prodotto_corrente['descrizione_prodotto'] ?></p>
                        <div class="input-group mb-3">
                            <input disabled readonly value="€ <?php echo $prodotto_corrente['prezzo'] ?>" type="text" class="form-control prod-price" aria-describedby="aggiungiAlCarrello">
                            <button type="submit" name="aggiungi" value="<?php echo $prodotto_corrente['id'] ?>" class="btn btn-primary">Aggiungi al Carrello</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>