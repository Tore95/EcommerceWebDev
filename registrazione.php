<?php
require("config.php");
require("header.php");

session_start();

if (isset($_SESSION['nome'])) {

    header("Location: ../login/benvenuto.php");
} else {

?>

    <?php




    if (isset($_POST['iscriviti'])) {


        //dobbiamo controllare che il nome utente scelto in questo momento non sia già presente nel nostro database

        $nuovonomeutente = $_POST['nomeutente'];
        $nuovamail = $_POST['email'];
        $nuovapassword = $_POST['password'];

        $risultato = mysqli_query($mysqli, "SELECT * FROM utenti");

        $utenteesistente = 0;

        while ($array = mysqli_fetch_array($risultato)) {

            if ($array['nome_utente'] === $nuovonomeutente) {
                $utenteesistente = 1;
            }
        }


        if ($utenteesistente == 1) {
            echo 'il nome utente esiste già, scegline un altro';
        } else {

            $risultato = mysqli_query($mysqli, "INSERT INTO utenti(nome_utente,password,email,ruolo) VALUES ('$nuovonomeutente','$nuovapassword','$nuovamail','utente')");

            echo 'utente registrato correttamente';
            echo '<br>';
            echo '<a href="accedi.php">Vai alla pagina di accesso</a>';
        }
    }

    ?>


    <html>

    <head>
        <title>Benvenuto | Registrati</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">
    </head>


    <body>
        <?php header_sito() ?>
        <div class="containter">
            <div class="row mb-3">
                <div class="col">
                    <h2>Registra il tuo account</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-center">
                    <form action="registrazione.php" method="post">
                        <label class="form-lable" for="nomeutente">Inserisci il nome utente</label>
                        <input class="form-control mb-2" type="text" name="nomeutente">

                        <label class="form-lable" for="email">Inserisci una email</label>
                        <input class="form-control mb-2" type="email" name="email">

                        <label class="form-lable" for="password">Inserisci una password</label>
                        <input class="form-control mb-2" type="password" name="password">

                        <input class="btn btn-success float-end" type="submit" name="Iscriviti" value="iscriviti">
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    </body>
    </html>

<?php } ?>