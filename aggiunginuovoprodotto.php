<?php

require("config.php");
require("classi/classiecommerce.php");

session_start();

if ($_SESSION['ruolo'] === 'amministratore') {
 
    if (isset($_POST['aggiungi_prodotto'])) {
       
        $nuovoprodotto = new prodotto();

        $nuovoprodotto->aggiungidati($_POST['nome'], $_POST['descrizione'], $_POST['categoria'], $_POST['prezzo'], $_FILES['immagine']);

        if ($nuovoprodotto->popolato() == true) {
            $nuovoprodotto->inserisci_database($mysqli, 'prodotti');
            header("Location: ../login/listaprodotti.php");
        } else {
            echo 'dati non inseriti';
        }
    }
}


?>