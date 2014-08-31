# Gamespot - Progetto di Tecnologie del Web

## Andrea Leopardi (matr. 202879)
#### <an.leopardi@gmail.com>
### Università degli Studi di L'Aquila, a.a. 2013/2014

In questa breve relazione verranno evidenziate le scelte effettuate e le
tecnologie utilizzate durante lo sviluppo del progetto.

Tutto il codice del progetto, comprendente la storia del suo sviluppo, i
problemi riscontrati e le soluzioni trovate è hostato [su GitHub][repo].

Il progetto è invece disponibile all'indirizzo
[tdw.andrealeopardi.com][project-website].

Tutto il codice PHP presente nel progetto è stato documentato in modo da poter
generare automaticamente documentazione tramite il tool [phpdoc][phpdocumentor].
La suddetta documentazione è disponibile all'indirizzo
[tdw.andrealeopardi.com/docs][project-docs].

**Nota**: per la natura del sito (un sito di annunci), viene spesso usata la
parola *ad* nel codice. Se il browser utilizzato possiede un qualche tipo di
meccanismo anti-pubblicità (come AdBlock), esso va disabilitato in quanto
elementi che contengono parole legate ad *ad* vengono nascosti all'utente.

## Il sito

Il sito scelto di realizzare è un mercatino virtuale di videogiochi, in cui
possono essere pubblicati annunci sulla vendita di videogiochi e accessori per
console.

Il sito comprende diverse funzionalità:

- Utenza generica: sono presenti utenti registrati che possono creare annunci e
    contattare altri utenti che hanno pubblicato annunci (tramite il sito).
- Gli utenti possono:
    * registrarsi (con email di conferma e condice univoco di conferma)
    * loggarsi
    * manipolare il proprio profilo (foro profilo, password, informazioni
        personali)
    * recuperare la password in caso di smarrimento
    * creare annunci
    * contattare altri utenti del sito
- Backend: nel sito è presente un'utenza di backend, formata da membri dello
    staff che fanno parte di gruppi. Ai gruppi sono assegnati permessi e in
    questo modo si ripartiscono i compiti nel backend.
- I membri dello staff possono:
    * inserire nel database videogiochi, accessory e console;
    * creare post sul blog del sito
    * bloccare/sbloccare ed eliminare utenti del sito
    * gestire gruppi e permessi
    * creare nuovi membri dello staff (solo per amministratori con permessi
        illimitati)
- Statistiche: i membri dello staff hanno a disposizione una serie di
    statistiche sul sito, come numero di utenti online, numero di annunci in
    totale, numero di visite, numero di visitatori unici e altro.
- Supporto tecnico: il sito comprende una funzionalità di "Supporto", tramite la
    quale gli utenti possono contattare lo staff del sito per problemi tecnici,
    lamentele e bug report.


## Struttura del codice

