<?php
	class Studenti{
    
    	public function inserisci(){
        	include_once("config.php");
            if(isset($_POST['invia'])){
            	$nome=$_POST['nome'];
                $cognome=$_POST['cognome'];
                $dataNascita=$_POST['dataN'];
                $luogoNascita=$_POST['luogoN'];
                $idClasse=$_POST['classe'];
                $risultato=mysqli_query($conn,"INSERT INTO tabStudenti VALUES (null,'$nome','$cognome','$dataNascita','$luogoNascita','$idClasse');");
                header('location:inserisciS.php');
          }
          else{
          $r=mysqli_query($conn,"SELECT * FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo");
          ?>
          <!DOCTYPE html>
          <html>
          <head>
              <title>inserisci studenti</title>
              <meta charset="utf-8">
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
              <style>
              	a{
                	text-align:center;
                }
              </style>
          </head>
          <body>
              <div class="container mt-4">
                  <h2>Inserimento studenti</h2>
                  <form action='' method='post'>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="nome">Nome</label>
                              <input type="text" name='nome' class="form-control" id="nome" placeholder="Inserisci il tuo nome">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="cognome">Cognome</label>
                              <input type="text" name='cognome' class="form-control" id="cognome" placeholder="Inserisci il tuo cognome">
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="data_nascita">Data di nascita</label>
                              <input type="date" name='dataN' class="form-control" id="data_nascita">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="luogo_nascita">Luogo di nascita</label>
                              <input type="text" name='luogoN' class="form-control" id="luogo_nascita" placeholder="Inserisci il luogo di nascita">
                          </div>
                      </div>
                      <div class="form-group">
                      <label for="classe">Classe:</label>
                      <select class="form-control" id="classe" name="classe">
                        <option value="">Seleziona la classe</option>
                        <?php
                           while($riga=mysqli_fetch_assoc($r)){
                                echo "<option value='".$riga['idClasse']."'>".$riga['anno'].$riga['sezione']." ".$riga['nomeIndirizzo']."</option>";
                           }
                         ?>
                      </select>
                    </div>
                      <button type="submit" name='invia' class="btn btn-primary">Invia</button>
                      <a href="../tutor.php" class="btn btn-primary">Torna alla home</a>
                  </form>
              </div>
              <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
          </body>
          </html>    
<?php
		}//chiudo else
	}//chiudo metodo inserisci
    
    	public function index(){
        	include_once("gestStudenti/config.php");
            $risultato=mysqli_query($conn,"SELECT * FROM tabStudenti INNER JOIN tabClassi ON tabStudenti.idClasse=tabClassi.idClasse INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo order by cognome,nome");
            $i=0;
           	?>
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            </head>
            <body>

                <div class="container">
                <a href="gestStudenti/inserisciS.php" class="btn btn-primary">Inserisci nuovo studente</a><br><br>
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                            	<th>N°</th>
                                <th>Cognome</th>
                                <th>Nome</th>
                                <th>Data di nascita</th>
                                <th>Luogo di nascita</th>
                                <th>Classe</th>
                                <th>Cancella</th>
                                <th>Modifica</th>
                            </tr>
                        </thead>
<?php
           while($riga=mysqli_fetch_array($risultato)){
           $i++;
           ?>
           <tbody>
           		<tr>
                	<td><?php echo $i; ?></td>
           			<td><?php echo $riga['cognome']; ?></td>
                    <td><?php echo $riga['nome']; ?></td>
                    <td><?php echo $riga['dataNascita']; ?></td>
                    <td><?php echo $riga['luogoNascita']; ?></td>
                    <td><?php echo $riga['anno'].$riga['sezione']." ".$riga['nomeIndirizzo']; ?></td>
                    <td><a href="gestStudenti/cancellaS.php?id=<?php echo $riga['idStudente']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestStudenti/modificaS.php?id=<?php echo $riga['idStudente']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
           		</tr>
           </tbody>
		
<?php   	
		  }//chiudo while
?>
        </table>
        </div>

        <!-- Aggiungiamo i file JavaScript di jQuery e Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        
        
    </body>
    </html>
<?php
        }//chiusura metodo visualizza
        
        public function cancella(){
        	include_once("config.php");
            $id=$_GET['id'];
           	$cancella=mysqli_query($conn,"DELETE FROM tabStudenti WHERE idStudente=$id");
            header('location:../tutor.php');
       	}//chiusura metodo cancella
        
        public function modifica(){
        	include_once("config.php");
            $id=$_GET['id'];
            if(isset($_POST['invia'])){
            	$nome=$_POST['nome'];
                $cognome=$_POST['cognome'];
                $dataNascita=$_POST['dataNascita'];
                $luogoNascita=$_POST['luogoNascita'];
                $idClasse=$_POST['classe'];
                $ris=mysqli_query($conn,"UPDATE tabStudenti SET nome='$nome', cognome='$cognome', dataNascita='$dataNascita', luogoNascita='$luogoNascita', idClasse='$idClasse' WHERE idStudente='$id' ;");
                header('location:../tutor.php');
           }
           else{
               $ris2=mysqli_query($conn,"SELECT * FROM tabStudenti WHERE idStudente='$id';");
               $riga=mysqli_fetch_array($ris2);
               $classi1=mysqli_query($conn,"SELECT * FROM tabStudenti INNER JOIN tabClassi ON tabStudenti.idClasse=tabClassi.idClasse INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo WHERE idStudente='$id';");
               $r=mysqli_query($conn,"SELECT * FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo");
               ?>
               <!DOCTYPE html>
                <html>
                <head>
                    <title>Modifica i valori</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                </head>
                <body>
                    <div class="container mt-4">
                        <h2>Modifica studenti</h2>
                        <form action='' method='post'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" name='nome' value='<?php echo $riga['nome']; ?>' class="form-control" id="nome">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cognome">Cognome</label>
                                    <input type="text" name='cognome' value='<?php echo $riga['cognome']; ?>' class="form-control" id="cognome">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="data_nascita">Data di nascita</label>
                                    <input type="date" name='dataNascita' value='<?php echo $riga['dataNascita']; ?>' class="form-control" id="data_nascita">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="luogo_nascita">Luogo di nascita</label>
                                    <input type="text" name='luogoNascita' value='<?php echo $riga['luogoNascita']; ?>' class="form-control" id="luogo_nascita">
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="classe">Classe:</label>
                              <?php
                      				$riga2=mysqli_fetch_assoc($classi1);
                         		?>
                              <select class="form-control" id="classe" name="classe">
                                <option value="<?php echo $riga2['idClasse']; ?>"><?php echo $riga2['anno'].$riga2['sezione']." ".$riga2['nomeIndirizzo']; ?></option>
                                <?php
                                   while($rig=mysqli_fetch_assoc($r)){
                                        echo "<option value='".$rig['idClasse']."'>".$rig['anno'].$rig['sezione']." ".$rig['nomeIndirizzo']."</option>";
                                   }
                                 ?>
                              </select>
                            </div>
                            <button type="submit" name='invia' class="btn btn-primary">Invia</button>
                        </form>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                </body>
                </html>
<?php
			}//chiusura else
        }//chisura metodo modifica
		
    }//chiusura classe
    $obj=new Studenti();
?>
    
