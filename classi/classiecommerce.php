<?php

class prodotto {
    
    // proprietà (caratteristiche)
    
    public $nome;
    public $descrizione;
    public $categoria;
    public $prezzo;
    public $immagine;
    public $id;
    
    //metodi
    
    function aggiungidati ($nome, $descrizione,$categoria,$prezzo,$immagine){
        
        
        // area di controllo
        
        $controllo = true;
        
        if (!is_numeric($prezzo)){
            $controllo = false;
        }
        
        if (empty($nome)){
            $controllo = false;
        }
        
        if (empty($descrizione)){
            $controllo = false;
        }
        
        if (empty($categoria)){
            $controllo = false;
        }
        
        // fine area di controllo
        
        
        if ($controllo){
        
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->categoria = $categoria;
        $this->prezzo = $prezzo;
    
        //caricamento immagine
        
        $percorso = "immagini_prodotto/";
        
        $percorso_definitivo = $percorso . basename($immagine['name']);
        
       move_uploaded_file($immagine['tmp_name'],$percorso_definitivo);
       
       $this->immagine = $percorso_definitivo; 
        
        //caricamento immagine fine
        
        
    }
    }
    
    
    function popolato(){
        
        $stato = true;
        
        if (empty($this->nome)){
            $stato = false;
        }
        
        
        if (empty($this->descrizione)){
            $stato = false;
        }
        
        
        if (empty($this->categoria)){
            $stato = false;
        }
        
        
        if (empty($this->prezzo)){
            $stato = false;
        }
        
        
        if (empty($this->immagine)){
            $stato = false;
        }
        
        
    
    return $stato;    
    
    }
    
    function inserisci_database($database, $tabella){
        
        if (empty($this->id)){
        
    $risultato = mysqli_query($database, "INSERT INTO $tabella (nome_prodotto,descrizione_prodotto,categoria_prodotto,prezzo,immagine) VALUES ('$this->nome','$this->descrizione','$this->categoria','$this->prezzo','$this->immagine')");
        } else {
            
        $id = $this->id;
            
        $risultato = mysqli_query($database, "UPDATE $tabella SET nome_prodotto='$this->nome',descrizione_prodotto='$this->descrizione',categoria_prodotto='$this->categoria',prezzo='$this->prezzo', immagine='$this->immagine' WHERE id=$id");
            
        }   
    }
    
    function mostraimmagine(){
        
        return $this->immagine;
        
    }
    
    function selezionaprodotto($id,$database,$tabella){
        
        $risultato = mysqli_query($database, "SELECT * FROM $tabella WHERE id = $id LIMIT 1");
        
        while ($array = mysqli_fetch_array($risultato)){
            
            $this -> nome = $array['nome_prodotto'];
            $this -> descrizione = $array['descrizione_prodotto'];
            $this ->categoria = $array['categoria_prodotto'];
            $this ->prezzo = $array['prezzo'];
            $this ->immagine = $array['immagine'];
            $this -> id = $array['id'];
            
        }
        
    }
    
    function stampaprodotto(){
        
        $array = array(
            
            "nome" => $this->nome,
            "descrizione" => $this->descrizione,
            "categoria" => $this->categoria,
            "prezzo" => $this->prezzo,
            "immagine" => $this ->immagine
            
            );
            
        return $array;
        
    }
    
    function eliminaprodotto($id, $database, $tabella){
        
        $risultato = mysqli_query($database, "SELECT * FROM $tabella WHERE id=$id LIMIT 1");
        
        if(mysqli_num_rows($risultato) > 0){
        
        $link = "";
        
        while($array = mysqli_fetch_array($risultato)){
            
            $link = $array['immagine'];
            
        }
        
        
        unlink($link);
        
        
        
        $risultato = mysqli_query($database, "DELETE FROM $tabella WHERE id=$id");
        
    }
    }
    
    function modificadati($nome,$descrizione,$categoria,$prezzo){
        
        $controllo = true;
        
        if(empty($nome)){
            $controllo =false;
        }
        
        if (empty($descrizione)){
            $controllo = false;
        }
        
        if (empty($categoria)){
            $controllo = false;
        }
        
        if (!is_numeric($prezzo)){
            $controllo = false;
        }
        
        
        
        if ($controllo = true){
            
            $this->nome = $nome;
            $this->descrizione = $descrizione;
            $this->categoria = $categoria;
            $this-> prezzo = $prezzo;
      
            
        }
        
        
        
    }
    
    
    function modificaimmagine ($immagine){
        
        $percorso = "immagini_prodotto/";
        
        $percorso_definitivo = $percorso . basename($immagine['name']);
        
        move_uploaded_file($immagine['tmp_name'], $percorso_definitivo);
        
        $this ->immagine = $percorso_definitivo;
        
    }
    
    
}



class carrello {
    
    public $contenuto = [];
    public $idclientecorrente = "";
    
    function __construct($idcliente) {
        
       $this->idclientecorrente = $idcliente; 
        
    }
    
    
function aggiungiacarrello ($idprodotto){
    
    array_push($this->contenuto, $idprodotto);
    
}

function costruiscicarrello($database){
    

    $array = $this->contenuto;

    $arrayconfronto = [];

    $prodotti_carrello = [];

    foreach ($array as $singoloelemento) {


        $flag = true;
        foreach ($arrayconfronto as $elementoarrayconfronto) {

            if ($elementoarrayconfronto === $singoloelemento) {

                $flag = false;
            }
        }

        if ($flag) {
            $conteggio = 0;
            foreach ($array as $confronto) {
                if ($confronto === $singoloelemento) {
                    $conteggio = $conteggio + 1;
                }
            }



            $risultato = mysqli_query($database, "SELECT * FROM prodotti WHERE id=$singoloelemento LIMIT 1");

            $elementodatabase = mysqli_fetch_array($risultato);
            
            array_push($arrayconfronto, $elementodatabase['id']);
            
            

            $elementodatabase['conteggio'] = $conteggio;
            array_push($prodotti_carrello, $elementodatabase);
        }
    }
    
    return $prodotti_carrello;
    
}


function svuotacarrello(){
    
    $this->contenuto = [];
    
}


function eliminadacarrello ($elementodaeliminare) {
    
   $array = $this->contenuto;
   
   $conteggioelementi = count($array);
   
   for ($x=0; $x <= $conteggioelementi; $x++){
       
       if ($array[$x] === $elementodaeliminare){
           
           unset($array[$x]);
           
       }
       
   }
   
   $this->contenuto = $array;
    
}

    
}


?>