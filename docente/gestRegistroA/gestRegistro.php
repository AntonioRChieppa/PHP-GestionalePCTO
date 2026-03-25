 <?php
	class gestRegistro{
    
    	public function inserisci() {
    		include_once("config.php");
    
            if(isset($_POST['invia'])) {
                $data = $_POST['data'];
                $argomento = $_POST['argomento'];
                $docente = $_POST['docente'];
                $numOre = $_POST['n'];
                $materiali = $_POST['materiali'];
                $classe = $_POST['classe'];
                $disciplina = $_POST['disciplina'];

				$update = mysqli_query($conn, "UPDATE tabAttivitaProgrammate SET stato='Svolto' WHERE IdAtt='" . $argomento . "'");
                $risultato = mysqli_query($conn, "INSERT INTO tabRegistroAttivita VALUES (null, '$data', '$numOre', '$materiali', '$disciplina', '$docente', '$argomento', '$classe');");
                header('location:inserisci.php');
   		 		} 
    		else {
              $r = mysqli_query($conn, "SELECT * FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo = tabIndirizzi.idIndirizzo");
              $argomento = mysqli_query($conn, "SELECT * FROM tabAttivitaProgrammate");
              $docente = mysqli_query($conn, "SELECT * FROM tabUtenti WHERE ruolo = 'docente';");
              $disciplina=mysqli_query($conn,"SELECT * FROM tabDiscipline; ");
              ?>

              <!DOCTYPE html>
              <html>
              <head>
                  <title>Inserisci attività</title>
                  <meta charset="utf-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1">
                  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                  <style>
                      a {
                          text-align: center;
                      }
                  </style>
              </head>
              <body>
                  <div class="container mt-4">
                      <h2>Inserimento attività</h2>
                      <form action='' method='post'>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="nome">Data Attività</label>
                                  <input type="date" name='data' class="form-control" id="data">
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="argomento">Argomento:</label>
                                  <select class="form-control" id="argomento" name="argomento">
                                      <option value="">Seleziona l'argomento</option>
                                      <?php
                                          while($r1 = mysqli_fetch_assoc($argomento)) {
                                              echo "<option value='".$r1['IdAtt']."'>".$r1['attivitaPrevista']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-row">
                          	<div class="form-group col-md-6">
                                  <label for="classe">Classe:</label>
                                  <select class="form-control" id="classe" name="classe">
                                      <option value="">Seleziona la classe</option>
                                      <?php
                                          while($riga = mysqli_fetch_assoc($r)) {
                                              echo "<option value='".$riga['idClasse']."'>".$riga['anno'].$riga['sezione']." ".$riga['nomeIndirizzo']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="docente">Docente:</label>
                                  <select class="form-control" id="docente" name="docente">
                                      <option value="">Seleziona il docente</option>
                                      <?php
                                          while($d = mysqli_fetch_assoc($docente)) {
                                              echo "<option value='".$d['idUtente']."'>".$d['cognome']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                             </div>
                             
                              <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="docente">Disciplina</label>
                                  <select class="form-control" id="disciplina" name="disciplina">
                                      <option value="">Seleziona la disciplina</option>
                                      <?php
                                          while($dis = mysqli_fetch_assoc($disciplina)) {
                                              echo "<option value='".$dis['idDisciplina']."'>".$dis['nomeDisciplina']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="materiali">Materiali</label>
                                  <input type="text" name='materiali' class="form-control" id="materiali" placeholder='Inserire materiali distribuiti'>
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="numOre">N° ore</label>
                                  <input type="number" name='n' class="form-control" id="numOre" placeholder='Inserire numero ore'>
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
        	include_once("gestRegistroA/config.php");
            $risultato=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabDiscipline ON tabRegistroAttivita.idDisciplina=tabDiscipline.idDisciplina INNER JOIN tabClassi ON tabRegistroAttivita.idClasse=tabClassi.idClasse INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo");
            $risultato2=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt INNER JOIN tabUtenti ON tabRegistroAttivita.idUtente=tabUtenti.idUtente WHERE ruolo='docente'");
            
            
           	?>
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>
                <div class="container">
                <a href="gestRegistroA/inserisci.php" class="btn btn-primary">Inserisci nuova Attività</a><br><br>
                    <table class='table table-bordered'> 
                        <thead>
                            <tr>
                            	<th>Argomento</th>
                                <th>Disciplina</th>
                                <th>Docente</th> 
                                <th>N°Ore</th> 
                                <th>Materiali Distribuiti</th> 
                                <th>Data Attività</th> 
                                <th>Classe</th>
                                <th>Cancella</th>
                                <th>Modifica</th>
                            </tr>
                        </thead>
<?php
           while(($riga = mysqli_fetch_array($risultato)) && ($riga2 = mysqli_fetch_array($risultato2))){
           ?>
			<tbody>
           		<tr>
           			<td><?php echo $riga2['attivitaPrevista']; ?></td>
                    <td><?php echo $riga['nomeDisciplina']; ?></td>
                    <td><?php echo $riga2['cognome']; ?></td>
                    <td><?php echo $riga['numOre']; ?></td>
                    <td><?php echo $riga['materialiDistribuiti']; ?></td>
                    <td><?php echo $riga['dataAttivita']; ?></td>
                    <td><?php echo $riga['anno'].$riga['sezione']." ".$riga['nomeIndirizzo']; ?></td>
                    <td><a href="gestRegistroA/cancella.php?id=<?php echo $riga['idRegistro']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestRegistroA/modifica.php?id=<?php echo $riga['idRegistro']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
           		</tr>
                </tbody>
		
<?php   	
		  }//chiudo while
?>
		
        </table>
   		 </div>
<?php
        }//chiusura metodo visualizza
        
        public function cancella(){
        	include_once("config.php");
            $id=$_GET['id'];
           	$cancella=mysqli_query($conn,"DELETE FROM tabRegistroAttivita WHERE idRegistro=$id");
            header('location:../docente.php');
       	}//chiusura metodo cancella
        
        public function modifica(){
        	include_once("config.php");
            $id=$_GET['id'];
            if(isset($_POST['invia'])){
            	$data = $_POST['data'];
                $argomento = $_POST['argomento'];
                $docente = $_POST['docente'];
                $numOre = $_POST['n'];
                $materiali = $_POST['materiali'];
                $classe = $_POST['classe'];
                $disciplina = $_POST['disciplina'];
                
                $ris=mysqli_query($conn,"UPDATE tabRegistroAttivita SET dataAttivita='$data', numOre='$numOre', materialiDistribuiti='$materiali', idDisciplina='$disciplina', idUtente='$docente', idAtt='$argomento', idClasse='$classe' WHERE idRegistro='$id';");
                header('location:../docente.php');
           }
           else{
           	   $ris2=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita WHERE idRegistro='$id';");
               $riga1=mysqli_fetch_array($ris2);
               $arg1=mysqli_query($conn,"SELECT * FROM tabAttivitaProgrammate; ");
               $cl=mysqli_query($conn,"SELECT * FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo");
               $docente=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabUtenti ON tabRegistroAttivita.idUtente=tabUtenti.idUtente WHERE idRegistro='$id'; " );
               $d1=mysqli_query($conn,"SELECT * FROM tabUtenti WHERE ruolo='docente';");
               $disciplina=mysqli_query($conn,"SELECT * FROM tabDiscipline;");
               $risultato=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabClassi ON tabRegistroAttivita.idClasse=tabClassi.idClasse INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo WHERE idRegistro='$id';");
               $risultato2=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt WHERE idRegistro='$id';");
               $risultato3=mysqli_query($conn,"SELECT * FROM tabRegistroAttivita INNER JOIN tabDiscipline ON tabRegistroAttivita.idDisciplina=tabDiscipline.idDisciplina WHERE idRegistro='$id'; ");
               ?>
               <!DOCTYPE html>
          <html>
          <head>
              <title>modifica attivita</title>
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
                  <h2>Modifica attività</h2>
                  <form action='' method='post'>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="nome">Data Attività</label>
                                  <input type="date" name='data' class="form-control" id="data" value='<?php echo $riga1['dataAttivita']; ?>'>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="argomento">Argomento:</label>
                                  <?php
                                  	$argomento=mysqli_fetch_assoc($risultato2);
                                  ?>
                                  <select class="form-control" id="argomento" name="argomento">
                                      <option value="<?php echo $argomento['IdAtt']; ?>"><?php echo $argomento['attivitaPrevista']; ?></option>
                                      <?php
                                          while($a2 = mysqli_fetch_assoc($arg1)) {
                                              echo "<option value='".$a2['IdAtt']."'>".$a2['attivitaPrevista']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-row">
                          	<div class="form-group col-md-6">
                                  <label for="classe">Classe:</label>
                                  <?php
                                  	$classe=mysqli_fetch_assoc($risultato);
                                  ?>
                                  <select class="form-control" id="classe" name="classe">
                                      <option value="<?php echo $classe['idClasse']; ?>"><?php echo $classe['anno'].$classe['sezione']." ".$classe['nomeIndirizzo']; ?></option>
                                      <?php
                                          while($riga = mysqli_fetch_assoc($cl)) {
                                              echo "<option value='".$riga['idClasse']."'>".$riga['anno'].$riga['sezione']." ".$riga['nomeIndirizzo']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="docente">Docente:</label>
                                  <?php
                                  	$doc=mysqli_fetch_assoc($docente);
                                  ?>
                                  <select class="form-control" id="docente" name="docente">
                                      <option value="<?php echo $doc['idUtente']; ?>"><?php echo $doc['cognome']; ?></option>
                                      <?php
                                          while($d = mysqli_fetch_assoc($d1)) {
                                              echo "<option value='".$d['idUtente']."'>".$d['cognome']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                             </div>
                             
                              <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="docente">Disciplina</label>
                                  <?php
                                  	$diss=mysqli_fetch_assoc($risultato3);
                                  ?>
                                  <select class="form-control" id="disciplina" name="disciplina">
                                      <option value="<?php echo $diss['idDisciplina']; ?>"><?php echo $diss['nomeDisciplina']; ?></option>
                                      <?php
                                          while($dis = mysqli_fetch_assoc($disciplina)) {
                                              echo "<option value='".$dis['idDisciplina']."'>".$dis['nomeDisciplina']."</option>";
                                          }
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="materiali">Materiali</label>
                                  <input type="text" name='materiali' class="form-control" id="materiali" value='<?php echo $riga1['materialiDistribuiti']; ?>' >
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="numOre">N° ore</label>
                                  <input type="number" name='n' class="form-control" id="numOre" value='<?php echo $riga1['numOre']; ?>'>
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
    $obj=new gestRegistro();
?>
    
