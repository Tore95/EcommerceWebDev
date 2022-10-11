
<html>

<head>
  <title>Pagina test</title>
  
</head>
<body>
  <h1>Test Json</h1>
  <p id="dati"></p>
  <script>
    //Js here
    const username = "Giovanna";
    const password = "abc";

    //passare i dati al backend
    let formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    fetch('jsontest.php', {
        method: 'POST',
        body: formData
      })
      //leggere la risposta => inserire la risposta in delle variabili js
      .then(risposta => risposta.json())
      .then(messaggio => {
        console.log(messaggio);
        document.getElementById('dati').innerText = messaggio.nome + " " + messaggio.email;
      });
  </script>
</body>

</html>