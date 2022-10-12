<?php
require("config.php");
require("header.php");
require("classi/classiecommerce.php");
session_start();

if ($_SESSION['ruolo'] === 'utente') { ?>


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
        <title>Checkout</title>
    </head>

    <body>
        <div class="container">
            <header>
                <?php header_sito(); ?>
            </header>
            
            <!-- inizio tabella carrello -->
            
                        <div class="row">
                <div class="col-lg-6">
                    <!-- codice html per il carrello -->
                    <h3 class="pt-3">Checkout</h3>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Immagine</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Quantità</th>
                                <th scope="col">Prezzo</th>
                            </tr>
                        </thead>
                        <tbody id="carrello">
                            <?php foreach ($prodotti_carrello as $elemento_carrello) { ?>
                            <form action="carrello.php" method="post">
                                <tr>
                                    <td><img style="width:12vh;" src="<?php echo $elemento_carrello['immagine'] ?>" /></td>
                                    <th scope="row"><?php echo $elemento_carrello['nome_prodotto'] ?></th>
                                    <td><input type="text" class="form-control" style="width: 5rem;" name="quantita" value="<?php echo $elemento_carrello['conteggio'] ?>" readonly></td>
                                    <td><?php echo $elemento_carrello['prezzo'] * $elemento_carrello['conteggio'] ?>€</td>
                                </tr>
                            </form>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr>
                </div>
                   
                <div class="col-lg-6">
                    <h3 class="pt-3">Nuovo Ordine</h3>
                    
                    <form class="form-control" action="finalizza_ordine.php" method="post">
                        
                        <label for="nome_utente">Nome Utente</label>
                        <input class="form-control" type="text" name="nome_utente" value="<?php echo $_SESSION['nome'] ?>" id="nome_utente" readonly>
                        
                        <label for="mail">Mail</label>
                        <input class="form-control" type="text" name="mail" value="<?php echo $_SESSION['email_utente'] ?>" id="mail" readonly>
                        
                        <h3 class="pt-3">Spedizione</h3>
                        
                         <label for="indirizzo">Indirizzo di spedizione</label>
                        <input class="form-control" type="text" name="indirizzo" id="indirizzo">
                        
                         <label for="telefono">Numero di Telefono</label>
                        <input class="form-control" type="text" name="telefono" id="telefono">
                        
                         <label for="nome_cognome">Nome e Cognome</label>
                        <input class="form-control" type="text" name="nome_cognome" id="nome_cognome">
                        <div style="margin-top:20px" class="col-sm"> 
                        <button type="submit" name="procedi" class="btn btn-primary">Procedi</button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <h4>Totale carrello: <span id="totaleCarrello"><?php echo sommaCarrello($prodotti_carrello) ?></span>€</h4>
                </div>
                
            </div>
        </div>
            
            <!-- fine tabella carrello -->
            
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>     
    </body>
    </html>
    


<?php
}
?>