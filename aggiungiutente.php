<?php

session_start();

if ($_SESSION['ruolo']==='amministratore'){

?>



<?php


if (isset($_POST['aggiungi_utente'])){
    
    require("config.php");
    
    $nuovonomeutente = $_POST['nome_utente'];
    $nuovapassword = $_POST['password'];
    $nuovaemail = $_POST['email'];
    
    $risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE nome_utente = '$nuovonomeutente'");
    
    $conteggio = mysqli_num_rows($risultato);
    
    if ($conteggio > 0){
        
        echo 'questo nome utente esiste già, sceglierne un altro';
        
    } else {
        
        $risultato = mysqli_query($mysqli, "INSERT INTO utenti (nome_utente,password,email,ruolo) VALUES ('$nuovonomeutente','$nuovapassword','$nuovaemail','utente')");
        echo 'utente creato correttamente';
        
    }
    
    
}


?>








<?php

}

?>