<?php

require("header.php");
require("config.php");
require("funzioni/paginazione.php");

session_start();

if ($_SESSION['ruolo'] === 'amministratore') {

    $prodotto_eliminato = isset($_GET['del']) ? $_GET['del'] : null;

    // paginazione


    $risultatopaginazione = paginazione($_GET['pagina'], 10, $mysqli, "SELECT * FROM prodotti");

    $risultati_pagina_corrente = $risultatopaginazione['risultati_pagina_corrente'];
    $risultati_per_pagina = $risultatopaginazione['risultati_per_pagina'];


    // fine paginazione

    ?>


    <html>


    <head>

        <title>Lista Prodotti</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">

    </head>

    <body <?php if ($prodotto_eliminato != null) { ?> onload="alertProdottoEliminato('<?php echo $prodotto_eliminato ?>')" <?php } ?>>
        <script>
            function confermaEliminazione(id,nome) {
                const alertState = document.getElementById('alertState');
                const alertText = document.getElementById('alertMessage');
                const alertModal = new bootstrap.Modal('#alertModal');
                const confermaBtn = document.getElementById('confermaEliminazione');
                confermaBtn.setAttribute("href", "eliminaprodotto.php?id=" + id);
                alertMessage.innerText = "Confermi di voler eliminare il prodotto: " + nome + "?";
                alertState.classList.add('alert-danger');
                alertModal.show();

            }

            function alertProdottoEliminato(nome) {
                const alertMessage = document.getElementById('alertProdottoEliminatoMessage');
                alertMessage.innerText = "Il prodotto " + nome + " è stato eliminato";
                const elimminatoModal = new bootstrap.Modal('#alertProdottoEliminatoModal');
                elimminatoModal.show();
            }
        </script>

        <?php
        header_sito();
        ?>

        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Gestione Prodotti:</h1>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aggiungiProdotto">
                        Aggiungi Prodotto
                    </button>
                </div>
                <div class="col">
                    <form class="float-right" action="risultatiricerca.php?tiporicerca=prodotti" method="post">
                        <label class="form-lable" for="cerca">Ricerca Prodotto</label>
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
                    $risultatopaginazione = paginazione($_GET['pagina'], 10, $mysqli, "SELECT * FROM prodotti");
                    // fine paginazione
                    //devo selezionare tutti gli utenti dalla tabella utenti che corrispondono alla categoria "utente"
                    // ---------------------------------------------------------------------------------------------- Numero risulati da cui partire | numero risultati da prendere
                    $risultati_pagina_corrente = $risultatopaginazione['risultati_pagina_corrente'];
                    $risultati_per_pagina = $risultatopaginazione['risultati_per_pagina'];
                    $risultato = mysqli_query($mysqli, "SELECT * FROM prodotti ORDER BY id DESC LIMIT $risultati_pagina_corrente,$risultati_per_pagina");

                    ?>
                    <table class="table">
                        <thead>
                            <th>Immagine</th>
                            <th>Nome Prodotto</th>
                            <th class="text-end">Azioni</th>
                        </thead>
                        <tbody>
                            <?php

                            while ($array = mysqli_fetch_array($risultato)) {

                            ?>

                                <tr>
                                    <td><img style="width:12vh;" src="<?php echo $array['immagine'] ?>" /></td>
                                    <td><?php echo $array['nome_prodotto']; ?></td>
                                    <td class="text-end">
                                        <a href="modificaprodotto.php?id=<?php echo $array['id'] ?>" class="btn btn-primary me-1">Modifica</a>
                                        <input type="button" onclick="confermaEliminazione(<?php echo $array['id'] ?>, '<?php echo $array['nome_prodotto'] ?>')" class="btn btn-danger" value="Elimina"/>
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
        <!-- Aggiungi Prodotto Modal -->
        <div class="modal fade" id="aggiungiProdotto" tabindex="-1" aria-labelledby="aggiungiProdottoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aggiungiProdottoLabel">Aggiungi Prodotto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="aggiunginuovoprodotto.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <label for="categoria" class="form-lable">Categoria</label>
                            <select name="categoria" class="form-select" aria-label="Default select example">
                                <option selected>Seleziona la categoria</option>
                                <option value="analcolici">Analcolici</option>
                                <option value="alcolici">Alcolici</option>
                                <option value="cibo">Cibo</option>
                            </select>
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control">
                            <label for="descrizione" class="form-label">Descrizione</label>
                            <input type="text" class="form-control" name="descrizione">
                            <label for="prezzo" class="form-label">Prezzo</label>
                            <input type="text" class="form-control" name="prezzo">
                            <label for="immagine" class="form-label">Immagine</label>
                            <input type="file" class="form-control" name="immagine">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            <button type="submit" name="aggiungi_prodotto" class="btn btn-primary">Aggiungi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Conferma Eliminazione Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertModalLabel">Confema Eliminazione?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertState" class="alert">
                            <p id="alertMessage"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <a id="confermaEliminazione" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Prodotto Eliminato Modal -->
        <div class="modal fade" id="alertProdottoEliminatoModal" tabindex="-1" aria-labelledby="alertProdottoEliminatoModalLable" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertProdottoEliminatoModalLable">Prodotto eliminato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <p id="alertProdottoEliminatoMessage"></p>
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