<?php
require("config.php");
require("header.php");
require("classi/classiecommerce.php");
session_start();




if ($_SESSION['ruolo'] === 'utente') { ?>


    <?php

    if (isset($_POST['aggiungi'])) {

        $articolodaaggiungere = $_POST['aggiungi'];


        $carrelloutente = $_SESSION['carrelloutente'];


        $carrelloutente->aggiungiacarrello($articolodaaggiungere);


        $_SESSION['carrelloutente'] = $carrelloutente;
        
       
    } else if (isset($_POST['svuota'])) {
        
        $carrellodasvuotare = $_SESSION['carrelloutente'];
        
        $carrellodasvuotare ->svuotacarrello();
        
        $_SESSION['carrelloutente'] = $carrellodasvuotare;
        
        
    } else if (isset($_POST['elimina'])){
        
        $elementodaeliminare = $_POST['elimina'];
        
        $carrello = $_SESSION['carrelloutente'];
        
        $carrello -> eliminadacarrello($elementodaeliminare);
        
        $_SESSION['carrelloutente'] = $carrello;
        
    } else if (isset($_POST['aggiorna'])){
        
        $elementodaaggiornare = $_POST['aggiorna']; //qui è contenuto l'id del prodotto in corrispondenza del quale è stato premuto il tasto aggiorna
        
        $carrello = $_SESSION['carrelloutente'];
        
        $volte = $_POST['quantita'];
        
        $carrello -> aggiornaquantita ($elementodaaggiornare, $volte);
        
        $_SESSION['carrelloutente'] = $carrello;
    }

    ?>




    <?php

    $carrelloutente = $_SESSION['carrelloutente'];

    $prodotti_carrello = $carrelloutente->costruiscicarrello($mysqli);


    function sommaCarrello($carrello) {
        $somma = 0;
        foreach($carrello as $el) {
            $somma_parziale = $el['prezzo'];
            $somma_parziale = $somma_parziale * $el['conteggio'];
            $somma += $somma_parziale;
        }
        return $somma;
    }

    ?>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">
        <title>Carrello Prodotti</title>
    </head>

    <body>
        <div class="container">
            <header>
                <?php header_sito(); ?>
            </header>
            <div class="row">
                <div class="col">
                    <!-- codice html per il carrello -->
                    <h3 class="pt-3">Carrello</h3>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Immagine</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Quantità</th>
                                <th scope="col">Prezzo</th>
                                <th scope="col" class="text-end">Azioni</th>
                            </tr>
                        </thead>
                        <tbody id="carrello">
                            <?php foreach ($prodotti_carrello as $elemento_carrello) { ?>
                            <form action="carrello.php" method="post">
                                <tr>
                                    <td><img style="width:12vh;" src="<?php echo $elemento_carrello['immagine'] ?>" /></td>
                                    <th scope="row"><?php echo $elemento_carrello['nome_prodotto'] ?></th>
                                    <form action="carrello.php" method="post">
                                    <td><input type="number" class="form-control" style="width: 5rem;" name="quantita" value="<?php echo $elemento_carrello['conteggio'] ?>"></td>
                                    <td><?php echo $elemento_carrello['prezzo'] * $elemento_carrello['conteggio'] ?>€</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="submit" name="aggiorna" class="btn btn-warning" value="<?php echo $elemento_carrello['id'] ?>">aggiorna</button>
                                            </form>
                                            <button value="<?php echo $elemento_carrello['id'] ?>" type="submit" name="elimina" class="btn btn-danger">elimina</button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
            <form action="carrello.php" method="post">
            <div class="row">
                <div class="col-sm">
                    <h4>Totale carrello: <span id="totaleCarrello"><?php echo sommaCarrello($prodotti_carrello) ?></span>€</h4>
                </div>
                <div class="col-sm"><input style="margin-left:5px;" type="button" class="btn btn-primary float-end" name="paga" value="Acquista" onclick="paga()"><input type="submit" class="btn btn-primary float-end" name="svuota" value="Svuota Carrello"></div>
            </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>

    </html>
    
  
    
<?php
} else {
?>


    <!-- codice html da mostrare quando l'utente non è loggato -->
    non sei loggato, <a href="accedi.php">clicca qui per farlo</a>
    
    
<?php
}
?>
