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

        <script>
            function confermaEliminazione(id, nome) {
                const modal = new bootstrap.Modal('#conferma-eliminazione');
                const messaggio = document.getElementById('conferma-eliminazione-messaggio');
                const bottone = document.getElementById('conferma-eliminazione-bottone');
                bottone.setAttribute('href',"eliminautente.php?id=" + id + "&nome=" + nome);
                messaggio.innerText = "Eliminare l'utente: " + nome + '?';
                modal.show();
            }
            function avvisoEliminazione(nome) {
                const modal = new bootstrap.Modal('#avviso-eliminazione');
                const messaggio = document.getElementById('avviso-eliminazione-messaggio');
                messaggio.innerText = "L'utente " + nome + " è stato eliminato."
                modal.show();
            }
            function avvisoCreazione(nome) {
                const modal = new bootstrap.Modal('#avviso-eliminazione');
                //Selezionare il titolo e cambiarlo in "Creazione Utente"
                const messaggio = document.getElementById('avviso-eliminazione-messaggio');
                if(nome === 'success') {
                    //messaggio vede
                    messaggio.innerText = "L'utente " + "<?php echo $_GET['nome-creazione'] ?>" + " è stato creato."
                } else {
                    //messaggio rosso
                    messaggio.innerText = "L'utente con il nome " + "<?php echo $_GET['nome-creazione'] ?>" + " esiste già";
                }
                modal.show();
            }
        </script>

    </head>

    <body
    <?php if(isset($_GET['eliminato'])) { ?> onload="avvisoEliminazione('<?php echo $_GET['eliminato'] ?>')" <?php } ?>
    <?php if(isset($_GET['nuovo-utente'])) { ?> onload="avvisoCreazione('<?php echo $_GET['nuovo-utente'] ?>')" <?php } ?>
    >

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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aggiungiUtente">
                        Aggiungi Utente
                    </button>
                </div>
                <div class="col">
                    <form class="float-right" action="risultatiricerca.php?tiporicerca=utente" method="post">
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
                    $risultatopaginazione = paginazione($_GET['pagina'], 10, $mysqli, "SELECT * FROM utenti WHERE ruolo='utente'");
                    // fine paginazione
                    //devo selezionare tutti gli utenti dalla tabella utenti che corrispondono alla categoria "utente"
                    // ---------------------------------------------------------------------------------------------- Numero risulati da cui partire | numero risultati da prendere
                    $risultati_pagina_corrente = $risultatopaginazione['risultati_pagina_corrente'];
                    $risultati_per_pagina = $risultatopaginazione['risultati_per_pagina'];
                    $risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE ruolo='utente' ORDER BY id DESC LIMIT $risultati_pagina_corrente,$risultati_per_pagina");

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
                                        <button onclick="confermaEliminazione(<?php echo $array['id'] ?>,'<?php echo $array['nome_utente']; ?>')" class="btn btn-danger">Elimina</button>
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

        <!-- Aggiungi Utente Modal -->
        <div class="modal fade" id="aggiungiUtente" tabindex="-1" aria-labelledby="aggiungiUtenteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aggiungiUtenteLabel">Aggiungi Utente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="aggiungiutente.php" method="post">
                        <div class="modal-body">

                            <label for="nome_utente">Nome Utente</label><br>
                            <input type="text" class="form-control" id="nome_utente" name="nome_utente">

                            <label for="password">Email</label><br>
                            <input type="text" class="form-control" id="email" name="email">

                            <label for="password">Password</label><br>
                            <input type="text" class="form-control" id="password" name="password">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            <button type="submit" name="aggiungi_utente" class="btn btn-primary">Aggiungi Utente</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- Conferma Eliminazione Modal -->
        <div class="modal fade" id="conferma-eliminazione" tabindex="-1" aria-labelledby="conferma-eliminazione-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="conferma-eliminazione-label">Confema Eliminazione?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertState" class="alert alert-danger">
                            <p id="conferma-eliminazione-messaggio"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <a id="conferma-eliminazione-bottone" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Avviso Eliminazione Modal -->
        <div class="modal fade" id="avviso-eliminazione" tabindex="-1" aria-labelledby="avviso-eliminazione-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="avviso-eliminazione-label">Utente Eliminato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertState" class="alert alert-success">
                            <p id="avviso-eliminazione-messaggio"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    </body>

    </html>

<?php

}

?>