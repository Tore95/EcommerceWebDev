<?php

require('../config.php');

if(isset($_POST['users'])) {
    $tipo = $_POST['users'];

    if ($tipo === 'all') {
        $query = "SELECT * FROM utenti";
    } else {
        $query = "SELECT * FROM utenti WHERE ruolo = '$tipo'";
    }

    //recuperare utenti dal db
    
    $msql_lista = mysqli_query($mysqli,$query);
    $lista = [];

    while($utente = mysqli_fetch_array($msql_lista)) {
        array_push($lista,$utente);
    }

    //restituire lista utenti in json
    echo json_encode($lista);
}