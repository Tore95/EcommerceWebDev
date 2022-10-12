class Prodotto {
    constructor(id, nome, img, descr, prezzo) {
        this.id = id;
        this.nome = nome;
        this.img = img;
        this.descr = descr;
        this.prezzo = prezzo;
    }

    //Voglio che restituisce l'elemento HTML del prodotto
    getHtmlElementOld() {
        let cardProdotto = document.createElement('table');

        let row = document.createElement('tr');
        let colImg = document.createElement('td');
        let colInfo = document.createElement('td');

        let img = document.createElement('img');
        img.setAttribute('alt', this.nome);
        img.setAttribute('src', this.img);
        
        "<td></td>"
        colImg.appendChild(img);
        "<td><img .....></td>"

        var titolo = document.createElement('h1');
        titolo.innerText = this.nome;

        var descrizione = document.createElement('p');
        descrizione.innerText = this.descr;

        var prezzo = document.createElement('h2');
        prezzo.innerText = this.prezzo + " €";

        var bottone = document.createElement('input');
        bottone.setAttribute('type', 'button');
        bottone.setAttribute('value', "Aggiungi al carrello");
        bottone.setAttribute('onclick', `aggiungiAlCarrello('${this.id}')`);
        bottone.setAttribute('name', this.nome + " Aggiungi al carrello");

        colInfo.append(titolo, descrizione, prezzo, bottone);

        row.append(colImg, colInfo);

        cardProdotto.appendChild(row);

        return cardProdotto;
    }

    getHtmlElement() {
        let cardProdotto = document.createElement('div');
        cardProdotto.classList.add('col', 'card');
        cardProdotto.innerHTML = 
        `
        <img src="${this.img}" class="card-img-top" alt="${this.nome}">
        <div class="card-body">
            <h5 class="card-title">${this.nome}</h5>
            <p class="card-text">${this.descr}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Prezzo: ${this.prezzo}€</li>
        </ul>
        <div class="card-body">
            <a href="#" onclick="aggiungiAlCarrello('${this.id}')" class="btn btn-dark">Aggiungi al carrello</a>
        </div>
        </div>
        `
        return cardProdotto;
    }
}

class Carrello {
    constructor() {
        this.prodotti = [];
    }

    createRowCarrello(prodotto) {
        let row = document.createElement('tr');
        let colName = document.createElement('th');
        colName.setAttribute('scope','row');
        let colPrez = document.createElement('td');
        colName.innerText = prodotto.nome;
        colPrez.innerText = prodotto.prezzo;
        row.append(colName,colPrez);
        return row;
    }

    aggiungi(prodotto) {
        const carrelloHtml = document.getElementById('carrello');
        this.prodotti.push(prodotto)
        let htmlProdotto = this.createRowCarrello(prodotto);
        carrelloHtml.appendChild(htmlProdotto);
    }

    ottieniTotalePrezzi() {
        let totale = 0;
        this.prodotti.forEach(p => totale += p.prezzo);
        return totale;
    }

    svuota() {
        //Svuotare il carrello logico
        this.prodotti = [];
        const carrelloHtml = document.getElementById('carrello');

        //Svuotare il carrello grafico
        const max = carrelloHtml.childElementCount;
        for (let i = 0; i < max ; i++) {
            carrelloHtml.removeChild(carrelloHtml.lastElementChild)
        }
        
    }
}

class Ordine {
    constructor(numero, prodotti, totale) {
        this.numero = numero;
        this.prodotti = prodotti;
        this.totalePrezzo = totale;
        this.data = new Date();
    }

    getHtmlElement() {
        let htmlElement = document.createElement('div');
        htmlElement.classList.add('accordion-item');

        let tabellaProdottiHtml = "";
        this.prodotti.forEach(p => {
            tabellaProdottiHtml += `<tr>
            <td>${p.nome}</td>
            <td>${p.descr}</td>
            <td>${p.prezzo}€</td>
          </tr>`
        });
        let html = `
        <h2 class="accordion-header" id="${this.numero}">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${this.numero}" aria-expanded="false" aria-controls="collapse${this.numero}">
            Ordine numero: #${this.numero}
          </button>
        </h2>
        <div id="collapse${this.numero}" class="accordion-collapse collapse" aria-labelledby="${this.numero}" data-bs-parent="#storicoOrdini">
          <div class="accordion-body mb-3">
            <h4>Ordine numero: #${this.numero}</h4>
            <p>Data acquisto: ${this.data}</p>
            <table class="table">
              <thead>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Prezzo</th>
              </thead>
              <tbody>
                ${tabellaProdottiHtml}
              </tbody>
            </table>
            <h6 class="float-end">Totale prezzo ordine: ${this.totalePrezzo}€</h6>
          </div>
        </div>
      `
      htmlElement.innerHTML = html;
      return htmlElement;
    }
}

