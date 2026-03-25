<?php
	class Assenza{
    
    	public function inserisci(){
        	include_once("config.php");
            if(isset($_POST['invia'])){
                $studente=$_POST['studente'];
                $registro=$_POST['att'];
                $numOreAssenza=$_POST['ore'];
                $risultato=mysqli_query($conn,"INSERT INTO tabAssenze VALUES (null,'$studente','$registro','$numOreAssenza');");
                header('location:inserisci.php');
          }
          else{
          $s=mysqli_query($conn,"SELECT * FROM tabStudenti");
          $r=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt ");
          ?>
          <!DOCTYPE html>
          <html>
          <head>
              <title>Inserisci Assenza</title>
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
                  <h2>Inserire Assenza</h2>
                  <form action='' method='post'>
                   <div class="form-group">
                    <label for="studente">Studenti:</label>
                    <select class="form-control" id="studente" name="studente">
                      <option value="">Seleziona uno studente</option>
                      <?php
                         while($riga=mysqli_fetch_assoc($s)){
                              echo "<option value='".$riga['idStudente']."'>".$riga['cognome']." ".$riga['nome']."</option>";
                         }
                       ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="att">Attivita:</label>
                    <select class="form-control" id="att" name="att">
                      <option value="">Seleziona un' attivita</option>
                      <?php
                         while($riga1=mysqli_fetch_assoc($r)){
                              echo "<option value='".$riga1['idRegistro']."'>".$riga1['attivitaPrevista']."</option>";
                         }
                       ?>
                    </select>
                  </div>
                    <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="num_ore">Numero ore di Assenza</label>
                              <input type="number" name='ore' class="form-control" id="num_ore">
                          </div>
                      </div>
                      <button type="submit" name='invia' class="btn btn-primary">Invia</button>
                      <a href="../docente.php" class="btn btn-primary">Torna alla home</a>
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
        	include_once("gestAssenze/config.php");
            $risultato=mysqli_query($conn,"SELECT * FROM tabAssenze INNER JOIN tabStudenti ON tabAssenze.idStudente=tabStudenti.idStudente INNER JOIN tabRegistroAttivita ON tabAssenze.idRegistro=tabRegistroAttivita.idRegistro INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt");
           	?>
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>

                <div class="container">
                <a href="gestAssenze/inserisci.php" class="btn btn-primary">Inserisci assenza</a><br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Cognome</th>
                                <th>Nome</th>
                                <th>Argomento</th>
                                <th>N° ore assenze</th>
                                <th>Cancella</th>
                                <th>Modifica</th>
                            </tr>
                        </thead>
<?php
           while($riga=mysqli_fetch_array($risultato)){
           ?>
           <tbody>
           		<tr>
           			<td><?php echo $riga['cognome']; ?></td>
                    <td><?php echo $riga['nome']; ?></td>
                    <td><?php echo $riga['attivitaPrevista']; ?></td>
                    <td><?php echo $riga['numOreAssenza']; ?></td>
                    <td><a href="gestAssenze/cancella.php?id=<?php echo $riga['idAssenza']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestAssenze/modifica.php?id=<?php echo $riga['idAssenza']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
           	$cancella=mysqli_query($conn,"DELETE FROM tabAssenze WHERE idAssenza=$id");
            header('location:../docente.php');
       	}//chiusura metodo cancella
        
        public function modifica(){
        	include_once("config.php");
            $id=$_GET['id'];
            if(isset($_POST['invia'])){
            	$studente=$_POST['studente'];
                $registro=$_POST['att'];
                $numOreAssenza=$_POST['ore'];
                $ris=mysqli_query($conn,"UPDATE tabAssenze SET idStudente='$studente', idRegistro='$registro', numOreAssenza='$numOreAssenza' WHERE idAssenza='$id' ;");
                header('location:../docente.php');
           }
           else{
               $ris2=mysqli_query($conn,"SELECT * FROM tabAssenze WHERE idAssenza='$id';");
               $riga=mysqli_fetch_array($ris2);
               $s1=mysqli_query($conn,"SELECT * FROM tabAssenze INNER JOIN tabStudenti ON tabAssenze.idStudente=tabStudenti.idStudente WHERE idAssenza='$id';");
               $r1=mysqli_query($conn,"SELECT * FROM tabAssenze INNER JOIN tabRegistroAttivita ON tabAssenze.idRegistro=tabRegistroAttivita.idRegistro INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt WHERE idAssenza='$id';");
               $s=mysqli_query($conn,"SELECT * FROM tabStudenti");
          	   $r=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt");
               ?>
               <!DOCTYPE html>
                <html>
                <head>
                    <title>Modifica Assenza</title>
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
                        <h2>Modifica Assenza</h2>
                        <form action='' method='post'>
                         <div class="form-group">
                          <label for="studente">Studenti:</label>
                          <?php
                          		$riga2=mysqli_fetch_assoc($s1);
                          ?>
                          <select class="form-control" id="studente" name="studente">
                            <option value="<?php echo $riga2['idStudente']; ?>"><?php echo $riga2['cognome']." ".$riga2['nome']; ?></option>
                            <?php
                               while($riga3=mysqli_fetch_assoc($s)){
                                    echo "<option value='".$riga3['idStudente']."'>".$riga3['cognome']." ".$riga3['nome']."</option>";
                               }
                             ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="att">Attivita:</label>
                          <?php
                          	$riga4=mysqli_fetch_assoc($r1);
                          ?>
                          <select class="form-control" id="att" name="att">
                            <option value="<?php echo $riga4['idRegistro']; ?>"><?php echo $riga4['attivitaPrevista']; ?></option>
                            <?php
                               while($riga5=mysqli_fetch_assoc($r)){
                                    echo "<option value='".$riga5['idRegistro']."'>".$riga5['attivitaPrevista']."</option>";
                               }
                             ?>
                          </select>
                        </div>
                          <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="num_ore">Numero ore di Assenza</label>
                                    <input type="number" name='ore' value='<?php echo $riga['numOreAssenza']; ?>' class="form-control" id="num_ore">
                                </div>
                            </div>
                            <button type="submit" name='invia' class="btn btn-primary">Invia</button>
                            <a href="../docente.php" class="btn btn-primary">Torna alla home</a>
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
    $obj=new Assenza();
?>
    
