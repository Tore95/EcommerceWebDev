

<?php 

if (isset($_POST['login'])) {
  $nome = $_POST['nome'];
  $mail = $_POST['email'];
}

if (isset($_GET['nome'])) {
  $nome_get = $_GET['nome'];
}

?>

<html>
  <head>
    <title>Pagina test</title>
    <script>
      function miaFunzione(nome) {
        const msg = document.getElementById('benvenuto');
        msg.innerText += nome;
      }
    </script>
  </head>  
    <body <?php if(isset($nome)) { ?> onload="miaFunzione('<?php echo $nome; ?>')" <?php } ?>>
        <h1>TEST</h1>
        <h2 id="benvenuto">Benvenuto Post: </h2>
        <h2>Benvenuto Get: <?php if (isset($nome_get)) echo $nome_get; else echo 'nessun parametro'?></h2>
        <form action="test.php" method="post">
          <label for="nome">nome utente</label>
          <input type="text" name="nome">
          <label for="email">email</label>
          <input type="email" name="email">
          <input type="submit" name="login">
        </form>
        <hr>
        <a href="test.php?nome=ciccio">Saluta ciccio</a>
    </body>
</html>




