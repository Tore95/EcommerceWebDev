<?php

if (isset($_POST['prodotti'])) {
    require('config.php');

    $limit = intval($_POST['prodotti']);
    $prodotti = [];
    $query;

    //Richiedere prodotti dal DB

    if ($limit != 0) {
        $query = mysqli_query($mysqli, "SELECT * FROM prodotti LIMIT " . $limit);
    } else {
        $query = mysqli_query($mysqli, "SELECT * FROM prodotti");
    }


    while ($prodotto = mysqli_fetch_array($query)) {
        array_push($prodotti, $prodotto);
    }

    echo json_encode($prodotti);
}
