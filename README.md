# 🎓 Gestionale PCTO (Alternanza Scuola-Lavoro) - Progetto di Maturità

⚠️ **Attezione:** > *Questo repository è un progetto "vecchio" sviluppato durante l'Anno Scolastico 2022/2023 come progetto finale per l'Esame di Stato (Maturità). Lo mantengo pubblico sul mio GitHub come archivio storico per mostrare il mio punto di partenza e la traiettoria di crescita del mio percorso accademico e professionale.*

## 📝 Descrizione del Progetto
Questo progetto è un gestionale web ideato per semplificare e digitalizzare le attività legate al PCTO (Percorsi per le Competenze Trasversali e per l'Orientamento).
Permette la gestione degli studenti coinvolti nel percorso di alternanza da parte di figure di riferimento (es. docenti, esperti, studenti), la registrazione delle presenze, la compilazione dei registri e la gestione generale delle attività aziendali/scolastiche.

## 🛠️ Stack Tecnologico Originale (2023)
Al tempo dello sviluppo, il progetto è stato realizzato utilizzando tecnologie base senza l'ausilio di framework moderni:
* **Backend:** PHP puro (Vanilla PHP)
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
* **Database:** MySQL
* **Architettura:** Monolitica, con logica di business e di presentazione spesso accoppiate all'interno degli stessi file PHP.

---

## 🚀 Come lo svilupperei oggi (Architettura & Refactoring)
Se dovessi sviluppare questo gestionale oggi, abbandonerei l'approccio monolitico in PHP puro per adottare un'infrastruttura moderna, scalabile e manutenibile, strutturata nel seguente modo:

### 1. Disaccoppiamento Frontend / Backend
Separazione totale delle responsabilità. Il Backend fungerebbe unicamente da fornitore di dati e logica di business, mentre il Frontend si occuperebbe esclusivamente dell'interfaccia utente. La comunicazione avverrebbe in modo asincrono tramite **RESTful APIs** basate su protocollo HTTP.

### 2. Backend: Spring Boot & Architettura a Strati
Svilupperei il backend utilizzando **Java** e il framework **Spring Boot**. 
* **Architettura a strati (Layered Architecture):** Strutturerei il codice dividendo nettamente i livelli: `Controller` (per l'esposizione delle API HTTP), `Service` (per la logica di business) e `Repository` (per l'accesso ai dati).
* **Gestione Database:** Utilizzerei **Spring Data JPA / Hibernate** per mappare gli oggetti relazionali (ORM) e gestire in modo automatizzato e sicuro l'interazione con il database, prevenendo vulnerabilità storiche come le SQL Injection.

### 3. Frontend & Pattern MVC
Applicherei rigorosamente il pattern **MVC (Model-View-Controller)** sia a livello logico che di sviluppo UI. Per il frontend, adotterei un framework moderno per la creazione di una *Single Page Application (SPA)*, che consumerebbe le API esposte da Spring Boot, garantendo una User Experience molto più fluida e reattiva rispetto al classico ricaricamento delle pagine PHP.

---

## ⚙️ Come avviare e testare il progetto legacy (Locale)

Se desideri esplorare l'applicazione originale, puoi avviarla facilmente in locale seguendo questi passaggi:

### 1. Clona il repository
Apri il terminale e scarica il progetto in locale:
```bash
git clone [https://github.com/AntonioRChieppa/PHP-GestionalePCTO.git](https://github.com/AntonioRChieppa/PHP-GestionalePCTO.git)
cd gestionale-pcto
```

### 2. Configura il Database (MySQL)
Assicurati di avere un server MySQL in esecuzione (tramite XAMPP, MAMP, Docker, ecc.). 
Puoi importare il database da interfaccia grafica (es. phpMyAdmin) oppure direttamente da terminale (assicurati di aver inserito il file `.sql` nel progetto):
```bash
# Crea il database vuoto
mysql -u root -p -e "CREATE DATABASE gestionale_pcto;"

# Importa le tabelle e i dati dal file SQL esportato (sostituisci il nome del file)
mysql -u root -p gestionale_pcto < pcto.sql
```
*(Ricordati di verificare che il file di connessione al database PHP, come ad esempio `config.php`, contenga le tue credenziali locali corrette, es. utente `root` e nessuna password, e che punti al database `gestionale_pcto`).*

### 3. Avvia il Server PHP
Non è necessario spostare i file in cartelle specifiche come `htdocs`. Puoi utilizzare il server web integrato di PHP eseguendo questo comando direttamente dalla root del progetto:
```bash
php -S localhost:8000
```

### 4. Testa l'applicazione
Apri il tuo browser preferito e naviga all'indirizzo:
```text
http://localhost:8000
```

🔑 **Credenziali di Test:** Per accedere all'applicativo ed esplorare i vari ruoli e moduli, le credenziali di accesso sono disponibili all'interno del file `credenziali.txt` incluso nella root del repository.
