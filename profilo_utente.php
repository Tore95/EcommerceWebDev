<?php
require("header.php");
require("config.php");

session_start();

if (isset($_POST['modifica_nome'])) {
    //Aggirnare il nome dell'utente corrente
    $nuovo_nome = $_POST['nome_modificato'];
    $id = $_SESSION['idutente'];
    $risultato = mysqli_query($mysqli, "UPDATE utenti SET nome_utente='$nuovo_nome' WHERE id=$id");
    //Aggiorno la variabile di sessione
    $_SESSION['nome'] = $nuovo_nome;
    $modifica_effettuata = true;
}

if (isset($_POST['modifica_email'])) {
    $nuova_email = $_POST['email_modificata'];
    $id = $_SESSION['idutente'];
    $risultato = mysqli_query($mysqli, "UPDATE utenti SET email='$nuova_email' WHERE id=$id");
    $_SESSION['email_utente'] = $nuova_email;
    $modifica_effettuata = true;
}

//TODO: Notifica per l'avvenuta modifica!!

//Tutto quello che accade se sono utente
if ($_SESSION['ruolo'] === 'utente' or empty($_SESSION)) { ?>
    <html>

    <head>
        <title>Benvenuto | <?php echo $_SESSION['nome'] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">
    </head>

    <body>
        <?php header_sito() ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <!-- Profilo -->
                    <h3 class="pt-2">Profilo Utente</h3>
                    <hr>
                    <h4>Benvenuto | <?php echo $_SESSION['nome'] ?></h4>
                    <p>Le tue info:</p>
                    <table id="userInfo" class="table">
                        <tr>
                            <form action="profilo_utente.php" method="post">
                                <th scope='row'>Nome:</th>
                                <td>
                                    <input type="text" value="<?php echo $_SESSION['nome'] ?>" class="form-control" name="nome_modificato">
                                </td>
                                <td class="text-end">
                                    <input type="submit" class="btn btn-warning" value="Modifica" name="modifica_nome">
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <form method="POST" action="profilo_utente.php">
                                <th scope='row'>Mail:</th>
                                <td>
                                    <input value="<?php echo $_SESSION['email_utente'] ?>" name="email_modificata" type="email" class="form-control" style="width: 18rem;">
                                </td>
                                <td class="text-end">
                                    <button type="submit" name="modifica_email" class="btn btn-warning">Modifica</button>
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <th scope='row'>Ruolo:</th>
                            <td><?php echo $_SESSION['ruolo'] ?></td>
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>
                                <div class="alert alert-sm alert-warning float-end"><svg style="width: 1rem; height: 1rem;" role="img" aria-label="Warning:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <span>Non ?? possibile modificare il ruolo: contattare un amministratore</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    </body>

    </html>

<?php

} else if ($_SESSION['ruolo'] === 'amministratore') {
    //altrimenti

    header("Location: ../login/index.php");
}
?>