<?php

require("config.php");
require("classi/classiecommerce.php");
?>



<?php

$prodottodamodificare = new prodotto ();

$prodottodamodificare -> selezionaprodotto(21,$mysqli,'prodotti');

$array = $prodottodamodificare -> stampaprodotto();

echo "stai modificando l'immagine del prodotto: <br>";

echo $array['nome'];

echo '<br><br>';




if (isset($_POST['invia'])){
    
    $prodottodamodificare ->modificaimmagine($_FILES['filecaricato']);
    
    if ($prodottodamodificare->popolato()==true){
        
        echo 'immagine caricata correttamente';
        
        $prodottodamodificare ->inserisci_database($mysqli,'prodotti');
        
    }
    
}

?>



<html>
    
    <head>
        
        <title>Modifica Immagine</title>
        
    </head>
    
    <body style="text-align:center;">
        
        
        <form action="modificaimmagine.php" method="post" enctype="multipart/form-data">
            
            
            <input type="file" name="filecaricato" id="filecaricato">
            
            <br><br>
            
            <input type="submit" name="invia" value="carica immagine">
            
            
        </form>
        
        
    </body>
    
</html>