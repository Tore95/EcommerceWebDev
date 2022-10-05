<?php


require("config.php");

$id = $_GET['id'];


$risultato = mysqli_query($mysqli, "DELETE FROM utenti WHERE id=$id");

echo 'Utente eliminato correttamente';

echo '<br><br>';

echo '<a href="javascript:history.back()">Torna indietro</a>';


?>