class Utente {
    constructor(nome, mail) {
        this.nome = nome;
        this.mail = mail;
        this.saldo = 0;
        this.carrello = new Carrello();
        this.ordini = [];
        this.seed = 0;
    }

    ricarica(euro) {
        this.saldo += euro;
    }

    aggiungi(prodotto) {
        this.carrello.aggiungi(prodotto)
    }

    generaNumeroOrdine() {
        this.seed += 1;
        return this.seed;
    }

    acquista() {
        //verifica che il carrello non sia vuoto
        if (this.carrello.prodotti.length === 0) {
            alertMessage("Attenzione","Il carrello è vuoto","rosso");
            return;
        }

        //Verifica il saldo
        const prezzoTotale = this.carrello.ottieniTotalePrezzi();
        if (prezzoTotale > this.saldo) {
            //Avvisa che non c'è abbastanza credito
            alertMessage("Attenzione!", `Non hai abbastanza saldo, il saldo disponibile è ${this.saldo}€`,'rosso');
        } else {
            //Procere all'acquisto
            this.ordini.push(new Ordine(this.generaNumeroOrdine(),this.carrello.prodotti, prezzoTotale));
            this.carrello.svuota();
            this.saldo -= prezzoTotale;
            alertMessage("Acquisto effettuato con successo", "Complimenti hai acquistato i prodotti", "verde");
        }
    }
}

var prodotti = [
    new Prodotto(1, "Pizza","risorse/pizza.webp","pomodoro, mozzarella", 6),
    new Prodotto(2, "Hamburger", "risorse/hamburger.jpg", "Classico con Bacon", 10),
    new Prodotto(3, "Patatine", "risorse/patatine.jpg", "Patate con ketchup e majo", 2.5),
    new Prodotto(4, "Birra", "risorse/birra.png", "Birra 5 luppoli", 3)
];

const prodottiHtml = document.getElementById('listaProdotti');
prodotti.forEach(p => prodottiHtml.appendChild(p.getHtmlElement()));


let currentUser = new Utente("Gianni", "gianni89@gmail.com");
aggiornaInfoProfilo();


function aggiornaInfoProfilo() {
    const msgBenvenuto = document.getElementById('welcome');
    msgBenvenuto.innerText = "Benvenuto: " + currentUser.nome;

    //Aggiorna totale carrello
    const prezzoHtml = document.getElementById('totaleCarrello').innerText = currentUser.carrello.ottieniTotalePrezzi();

    //Aggiorna le use info
    const useInfoTable = document.getElementById('userInfo');
    useInfoTable.innerHTML = 
    `
    <tr>
        <th scope='row'>Nome:</th>
        <td>${currentUser.nome}</td>
    </tr>
    <tr>
        <th scope='row'>Mail:</th>
        <td>${currentUser.mail}</td>
    </tr>
    <tr>
        <th scope='row'>Saldo:</th>
        <td>${currentUser.saldo}</td>
    </tr>
    `;

    //Aggiorno gli ordini
    const accordionOrdini = document.getElementById('storicoOrdini');
    accordionOrdini.innerHTML = "";
    currentUser.ordini.forEach( ord => {
        accordionOrdini.appendChild(ord.getHtmlElement());
    });

}


function aggiungiAlCarrello(id) {
    let prodotto = prodotti.find(p => p.id == id);
    currentUser.aggiungi(prodotto);
    const prezzoHtml = document.getElementById('totaleCarrello');
    prezzoHtml.innerText = currentUser.carrello.ottieniTotalePrezzi();
}

function paga() {
    currentUser.acquista();
    aggiornaInfoProfilo();
}

function ricaricaConto() {
    let inputField = document.getElementById('ricarica');
    let valore = inputField.value;
    let euro = Number.parseInt(valore);
    currentUser.ricarica(euro);
    inputField.value = null;
    aggiornaInfoProfilo();
}

function alertMessage(titolo, contenuto, colori) {
    const alertTitle = document.getElementById('alertModalLabel');
    const alertText = document.getElementById('alertMessage');
    const alertState = document.getElementById('alertState');
    const alertModal = new bootstrap.Modal('#alertModal');

    alertTitle.innerText = titolo;
    alertText.innerText = contenuto;

    alertState.classList.remove('alert-success');
    alertState.classList.remove('alert-danger');

    switch (colori) {
        case 'verde': alertState.classList.add('alert-success'); break;
        case 'rosso': alertState.classList.add('alert-danger'); break;
    }

    alertModal.show();
}