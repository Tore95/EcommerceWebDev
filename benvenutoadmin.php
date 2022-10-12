<?php

session_start();
require("header.php");

if ($_SESSION['ruolo'] === 'amministratore') {

?>
    <html>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">
    </head>

    <body style="text-align:center;">

    <?php

    header_sito();

    ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Amministrazione:</h1>
                <hr>
                <h4>Selezionare la sezione desiderata</h4>
                <table class="table">
                    <thead>
                        <th>Sezione</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gestione Prodotti</td>
                            <td><a href="listaprodotti.php" class="btn btn-warning">Accedi <i class="fa-solid fa-pen-to-square"></i></a></td>
                        </tr>
                        <tr>
                            <td>Gestione Utenti</td>
                            <td><a href="gestioneutenti.php" class="btn btn-warning">Accedi <i class="fa-solid fa-pen-to-square"></i></a></td>
                        </tr>
                        <tr>
                            <td>Gestione Admin</td>
                            <td><a href="gestioneadmin.php" class="btn btn-warning">Accedi <i class="fa-solid fa-pen-to-square"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <?php

    //echo '<a href="registraamministratore.php">Registra nuovo admin</a>';
    } else if ($_SESSION['ruolo'] === 'utente') {
        header("Location: ../login/benvenuto.php");
    }


    ?>

    </body>

    </html>