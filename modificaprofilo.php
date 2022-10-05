<?php

session_start();

if (isset($_SESSION['idutente'])){


?>


<?php

require("config.php");

$id = $_SESSION['idutente'];

$risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE id=$id LIMIT 1");

while ($array= mysqli_fetch_array($risultato)){
    
    $nomeutente = $array['nome_utente'];
    $password = $array['password'];
    $ruolo = $array['ruolo'];
    
}


?>



<?php

if(isset($_POST['conferma_modifiche'])){
    
    
$nuovonomeutente = $_POST['nomeutente'];
$nuovapassword = $_POST['password'];
$nuovoruolo = $_POST['ruolo'];
    
$nomeutenteesistente = 0;

//richiesta dati al database per il controllo

$risultato = mysqli_query($mysqli, "SELECT * FROM utenti WHERE nome_utente = '$nuovonomeutente'");


while($array = mysqli_fetch_array($risultato)){
    
    if ($array['id'] != $_SESSION['idutente']){
        
        $nomeutenteesistente = 1;
        
        
    }
    
}



if ($nomeutenteesistente == 0){

$risultato = mysqli_query($mysqli, "UPDATE utenti SET nome_utente='$nuovonomeutente', password='$nuovapassword' , ruolo='$nuovoruolo' WHERE id=$id");

echo 'dati modificati correttamente, <a href="benvenuto.php">torna indietro</a>';

 $nomeutente = $nuovonomeutente;
    $password = $nuovapassword;
    
    $ruolo = $nuovoruolo;
    
    $_SESSION['nome'] = $nuovonomeutente;
    $_SESSION['ruolo'] = $nuovoruolo;
    
} else {
    
    echo 'questo nome utente esiste già, scegline un altro';
}
    
}


?>


<html>
    
    <head>
        
        
        <title>Modifica profilo</title>
    
    
    </head>
    
    <body style="text-align:center">
        
        
        <form action="modificaprofilo.php" method="post">
            
            <label for="nomeutente">Nome utente</label><br>
            <input type="text" name="nomeutente" value="<?php echo $nomeutente ?>">
            
            <br><br>
            <label for="password">Password</label><br>
            <input type="text" name="password" value="<?php echo $password ?>"> 
            
            
            
            <?php
            
            if ($ruolo==='amministratore'){
            
            ?>
            <br><br>
            <select name="ruolo" id="ruolo">
          
            
            <?php
            
            if ($ruolo ==='amministratore'){
                
                echo '<option value="amministratore">Amministratore</option>';
                echo '<option value="utente">Utente</option>';
                
            } else {
                echo '<option value="utente">Utente</option>';
                echo '<option value="amministratore">Amministratore</option>';
            }
            
            ?>
            
            </select>
            
            <?php }?>
            
            <br><br>
            
            <input type="submit" value="conferma modifiche" name="conferma_modifiche">
            
        </form>
        
        
    </body>
    
    
</html>


<?php } else {
    
    header("Location: ../login/accedi.php");
}

?>