<?php
session_start();

if ($_SESSION['ruolo']==='utente' OR empty($_SESSION)){

?>

<?php



if (isset($_SESSION['nome'])){
    
    echo 'Benvenuto, ';
    echo $_SESSION['nome'];
    echo ' con id: ';
    echo $_SESSION['idutente'];
    echo '<br>';
    echo '<a href="logout.php">Disconnettiti</a>';
    echo '<br><br>';
    echo '<a href="modificaprofilo.php">Modifica profilo</a>';
    
} else {
    echo 'Non hai ancora effettuato il login';
    echo '<br>';
    echo $_SESSION['nome'];
    echo '<a href="accedi.php">Clicca qui per accedere</a>';
}

?>

<?php } else if ($_SESSION['ruolo']==='amministratore') {
    
    header("Location: ../login/benvenutoadmin.php");

}
?>