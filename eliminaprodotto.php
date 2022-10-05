<?php

session_start();

if ($_SESSION['ruolo'] === 'amministratore') {

    require("config.php");
    require("classi/classiecommerce.php");


    $id = $_GET['id'];

    $prodottodaeliminare = new prodotto();

    $prodottodaeliminare->selezionaprodotto($id, $mysqli, 'prodotti');

    $nomedelprodotto = $prodottodaeliminare->stampaprodotto();

    $prodottodaeliminare->eliminaprodotto($id, $mysqli, 'prodotti');

    header("Location: ../login/listaprodotti.php?del=" . $nomedelprodotto['nome']);
}
