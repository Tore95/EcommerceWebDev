<?php

require("config.php");
require("header.php");
require("classi/classiecommerce.php");

if (isset($_POST['accedi'])) {

    $nomeutente = $_POST['nome_utente'];
    $password = $_POST['password'];


    $risultato = mysqli_query($mysqli, "SELECT * FROM utenti");



    //all'interno di questo ciclo creo un oggetto array all'interno del quale inserisco l'elaborazione della funzione mysqli_fetch_array, che dalla variabile $risultato che conteneva
    //il risultato della query somministrata al database, crea un array che posso utilizzare in un ciclo per controllare tutti gli elementi che il database mi ha restituito

    $utentetrovato = 0;

    //tramite questa variabile utente trovato, ho specificato un metodo per verificare all'interno del ciclo se trovo corrispondenza tra i dati inseriti dall'utente nel form e quelli
    //riportati nel database. Se la variabile diventa 1, allora esiste una corrispondenza. Se invece rimane al suo valore iniziale definito fuori dal ciclo di 0, allora non
    //esiste corrispondenza.


    //variabile codice errore permette di segnalare all'utente quale errore è accaduto

    $codiceerrore = "";


    while ($array = mysqli_fetch_array($risultato)) {


        if ($nomeutente === $array['nome_utente']) {

            if ($password === $array['password']) {
                $utentetrovato = 1;

                $idutente = $array['id'];
                $email_utente = $array['email'];

                $ruolo = $array['ruolo'];
            } else {
                $codiceerrore = "la password non è corretta";

                break;
            }
        } else {
            $codiceerrore = "non esiste un utente con questo nome";
        }
    }


    if ($utentetrovato == 1) {

        //se l'utente viene trovato all'interno del database, avvio la sua sessione

        session_start();

        $_SESSION['nome'] = $nomeutente;
        $_SESSION['ruolo'] = $ruolo;
        $_SESSION['idutente'] = $idutente;
        $_SESSION['email_utente'] = $email_utente;
        
        if($ruolo === 'utente'){
            
        $_SESSION['carrelloutente'] = new carrello($idutente);
        }

        //dopo aver creato la sessione e avere inserito i dati corretti per l'utente, invio l'utente alla pagina benvenuto.php




    } else {
        echo $codiceerrore;
    }
}





session_start();
if (isset($_SESSION['nome'])) {
    header("Location: ../login/index.php");
}

?>


<html>

<head>
    <title>Benvenuto | Pagina di Accesso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

    <?php

    header_sito();

    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="card border-primary m-3" style="max-width: 18rem;">
                        <div class="card-header text-center">Login</div>
                        <div class="card-body">
                            <form action="accedi.php" method="post">
                                <label class="form-lable" for="nome_utente">Nome Utente</label><br>
                                <input class="form-control mb-3" type="text" name="nome_utente" id="nome_utente">
                                <label class="form-lable" for="password">Password</label><br>
                                <input class="form-control mb-3" type="password" name="password" id="password">
                                <div class="d-flex justify-content-end">
                                    <input class="btn btn-primary" type="submit" value="Accedi" name="accedi">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a class="d-flex justify-content-center" href="registrazione.php">Non hai un account? Registrati qui</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>