<?php

require("config.php");
require("header.php");
require("funzioni/ricerca.php");

session_start();

if ($_SESSION['ruolo'] === 'amministratore') {

?>

    <html>

    <head>
        <title>Risultati Ricerca</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="stile.css">
    </head>

    <body>
        <?php

        header_sito();

        ?>

<?php

if (isset($_POST['tasto_cerca'])){

    $tiporicerca = $_GET['tiporicerca'];
    $isProdotti = false;

    if(!empty($tiporicerca)){

        if ($tiporicerca==='prodotti'){

            $isProdotti =true;

            $elementi = ricercaprodotti($mysqli, $_POST['cerca'],'prodotti');


        } else {

            $elementi = ricerca($mysqli, $_POST['cerca'], 'utenti', $tiporicerca);

        }

    }
    

    //header tabella
?>


        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Risualtati Ricerca:</h1>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col">

<?php

if ($tiporicerca ==='prodotti'){

    $link =  'http://danielintrieri.netsons.org/login/listaprodotti.php' ;

}else if ($tiporicerca ==='amministratore'){
    $link = 'http://danielintrieri.netsons.org/login/gestioneadmin.php';
} else if ($tiporicerca ==='utente') {
    $link= 'http://danielintrieri.netsons.org/login/gestioneutenti.php';
}


?>


               <a href="<?php echo $link ?>" class="btn btn-primary">Torna a lista</a>
                    
                </div>
                <div class="col">
                    <form class="float-right" action="risultatiricerca.php?tiporicerca=<?php echo $tiporicerca ?>" method="post">
                        <label class="form-lable" for="cerca">Ricerca <?php echo $tiporicerca ?></label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="inserisci termine di ricerca" name="cerca" aria-describedby="tasto_cerca">
                            <input id="tasto_cerca" class="btn btn-dark" type="submit" value="Cerca" name="tasto_cerca">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <?php if ($isProdotti == false) { ?>

                        <table class="table">
                            <thead>
                                <th>Username</th>
                                <th>Ruolo</th>
                                <th>Azioni</th>
                            </thead>
                            <tbody>
                                <?php


                                while ($elemento = mysqli_fetch_array($elementi)) {
                                    //row tabella
                                ?>

                                    <tr>
                                        <td><?php echo $elemento['nome_utente']; ?></td>
                                        <td><?php echo $elemento['ruolo']; ?></td>
                                        <td>
                                            <a href="modificautente.php?id=<?php echo $elemento['id'] ?>" class="btn btn-primary">Modifica</a>
                                            <a href="eliminautente.php?id=<?php echo $elemento['id'] ?>" class="btn btn-danger">Elimina</a>
                                        </td>
                                    </tr>

                                <?php
                                }
                                //chiusura tabella
                                ?>

                            </tbody>
                        </table>
                    <?php } else { ?>

                        <table class="table">
                            <thead>
                                <th>Immagine</th>
                                <th>Nome Prodotto</th>
                                <th>Azioni</th>
                            </thead>
                            <tbody>
                                <?php


                                while ($elemento = mysqli_fetch_array($elementi)) {
                                    //row tabella
                                ?>

                                    <tr>
                                        <td><img style="width:12vh;" src="<?php echo $elemento['immagine']; ?>" /></td>
                                        <td><?php echo $elemento['nome_prodotto']; ?></td>
                                        <td>
                                            <a href="modificaprodotto.php?id=<?php echo $elemento['id'] ?>" class="btn btn-primary">Modifica</a>
                                            <a href="eliminaprodotto.php?id=<?php echo $elemento['id'] ?>" class="btn btn-danger">Elimina</a>
                                        </td>
                                    </tr>

                                <?php
                                }
                                //chiusura tabella
                                ?>

                            </tbody>
                        </table>

                    <?php } ?>    

                    <?php
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