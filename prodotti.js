let formData = new FormData();
formData.append('prodotti',2);

fetch('prodotti.php', {
    method: "POST",
    body: formData
})
.then(risposta => risposta.json())
.then(listaProdotti => {
    console.log(listaProdotti);
    const listaHtml = document.getElementById('prodotti');
    for (p of listaProdotti) {
        let elementoHtml = document.createElement('li');
        elementoHtml.innerText = p.nome_prodotto;
        listaHtml.appendChild(elementoHtml);
    }
});