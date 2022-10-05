<?php

require("config.php");
require("classi/classiecommerce.php");
require("header.php");

session_start();

if ($_SESSION['ruolo'] === 'amministratore') {

?>


        <html>

        <head>
                <title>Modifica prodotto</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
                <link rel="stylesheet" href="stile.css">

        </head>


        <body>

                <?php

                header_sito();

                ?>


                <?php

                if (isset($_POST['modifica_prodotto'])) {

                        $id = $_GET['id'];

                        $nome = $_POST['nome'];
                        $descrizione = $_POST['descrizione'];
                        $categoria = $_POST['categoria'];
                        $prezzo = $_POST['prezzo'];

                        $prodottodamodificare = new prodotto();

                        $prodottodamodificare->selezionaprodotto($id, $mysqli, 'prodotti');

                        $prodottodamodificare->modificadati($nome, $descrizione, $categoria, $prezzo);

                        $prodottodamodificare->inserisci_database($mysqli, 'prodotti');

                        echo 'dati modificati';
                }
                $id = $_GET['id'];

                $prodottodamodificare = new prodotto();

                $prodottodamodificare->selezionaprodotto($id, $mysqli, 'prodotti');

                $array = $prodottodamodificare->stampaprodotto();



                ?>


                <div class="container">
                        <div class="row mt-5 d-flex justify-content-center">
                                <form class="form-modifica" action="modificaprodotto.php?id=<?php echo $id ?>" method="POST">
                                        <label class="form-lable" for="nome">Nome</label>
                                        <input class="form-control mb-2" id="nome" name="nome" type="text" value="<?php echo $array['nome'] ?>">
                                        <label class="form-lable" for="descrizione">Descrizione</label>
                                        <textarea class="form-control mb-2" id="descrizione" name="descrizione"><?php echo $array['descrizione'] ?></textarea>
                                        <label class="form-lable" for="categoria">Categoria</label>
                                        <label for="categoria" class="form-lable">Categoria</label>
                                        <select id="categoria" name="categoria" class="form-select mb-2" aria-label="Default select example">
                                                <option <?php if ($array['categoria'] === 'analcolici') { echo "selected"; } ?> value="analcolici">Analcolici</option>
                                                <option <?php if ($array['categoria'] === 'alcolici') { echo "selected"; } ?> value="alcolici">Alcolici</option>
                                                <option <?php if ($array['categoria'] === 'cibo') { echo "selected"; } ?> value="cibo">Cibo</option>
                                        </select>
                                        <label class="form-lable" for="prezzo">Prezzo</label>
                                        <input class="form-control mb-2" name="prezzo" id="prezzo" type="text" value="<?php echo $array['prezzo'] ?>">
                                        <div class="row">
                                                <div class="col">
                                                        <a href="listaprodotti.php" class="btn btn-dark">Torna Indietro</a>
                                                </div>
                                                <div class="col text-end">
                                                        <input type="submit" class="btn btn-primary text-end" value="Modifica Prodotto" name="modifica_prodotto">
                                                </div>
                                        </div>

                                </form>
                        </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        </body>

        </html>



<?php
}
?>