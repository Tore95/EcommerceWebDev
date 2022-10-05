<?php

function ricerca ($database,$parametroricerca, $tabella, $ruolo){
    
      $risultato = mysqli_query($database, "SELECT * FROM $tabella WHERE ruolo='$ruolo' AND nome_utente like '%$parametroricerca%'");
      
    
    return $risultato;
    
}

function ricercaprodotti ($database,$parametroricerca,$tabella){

$risultato = mysqli_query($database, "SELECT * FROM $tabella WHERE nome_prodotto like '%$parametroricerca%'");

return $risultato;

}


?>