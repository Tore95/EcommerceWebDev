<?php
session_start();
require("config.php");
require("header.php");

if ($_SESSION['ruolo']==='amministratore'){
    
    ?>
    
    
<?php

if(isset($_POST['registra_amministratore'])){
    
    $nomeutente = $_POST['nomeutente'];
    $password = $_POST['password'];
    
    
$risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE nome_utente like '%$nomeutente%'");   

$conteggio = mysqli_num_rows($risultato);

if ($conteggio > 0){
    echo 'questo utente esiste già nel sistema, scegliere un altro nome utente';
} else {
    
 
$risultato = mysqli_query($mysqli, "INSERT INTO utenti (nome_utente,password,ruolo) VALUES ('$nomeutente','$password','amministratore')");

echo 'amministratore registrato con successo';
 
    
}
    
}

?>
    
    
    <html>
        
        <head>
            
            <title>Registra nuovo amministratore</title>
            <link rel="stylesheet" href="stile.css">
            
        </head>
        
        
           <?php
   
   header_sito();
   
   ?>
        
        <body style="text-align:center;">
            
            
            <h2>Registra nuovo amministratore</h2>
            
            <form action="registraamministratore.php" method="post">
                
            <label for="nomeutente">Nome utente:</label><br>    
            <input type="text" name="nomeutente">
            
            <br><br>
            
            <label for="password">Password:</label><br>
            <input type="text" name="password">
            
            <br><br>
            
            <input type="submit" name="registra_amministratore" value="registra amministratore">
                
            </form>
            
            
            
        </body>
        
        
    </html>
    
    
    
<?php } else {
    echo 'non hai i permessi per visitare questa pagina';
}


?>