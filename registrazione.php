<?php
session_start();

if(isset($_SESSION['nome'])){
 
 header("Location: ../login/benvenuto.php");
    
}else{

?>

<?php

require("config.php");

if (isset($_POST['iscriviti'])){
    

//dobbiamo controllare che il nome utente scelto in questo momento non sia già presente nel nostro database

$nuovonomeutente = $_POST['nomeutente'];
$nuovamail = $_POST['email'];
$nuovapassword = $_POST['password'];

$risultato = mysqli_query($mysqli, "SELECT * FROM utenti");

$utenteesistente = 0;

while($array = mysqli_fetch_array($risultato)){
    
    if ($array['nome_utente'] === $nuovonomeutente){
        $utenteesistente = 1;
    }
    
}


if ($utenteesistente == 1){
    echo 'il nome utente esiste già, scegline un altro';
} else {
        
$risultato = mysqli_query($mysqli, "INSERT INTO utenti(nome_utente,password,email,ruolo) VALUES ('$nuovonomeutente','$nuovapassword','$nuovamail','utente')");

echo 'utente registrato correttamente';
echo '<br>';
echo '<a href="accedi.php">Vai alla pagina di accesso</a>';
}
    
}

?>


<html>
    
    <head>
        
        <title>Registrati</title>
        
    </head>
    
    
    <body style="text-align:center;">
        
     <h2>Registra il tuo account</h2>
     
     <form action="registrazione.php" method="post">
         
         
         <label for="nomeutente">Inserisci il nome utente</label><br>
         <input type="text" name="nomeutente">
         
         <br><br>

         <label for="email">Inserisci una email</label><br>
         <input type="text" name="email">
         
         <br><br>
         
         <label for="password">Inserisci una password</label><br>
         <input type="text" name="password">
         
         <br><br>
         
         <input type="submit" name="iscriviti" value="iscriviti">
         
         
     </form>
        
        
    </body>
    
</html>

<?php } ?>