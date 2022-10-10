<?php

session_start();

if ($_SESSION['ruolo']==='amministratore'){


if (isset($_POST['aggiungi_utente'])){
    
    require("config.php");
    
    $nuovonomeutente = $_POST['nome_utente'];
    $nuovapassword = $_POST['password'];
    $nuovaemail = $_POST['email'];
    
    $risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE nome_utente = '$nuovonomeutente'");
    
    $conteggio = mysqli_num_rows($risultato);
    
    if ($conteggio > 0){
        
        header("Location: ../login/gestioneutenti.php?nuovo-utente=error&nome-creazione=" . $nuovonomeutente);
        
    } else {
        $risultato = mysqli_query($mysqli, "INSERT INTO utenti (nome_utente,password,email,ruolo) VALUES ('$nuovonomeutente','$nuovapassword','$nuovaemail','utente')");
        header("Location: ../login/gestioneutenti.php?nuovo-utente=success&nome-creazione=" . $nuovonomeutente);
        
    }
    
    
}

}

?>