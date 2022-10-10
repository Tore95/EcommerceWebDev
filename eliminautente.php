<?php


require("config.php");

$id = $_GET['id'];
$nome = $_GET['nome'];


$risultato = mysqli_query($mysqli, "DELETE FROM utenti WHERE id=$id");

header("Location: ../login/gestioneutenti.php?eliminato=" . $nome);

?>