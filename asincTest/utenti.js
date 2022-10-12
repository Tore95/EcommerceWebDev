//Fase di progettazione del codice

class Utente {
    constructor(nome, password, mail, ruolo) {
        this.nome = nome;
        this.password = password;
        this.mail = mail;
        this.ruolo = ruolo;
    }

    generaElementoHtml() {
        /*
        Template elemento:
        <tr>
            <td>nome</td>
            <td>password</td>
            <td>mail</td>
            <td>ruolo</td>
        </tr>
        */

        let riga = document.createElement('tr');

        let nome = document.createElement('td');
        nome.innerText = this.nome;

        let password = document.createElement('td');
        password.innerText = this.password;

        let mail = document.createElement('td');
        mail.innerText = this.mail;

        let ruolo = document.createElement('td');
        ruolo.innerText = this.ruolo;

        riga.append(nome, password, mail, ruolo);

        return riga;

    }
}

function visualizzaUtenti(listaUtenti) {
    const tabella = document.getElementById('tabella');
    tabella.innerHTML = '';
    for (utente of listaUtenti) {
        tabella.appendChild(utente.generaElementoHtml());
    }
}

function recuperaListaUtenti(tipo) {
    //Prendere la lista dal DB
    let lista = [];

    let formData = new FormData();
    formData.append('users',tipo);

    fetch('utenti_api.php', {
        method: "POST",
        body: formData
    })
    .then(risposta => risposta.json())
    .then(dati => {
        console.log(dati);
        for (elemento of dati) {
            lista.push(new Utente(
                elemento.nome_utente,
                elemento.password,
                elemento.email,
                elemento.ruolo
            ));
        }
        visualizzaUtenti(lista);
    });
}

function filtroUtenti() {
    const tipoSelezionato = document.getElementById('tipo').value;
    recuperaListaUtenti(tipoSelezionato);
}

//Fase di esecuzione del codice

recuperaListaUtenti('all');