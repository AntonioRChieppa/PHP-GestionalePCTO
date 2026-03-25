<?php
	session_start();
    if(isset($_SESSION['accedi'])){
		if(isset($_COOKIE['cookie_tutor'])){
			$nome='cookie_tutor';
			$scadenza=time()+(10+5);
			setcookie($nome,$_COOKIE['cookie_tutor'],$scadenza);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard tutor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <style>
  	#log{
    	display:flex;
        justify-content:center;
        align-items:center;
   }
   
   .user {
    position: absolute;
    top: 0;
    right: 0;
    display: flex;
    align-items: center;
    margin-top:1%;
    margin-right:2%;
  }

  .user p {
    margin-right: 10px;
  }

  .image{
    margin-bottom:5%;
    width: 25px;
    height: 25px;
  }
  
  #printer{
  	width:5%;
    height:5%;
  }
   
  </style>
</head>
<body>

<div class="container mt-3">
  <h2>Tutor's Dashboard</h2>
  <div id="main-container" class="container mt-3">
  	<div class='user'>
    	<p>Ciao <?php echo $_SESSION['accedi']?>, sei tutor!</p>
    	<img class='image' src='../images/user.png' alt='immagine utente'>
  </div>
  <br>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-bs-toggle="tab" href="#home">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu1">Classi</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu2">Studenti</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu3">Utenti</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu4">Programmazione</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu5">Valutazioni</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu6">Discipline</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu7">Indirizzi</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#menu8">Stampa</a>
    </li>
  </ul>
  
  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
      <h3>HOME</h3>
      <p>Le operazioni che puoi svolgere sono :</p>
      <ul>
      	<li>gestire le classi</li>
        <li>gestire gli studenti di ciascuna classe</li>
        <li>gestire gli utenti che possono accedere alla piattaforma</li>
        <li>gestire la programmazione delle attivita'</li>
        <li>gestire le valutazioni di ciascuno studente</li>
        <li>gestire gli indirizzi relativi alla scuola d'appartenenza</li>
       </ul>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>Classi</h3>
      <?php
      	include ("gestClassi/gestClassi.php");
        $obj=new gestClassi();
        $obj->index();
       ?>
    </div>
    <div id="menu2" class="container tab-pane fade"><br>
      <h3>Studenti</h3>
      <?php
      	include ("gestStudenti/classStudenti.php");
        $obj=new Studenti();
        $obj->index();
      ?>
    </div>
    <div id="menu3" class="container tab-pane fade"><br>
      <h3>Utenti</h3>
      <?php
      	include ("gestUtenti/gestUtenti.php");
        $oggetto=new gestUtenti();
        $oggetto->index();
      ?>
    </div>
    <div id="menu4" class="container tab-pane fade"><br>
      <h3>Programmazione</h3>
      <?php
      	include ("gestProgrammazione/gestProgrammazione.php");
        $ogg=new AttivitaP();
        $ogg->index();
       ?>
    </div>
    <div id="menu5" class="container tab-pane fade"><br>
      <h3>Valutazioni</h3>
      <?php
        include ("gestValutazioni/classValutazioni.php");
        $voto=new gestValutazione();
        $voto->index();
      ?>
    </div>
    <div id="menu6" class="container tab-pane fade"><br>
      <h3>Discipline</h3>
      <?php
        include ("gestDiscipline/gestDiscipline.php");
        $obj=new Disciplina();
        $obj->index();
      ?>
    </div>
    <div id="menu7" class="container tab-pane fade"><br>
      <h3>Indirizzi</h3>
      <?php
        include ("gestIndirizzi/gestIndirizzi.php");
        $obj=new Indirizzo();
        $obj->index();
      ?>
    </div>
    <div id="menu8" class="container tab-pane fade"><br>
      <h3>Stampa pdf</h3>
      	<p>Inserisci una descrizione sul progetto PCTO, e successivamente stampa il resonconto!</p>
        <script>
          function inviaMessaggio() {
            var messaggio = document.getElementsByName("messaggio")[0].value;
            // Codice per manipolare il valore del messaggio, se necessario

            // Reindirizza l'utente alla pagina desiderata
            window.location.href = "gestPDF/pdf.php?messaggio=" + encodeURIComponent(messaggio);
          }
		</script>
        <form action='pdf.php' method='get'>
        	<textarea name="messaggio" placeholder="Inserire descrizione"></textarea>
      	</form>
      	<img src='../images/printer.png' id='printer' onclick="inviaMessaggio()">
        
    </div>
  </div>
</div>
<div id="log">
	<a href="../logout.php" class="btn btn-primary">Logout</a>
</div>
</div>
</body>
</html>

 <?php
 	}
		else{
			header('location:../sessioneScaduta.php');
		}	
    }
?>

