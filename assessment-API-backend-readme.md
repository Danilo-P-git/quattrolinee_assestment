# 🎟️ QL Laravel API Assignment  

## 📌 Introduzione  
Questo compito è stato progettato per il team di prodotti digitali di QL. Nelle sezioni seguenti troverai una serie di attività da sviluppare.  

⚠️ **NON È NECESSARIO** completarle tutte: puoi scegliere quante attività desideri affrontare.  

Hai a disposizione **3 giorni** per completare la tua soluzione, lavorando al tuo ritmo. Sappiamo che potresti avere altri impegni, quindi ci concentreremo sulla **qualità del lavoro** piuttosto che sul tempo impiegato.  

## 📤 Consegna del lavoro 
1. **Crea un repository privato** su GitLab.  
2. Condividi l'accesso al repository con @simone46 
3. Lavora al progetto come se fosse un'applicazione reale, seguendo le best practices per **commit, branching e testing**.  
4. Fornisci una breve guida su come avviare e testare l'API.

## Valutazione 🔍
La tua soluzione verrà esaminata in base a vari parametri, tra cui:
- Pulizia del codice 🧹
- Utilizzo dei design pattern 💡
- Organizzazione del progetto 📂
- Qualità del flusso di lavoro (commits, rami, test, …) 🔄
- Documentazione 📚

### Un promemoria amichevole 🌟
In QL, siamo entusiasti di utilizzare le **tecnologie AI**, come GPT e simili. Possono essere strumenti utili per stimolare idee, risolvere problemi e affinare le soluzioni. Tuttavia, per questa sfida, siamo particolarmente interessati al tuo approccio personale. Vogliamo vedere il tuo processo di pensiero, le tue decisioni e come affronti le sfide.  
Ricorda che sebbene l’AI possa essere un valido supporto, l’obiettivo principale di questo esercizio è che mostri la tua **creatività** e le tue **competenze**. Sarà importante che tu possa spiegare le tue decisioni e il razionale dietro il tuo lavoro durante il colloquio tecnico.

Sentiti libero di usare l’AI per supporto, ma assicurati che il lavoro finale sia il tuo. Siamo alla ricerca di una combinazione di competenze tecniche e creatività.  
Inizia a lavorare, esplora le tue idee e facci vedere cosa puoi creare. Buona fortuna! 🍀

## Iniziamo! 🎬
Siamo consapevoli che alcune tematiche potrebbero non esserti familiari. Pertanto, scegli le attività che ti senti più a tuo agio nell’affrontare.  
**Importante**: alcune attività potrebbero sembrare vaghe o incomplete nei requisiti. Questo è voluto: vogliamo darti la libertà di fare delle scelte personali e di non limitarti troppo. Sarà utile se documenterai le tue decisioni, le ipotesi fatte, i dubbi e le domande che avresti in un contesto reale.

## Ambito del Progetto 🎯
Il tuo obiettivo è creare un’API **RESTful** per **QL Ticketing**, una piattaforma online per la prenotazione di biglietti. Gli utenti devono poter cercare eventi, aggiungere biglietti al carrello, effettuare il pagamento e completare la prenotazione. L’API deve essere progettata come una **Single Page Application (SPA)** per il frontend, ma qui ci concentreremo esclusivamente sul lato API.

**Nota**: Non è necessario gestire l’autenticazione, il login o utenti multipli: immagina che ci sia sempre un solo utente che interagisce con il sistema.

## Attività 💻

### Attività 1: API per la Gestione degli Eventi Disponibili 📅
Un sviluppatore junior ha creato una lista di eventi disponibili nel sistema, ma non è stata implementata una paginazione. Modifica il codice per migliorarlo, implementando la paginazione dell’API con un sistema di **infinite scroll**.
- Implementa la paginazione lato server usando Laravel.
- Restituisci i dati paginati tramite un endpoint API, ad esempio `GET /api/events?page=1`.

### Attività 2: API di Ricerca e Filtraggio per Categoria 🔍
Esiste un sistema di ricerca per gli eventi e un elenco di categorie. Gli utenti devono poter cercare eventi e applicare filtri in base alla categoria. La ricerca deve essere dinamica, rispondendo alle richieste quando l’utente digita.
- Crea un endpoint API per la ricerca degli eventi, ad esempio `GET /api/events/search?q={query}`.
- Implementa il filtraggio per categoria, ad esempio `GET /api/events/category/{categoryId}`.
- Combina la ricerca e i filtri in un singolo endpoint se necessario.

### Attività 3: API per la Gestione del Carrello 🛒
Ogni evento ha una possibilità di aggiungere biglietti al carrello. L’API dovrà gestire il carrello come una lista di eventi con la relativa quantità di biglietti. Gli utenti possono aggiungere o rimuovere eventi dal carrello, e il numero totale di biglietti nel carrello deve essere aggiornato in tempo reale.
- Crea un endpoint API per aggiungere un evento al carrello, ad esempio `POST /api/cart/add`.
- Crea un endpoint API per rimuovere un evento dal carrello, ad esempio `POST /api/cart/remove`.
- Implementa la logica per ottenere e aggiornare il contenuto del carrello, ad esempio `GET /api/cart`.

### Attività 4: API per il Checkout 💳
La fase finale è il checkout, dove l’utente può completare la prenotazione dei biglietti e selezionare il metodo di pagamento. Implementa la logica API per la gestione del checkout in più passaggi:
1. Riepilogo del carrello e prezzo finale.
2. Indirizzo di consegna dei biglietti (se necessario).
3. Metodo di pagamento.
4. Conferma della prenotazione.
- Crea un endpoint API per visualizzare il riepilogo del carrello e il totale, ad esempio `GET /api/checkout/summary`.
- Crea un endpoint per registrare l’indirizzo di consegna, ad esempio `POST /api/checkout/address`.
- Integra un endpoint di pagamento (puoi usare ad esempio un job che randomicamente imposta l'esito del pagamento), ad esempio `POST /api/checkout/payment`.
- Crea un endpoint per confermare la prenotazione, ad esempio `POST /api/checkout/confirm`.

## Documentazione 📑
Fornisci una documentazione chiara in cui spieghi le scelte tecniche, i design pattern utilizzati, e come ogni endpoint API interagisce con il sistema. Includi anche istruzioni su come configurare e far funzionare l’ambiente di sviluppo.
