<?php
require("header.php");
require("config.php");
require("funzioni/paginazione.php");
session_start();

if ($_SESSION['ruolo'] === 'amministratore') {



?>

    <html>

    <head>
        <title>Lista utenti</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">

    </head>

    <body>

        <?php

        header_sito();

        ?>

        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Gestione Utenti:</h1>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="registraamministratore.php" type="button" class="btn btn-primary">Aggiungi Utente</a>
                </div>
                <div class="col">
                    <form class="float-right" action="risultatiricerca.php?tiporicerca=amministratore" method="post">
                        <label class="form-lable" for="cerca">Ricerca Utente</label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="inserisci termine di ricerca" name="cerca" aria-describedby="tasto_cerca">
                            <input id="tasto_cerca" class="btn btn-dark" type="submit" value="Cerca" name="tasto_cerca">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
            <?php
            // paginazione
            $risultatopaginazione = paginazione($_GET['pagina'], 10, $mysqli, "SELECT * FROM utenti WHERE ruolo='amministratore'");
            // fine paginazione
            //devo selezionare tutti gli utenti dalla tabella utenti che corrispondono alla categoria "utente"
            // ---------------------------------------------------------------------------------------------- Numero risulati da cui partire | numero risultati da prendere
            $risultati_pagina_corrente = $risultatopaginazione['risultati_pagina_corrente'];
            $risultati_per_pagina = $risultatopaginazione['risultati_per_pagina'];
            $risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE ruolo='amministratore' ORDER BY id DESC LIMIT $risultati_pagina_corrente,$risultati_per_pagina");

            ?>
            <table class="table">
                <thead>
                    <th>Username</th>
                    <th>Ruolo</th>
                    <th>Azioni</th>
                </thead>
                <tbody>
            <?php

            while ($array = mysqli_fetch_array($risultato)) {

            ?>

            <tr>
                <td><?php echo $array['nome_utente']; ?></td>
                <td><?php echo $array['ruolo']; ?></td>
                <td>
                    <a href="modificautente.php?id=<?php echo $array['id'] ?>" class="btn btn-primary">Modifica</a>
                    <a href="eliminautente.php?id=<?php echo $array['id'] ?>" class="btn btn-danger">Elimina</a>
                </td>
            </tr>

                <?php } ?>

                </tbody>
            </table>

            <?php 

            for ($paginacorrente = 1; $paginacorrente <= $risultatopaginazione['numero_di_pagine_totali']; $paginacorrente++) {
                echo '<a style="margin-left:5px;" href="gestioneutenti.php?pagina=' . $paginacorrente . '">' . $paginacorrente . '</a>';
            }

            ?>
                    </div>
            </div>
        </div> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    </body>
    </html>

<?php

}

?>