Il sito è stato sviluppato seguendo il più possibile un'architettura MVC: il
codice è suddiviso (con l'aiuto dei *namespaces* PHP) in *models*, *controllers*
e template Smarty (*views*).

I models si occupano di dialogare con il database e forniscono un livello
(abbastanza semplice) di ORM (object-relational mapping), trasformando risultati
di query in oggetti PHP e viceversa. C'è un ulteriore livello di astrazione tra
i model e il database MySQL, ossia la classe `Common\Db`: essa si occupa di
connettersi al database ed effettuare le query vere e proprie (gestendo anche
gli errori).

I controllers si occupano di gestire la comunicazione con i model, selezionare i
dati da mostrare all'utente e renderizzare le view.

Le view (nient'altro che template Smarty) sono la parte mostrata all'utente.
Ogni elemento visualizzato dall'utente (dal contenuto delle email inviate dal
sito alle pagine stesse del sito) è inizialmente una view che al momento
opportuno viene renderizzata da un controller.

### Analisi delle classi

Segue una breve descrizione della funzionalità delle classi PHP create.

##### Namespace `Common`

- `GamespotSmarty`: eredita da `Smarty` e ne aumenta le
    funzionalità e personalizza le configurazioni.
- `Gravatar`: si occupa di dialogare con l'API di [Gravatar][gravatar].
- `Mailer`: è un wrapper intorno alla classe `PHPMailer`, utilizzata per
    inviare email dal sito agli utenti.
- `Router`: si occupa di scegliere il controller e l'action da eseguire a
    partire da un dato url. Fornisce anche una funzionalità di protezione degli
    url, tramite la quale permette di specificare una serie di url (tramite
    espressioni regolari) che possono essere visitati solo dopo aver effettuato
    il log in.
- `Session`: è un wrapper intorno a `$_SESSION`, che fornisce
    soprattutto metodi di convenienza per interagire con la sessione.
- `Uploader`: gestisce l'uploading di file sul server.

##### Namespace `Http`

- `Request`: è un'astrazione di una richiesta HTTP. Consente di accedere con
    facilità al metodo di richiesta utilizzato (GET, POST etc.), ai parametri di
    richiesta (una fusione tra i parametri GET e POST), all'indirizzo IP del
    mittente della richiesta e agli headers di richiesta HTTP.
- `Response`: è un'astrazione di una risposta HTTP. Permette di operare sulla
    risposta, ad esempio impostando lo *status code* di risposta.

##### Namespace `Models`

La classe principale in questo namespace è proprio la classe `Model`, da cui
ereditano tutti i modelli nel sito.

Questa classe fornisce una serie di metodi per mappare oggetti PHP a dati nel
database. Se ne illustrano alcuni:

- `Model::where()`: permette di effettuare ricerche nel database (query `WHERE`)
    con una syntassi PHP-friendly, prendendo un array nella forma `colonna =>
    valore` come argomento.
- `Model::create()` e `Model::update()`: permettono di creare e aggiornare un
    record con una sintassi simile a quella di `Model::where()`.
- `Model::find()`: permette di trovare un record in base al suo id.
- `Model::destroy()`: permette di eliminare un record in base al suo id.

La classe `Model` è responsabile anche della validazione dei modelli: è questo
lo scopo del metodo `validate()`, che viene sovrascritto in ogni classe che
eredita da `Model` in modo da effettuare validazioni ad hoc per ogni modello.

In ultimo, nella classe model sono stati definiti i metodi `__get` e `__set`,
metodi "speciali" PHP che permettono di accedere agli attributi dei record con
una sintassi idiomatica di PHP:

``` php
$user = User::find(3);
$user->email; // ritorna l'email dell'utente
```

##### Namespace `Controllers`

La classe principale in questo namespace è la classe `Controller`, da cui
ereditano tutti gli altri controller.

Questa classe fornisce una serie di funzionalità utili:

- *Dispatch* dinamico delle action: il nome della action (un semplice metodo) da
    eseguire viene dedotto direttamente da Apache quando viene letto l'url della
    richiesta.
- Flash: il *flash* è un meccanismo ispirato dal web framework Ruby on Rails
    tramite il quale è possibile salvare nella sessione dei messaggi che restano
    nella sessione fino alla richiesta successiva. È estremamente utile per
    comunicare errori o conferme all'utente, e viene usato estensivamente in
    tutto il sito.
- Render dei template: quando viene renderizzato un template, ad esso vengono
    passate tutte le *instance variables* non protette del controller, in modo
    da poter semplificare il codice delle action e suddividerlo in più metodi,
    manipolando sempre le stesse *instance variables*.
- Filtri before/after: anche questa funzionalità è ispirata a una funzionalità
    analoga presente nel framework Ruby on Rails. Per ogni controller possono
    essere definiti dei metodi da eseguire prima e dopo delle specifiche azioni:
    questa funzionalità viene utilizzata per restringere l'accesso ai membri
    dello staff autorizzati nelle azioni dei controllers, per svolgere
    operazioni comuni (come query nel database) a più azioni e per renderizzare
    template di default dopo una action se il flusso di esecuzione non è stato
    interrotto precedentemente.

#### Funzioni

In ultimo, sono state scritte diverse funzioni *helper* contenute nel file
`app/functions.php`. Queste funzioni svolgono task variegati, ma la maggior
parte si concentra sul fornire metodi che aiutano la programmazione funzionale
in PHP (manipolando collezioni di elementi -- ovvero array).  
Se si vuole conoscere di più su queste funzioni, la documentazione è disponibile
all'indirizzo
[tdw.andrealeopardi.com/docs/namespaces/default.html][project-functions-docs].

### JavaScript

JavaScript è stato utilizzato per rifinire alcuni aspetti del sito.

- `data-confirm`: l'evento `click` di ogni elemento HTML che ha l'attributo
    `data-comfirm` viene intercettato in modo da poter chiedere una conferma
    all'utente (tramite una chiamata alla funzione JS `confirm()`) e annullare
    l'evento in caso di rifiuto.
- `data-back`: gli elementi con l'attributo `data-back` sono link che tornano
    indietro nella *history* del browser, simulando il click sul pulsante *Back*
    da parte dell'utente.
- `data-ago`: ogni elemento con l'attribute `data-ago` viene trasformato da un
    timestamp a un "orario human-friendly" (come "12 hours ago" o "last month"),
    grazie alla libreria [Moment.js][momentjs].
- `data-hoverable`: tag `<img>` con questo attributo (che contiene l'url di
    un'immagine) cambiano immagine quando hoverate. Questo comportamento può
    essere osservato nel logo del sito.


### Dall'inizio della richiesta HTTP alla ricezione del documento HTML

A seguire si illustra in breve il comportamento del codice sviluppato a partire
dall'arrivo della richiesta al server fino alla risposta del server all'utente:
questa descrizione aiuterà a capire come tutti i componenti del sistema
interagiscono.

Quando la richiesta arriva al server (Apache), una direttiva Apache nel file
`.htaccess` provvede a parsare il path di richiesta ed estrarre tre componenti:
il nome del controller, il nome della action e se ci troviamo o no nel backend.

Apache esegue (con questi parametri) il file `index.php`, che:

- include tutte le librerie utilizzate, le classi sviluppate e costanti e
    configurazioni,
- inizializza la sessione,
- connette la classe `Db` al database,
- invoca un metodo di *dispatching* della classe `Router` con le informazioni
    ottenute da Apache.

Il router provvede a verificare che il controller esista (altrimenti ritorna un
404 Not Found) e successivamente istanzia una nuova istanza di quel controller
comunicando a quest'ultimo la action da eseguire. Il router provvede anche a
verificare che ci sia un utente in sessione se l'url richiesto matcha uno degli
url definiti come "autenticati".

Il controller si occupa a questo punto di verificare che la action richiesta
esista, e subito dopo di raccogliere informazioni utili dalla sessione, come ad
esempio l'utente loggato (se ce n'è uno).  
A questo punto il controller esegue tutti i *before filters* assegnati
all'azione richiesta.
Subito dopo viene eseguita l'azione e tipicamente vengono settate variabili
d'istanza da passare al template Smarty e viene renderizzata una pagina HTML.
Il rendering comporta la fine dell'esecuzione del codice.  
Se il flusso non viene interrotto durante l'azione, vengono eseguiti in sequenza
tutti gli *after filters* assegnati all'azione.

## Tecnologie utilizzate

### Librerie JavaScript

- Moment.js: manipola date e orari.
- Dropzone: permette di uploadare immagini tramite drag&drop (utilizzato nella
    creazione degli annunci).
- jQuery Chosen: render i tag `<select>` più user-friendly.
- Selectize: genera ibridi tra `<input>` e `<select>`.
- Froala editor: un editor WSIWYG per jQuery.

### Sass

[Sass][sass] è un preprocessore che genera CSS a partire da un superset di CSS.
Esso permette di utilizzare costrutti estranei al CSS, come variabili, loop,
statement condizionali, nesting delle regole CSS e molto altro.

## Testing

Durante lo sviluppo è stato sviluppato codice di testing parallelamente al
codice del sistema. Per ragioni di tempo il codice di testing sviluppato è solo
*unit testing* e si concentra dunque soltanto sui models (in particolare sulla
classe `Model`).

## Stile

Lo stile del sito è stato disegnato da zero, utilizzando soltanto l'aiuto del
framework CSS [Foundation][foundation].


## Visitare il sito

Segue una serie di credenziali utili per testare le funzionalità del sito:

- **Utente regolare**: basta registrarsi alla pagina
    [tdw.andrealeopardi.com/users/sign_up][project-signup] come nuovo utente.
- **Amministratore del sito**: per testare *tutte* le funzionalità del sistema basta
    loggarsi come amministratore. Le credenziali sono:
    * Email: `admin@gamespot.com`
    * Password: `admin`
- **Membro dello staff**: per testare come le funzionalità siano filtrate in base ai
    permessi degli utenti, ci si può loggare con un membro dello staff. Di
    seguito vengono fornite le credenziali di un membro del gruppo `bloggers`,
    che ha accesso solo al blog aziendale:
    * Email: `blogger@gamespot.com`
    * Password: `blogger`


[repo]: https://github.com/whatyouhide/gamespot
[project-website]: http://tdw.andrealeopardi.com
[project-docs]: http://tdw.andrealeopardi.com/docs/
[project-functions-docs]: http://tdw.andrealeopardi.com/docs/namespaces/default.html
[project-signup]: http://tdw.andrealeopardi.com/users/sign_up
[phpdocumentor]: http://phpdoc.org/
[gravatar]: https://secure.gravatar.com/
[momentjs]: http://momentjs.com/
[sass]: http://sass-lang.com/
[foundation]: http://foundation.zurb.com/
