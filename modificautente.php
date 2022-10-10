<?php

//controllo della sessione per determinare se un utente è un amministratore ---------------------------------------------------------
// operazioni preliminari come l'avvio della sessione e l'inclusione di file esterni per funzionalità aggiuntive

session_start();
require("header.php");
require("config.php");

$id = $_GET['id'];

if ($_SESSION['ruolo'] === 'amministratore') {

?>


    <?php

    //conferma delle modifiche per modificare i dati inseriti sul database --------------------------------------------------------------

    if (isset($_POST['conferma_modifiche'])) {


        $nuovonomeutente = $_POST['nomeutente'];
        $nuovapassword = $_POST['password'];
        $nuovoruolo = $_POST['ruolo'];
        $nuovamail = $_POST['email'];

        $nomeutenteesistente = 0;

        //richiesta dati al database per il controllo

        $risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE nome_utente = '$nuovonomeutente'");


        while ($array = mysqli_fetch_array($risultato)) {

            if ($array['id'] != $id) {

                $nomeutenteesistente = 1;
            }
        }



        if ($nomeutenteesistente == 0) {

            $risultato = mysqli_query($mysqli, "UPDATE utenti SET nome_utente='$nuovonomeutente', password='$nuovapassword' , ruolo='$nuovoruolo', email='$nuovamail' WHERE id=$id");

            $stato= 'dati modificati correttamente, id modificato è ' . $id;
        } else {

            $stato= 'questo nome utente esiste già, scegline un altro';
        }
    }


    ?>




    <?php

    //selezione di un elemento del database a partire da un id da mostrare nel form html -------------------------------------------------------------



    $risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE id=$id LIMIT 1");

    while ($array = mysqli_fetch_array($risultato)) {

        $nomeutente = $array['nome_utente'];
        $password = $array['password'];
        $ruolo = $array['ruolo'];
        $mail = $array['email'];
    }


    ?>


    <html>

    <head>

        <title>Modifica Utente | Amministrazione</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">

        <script>
            function showAlert(titolo,colore,messaggio) {
                const avviso = new bootstrap.Modal('#alertModal');
                const alertTitle = document.getElementById('alertTitle');
                const alertMessage = document.getElementById('alertMessage');
                const alertColor = document.getElementById('alertColor');

                alertTitle.innerText = titolo;
                alertMessage.innerText = messaggio;

                switch (colore) {
                    case "rosso": alertColor.classList.add('alert-danger'); break;
                    case "verde": alertColor.classList.add('alert-success'); break;
                    default: alertColor.classList.add('alert-secondary');
                }

                avviso.show();
            }
        </script>
    </head>

    <body <?php if (isset($_POST['conferma_modifiche'])) { ?>onload="showAlert('Utente modificato','verde','<?php echo $stato ?>')"<?php } ?>>

        <?php
        header_sito();
        ?>

        <div class="container">
            <div class="row">
                <div class="col mt-3 d-flex justify-content-center">
                    <form class="form-modifica" action="modificautente.php?id=<?php echo $id ?>" method="post">
                        <label class="form-lable" for="nomeutente">Nome utente</label>
                        <input class="form-control mb-2" type="text" name="nomeutente" value="<?php echo $nomeutente ?>">

                        <label class="form-lable" for="email">Email</label>
                        <input class="form-control mb-2" type="text" name="email" value="<?php echo $mail ?>">

                        <label class="form-lable" for="password">Password</label>
                        <input class="form-control mb-2" type="text" name="password" value="<?php echo $password ?>">

                        <label class="form-lable" for="ruolo">Ruolo</label>
                        <select class="form-select mb-2" name="ruolo" id="ruolo">
                            <?php
                            if ($ruolo === 'amministratore') {
                                echo '<option selected value="amministratore">Amministratore</option>';
                                echo '<option value="utente">Utente</option>';
                            } else {
                                echo '<option value="amministratore">Amministratore</option>';
                                echo '<option selected value="utente">Utente</option>';
                            }
                            ?>
                        </select>
                        <?php
                            if($ruolo === 'amministratore') {
                                echo "<a class='btn btn-dark' href='gestioneadmin.php'>Annulla</a>";
                            } else {
                                echo "<a class='btn btn-dark' href='gestioneutenti.php'>Annulla</a>";
                            }
                        ?>
                        <input class="btn btn-primary float-end" type="submit" value="Conferma Modifiche" name="conferma_modifiche">
                    </form>
                </div>
            </div>
        </div>
        <!-- Alert Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLable" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertColor" class="alert">
                            <p id="alertMessage"></p>
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