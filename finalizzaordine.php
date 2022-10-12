<?php
require("config.php");
require("header.php");
require("classi/classiecommerce.php");
session_start();

if ($_SESSION['ruolo'] === 'utente') { ?>


<?php

if (isset($_POST['procedi'])){
    
    $nome_utente = $_POST['nome_utente'];
    $mail = $_POST['mail'];
    $indirizzo = $_POST['indirizzo'];
    $telefono = $_POST['telefono'];
    $nome_cognome= $_POST['nome_cognome'];
    
    $id_utente = $_SESSION['idutente'];
    
    $risultato = mysqli_query($mysqli, "INSERT INTO ordini (id_cliente,ordine,indirizzo,numero_tel,nome_cognome,stato) VALUES ('$id_utente','')");
    
}

?>


<?php

}

?>