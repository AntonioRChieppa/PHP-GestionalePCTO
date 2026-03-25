<?php
	session_start();
    if(isset($_SESSION['accedi'])){
		if(isset($_COOKIE['cookie_esperto'])){
			$nome='cookie_esperto';
			$scadenza=time()+(600+300);
			setcookie($nome,$_COOKIE['cookie_esperto'],$scadenza);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <title>Dashboard esperto</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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

      #image {
        margin-bottom:5%;
        width: 25px;
        height: 25px;
      }

	  #printer{
      	width: 5%;
        height: 5%;
      }
  </style>
    </head>
    <body>

    <div class="container mt-3">
      <h2>Esperto's Dashboard</h2>
      <div id="main-container" class="container mt-3">
        <div class='user'>
            <p>Ciao <?php echo $_SESSION['accedi']?>, sei l'esperto esterno!</p>
            <img id='image' src='../images/user.png' alt='immagine utente'>
      </div>
      <br>
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#menu1">Registro Attività</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#menu2">Assenze studenti</a>
        </li>
        <li class="nav-item">
      	  <a class="nav-link" data-bs-toggle="tab" href="#menu3">Stampa</a>
    	</li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div id="home" class="container tab-pane active"><br>
          <h3>HOME</h3>
          <p>Le operazioni che puoi svolgere sono :</p>
          <ul>
          	<li>Gestire il registro delle attività delle diverse classi</li>
            <li>Gestire le assenze degli studenti</li>
           </ul>
        </div>
        <div id="menu1" class="container tab-pane fade"><br>
          <h3>Registro Attività</h3>
          <?php
          	include("gestRegistroA/gestRegistro.php");
            $obj=new gestRegistro();
            $obj->index();
          ?>
        </div>
        <div id="menu2" class="container tab-pane fade"><br>
          <h3>Assenze studenti</h3>
          <?php
          	include("gestAssenze/classAssenze.php");
            $obj=new Assenza();
            $obj->index();
          ?>
        </div>
        <div id="menu3" class="container tab-pane fade"><br>
      <h3>Stampa pdf</h3>
      	<p>Inserisci una descrizione sul progetto PCTO, e successivamente stampa il resoconto!</p>
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

