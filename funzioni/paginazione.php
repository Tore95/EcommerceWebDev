<?php

function paginazione ($pagina, $risultati_per_pagina, $database, $query) {
    
    
if(!isset ($pagina)){
    $pagina = 1;}


//definisco il risultato della lista da cui partire rispetto alla pagina su cui mi trovo
$risultati_pagina_corrente = ($pagina-1) * $risultati_per_pagina;



//selezionare tutti i dati del database che corrispondono a quello che intendo fare vedere nella tabella corrente
$risultato = mysqli_query($database, $query);

$numero_di_risultati = mysqli_num_rows($risultato);



//determino quante pagine saranno necessarie per mostrare tutti i risultati tramite una operazione matematica di divisione
$numero_di_pagine_totali = ceil($numero_di_risultati / $risultati_per_pagina);



// OUTPUT ---------------

$array = array(
    
    'risultati_pagina_corrente' => $risultati_pagina_corrente,
    'risultati_per_pagina' => $risultati_per_pagina,
    'numero_di_pagine_totali' => $numero_di_pagine_totali
    
    );
    
    
return $array;


    
}

?>