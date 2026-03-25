<?php
	class AttivitaP
    {
    	public function inserisci()
        {
        	include_once("config.php");
            if(isset($_POST['invia']))
            {
                $attivitaPrevista=$_POST['attivitaPrevista'];
                $ore=$_POST['ore'];
                $stato=$_POST['stato'];
                $idDisciplina=$_POST['idDisciplina'];
                $sql= "INSERT INTO tabAttivitaProgrammate(idAtt,attivitaPrevista,ore,stato,idDisciplina) VALUES(null,'$attivitaPrevista','$ore','Non svolto','$idDisciplina');";
                $risultato=mysqli_query($conn, $sql);
                header('location:../tutor.php');
            }else
            {
            	$ris=mysqli_query($conn,"SELECT * FROM tabDiscipline");
                ?>
                <!DOCTYPE html>
          <html>
          <head>
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
                  <h2>Composizione Programma</h2>
                  <form action='' method='post'>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="nome">Attività Prevista</label>
                              <input type="text" name='attivitaPrevista' class="form-control" id="attivitaPrevista" placeholder="Inserisci le attività programmate">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="cognome">Ore</label>
                              <input type="number" name='ore' class="form-control" id="ore" placeholder="Inserisci le ore da svolgere">
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="data_nascita">Stato</label>
                              <input type="text" name='stato' value="Non Svolto" class="form-control" id="stato" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                      <label for="docenti">Discipline:</label>
                      <select class="form-control" id="idDisciplina" name="idDisciplina">
                        <option value="">Seleziona una disciplina</option>
                        <?php
                           while($riga=mysqli_fetch_assoc($ris)){
                                echo "<option value='".$riga['idDisciplina']."'>".$riga['nomeDisciplina']."</option>";
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
            }
        }
        
       public function index(){
        	include_once("gestProgrammazione/config.php");
            $risultato=mysqli_query($conn,"SELECT * FROM tabAttivitaProgrammate INNER JOIN tabDiscipline ON tabAttivitaProgrammate.idDisciplina=tabDiscipline.idDisciplina;");
           	?>
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>

                <div class="container">
                <a href="gestProgrammazione/inserisci.php" class="btn btn-primary">Inserisci nuova attivita</a><br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Attivita' prevista</th>
                                <th>Ore</th>
                                <th>Stato</th>
                                <th>Nome disciplina</th>
                                <th>Cancella</th>
                                <th>Modifica</th>
                            </tr>
                        </thead>
<?php
           while($riga=mysqli_fetch_array($risultato)){
           ?>
           <tbody>
           		<tr>
           			<td><?php echo $riga['attivitaPrevista']; ?></td>
                    <td><?php echo $riga['ore']; ?></td>
                    <td><?php echo $riga['stato']; ?></td>
                    <td><?php echo $riga['nomeDisciplina']; ?></td>
                    <td><a href="gestProgrammazione/cancella.php?id=<?php echo $riga['IdAtt']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");' ><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestProgrammazione/modifica.php?id=<?php echo $riga['IdAtt']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
        
        public function cancella()
        {
        	include_once ("config.php");
        	$id=$_GET['id'];
    		$risultato=mysqli_query($conn,"DELETE FROM tabAttivitaProgrammate WHERE IdAtt=$id;");
    		header("location:../tutor.php");
        }
        
        public function modifica()
        {
        		include_once ("config.php");
                $id=$_GET['id'];

            if(isset($_POST['invio'])){
                $attivitaPrevista=$_POST['attivitaPrevista'];
                $ore=$_POST['ore'];
                $stato=$_POST['stato'];
                $idDisciplina=$_POST['idDisciplina'];
                $ris=mysqli_query($conn,"UPDATE tabAttivitaProgrammate SET attivitaPrevista='$attivitaPrevista', ore='$ore', stato='$stato', idDisciplina='$idDisciplina' WHERE IdAtt='$id';");
                header('location:../tutor.php');
            }
            else
            {
                $risultato=mysqli_query($conn,"SELECT * FROM tabAttivitaProgrammate WHERE IdAtt=$id;");
                $discipline=mysqli_query($conn,"SELECT * FROM tabDiscipline");
                $discipline_c=mysqli_query($conn,"SELECT * FROM tabAttivitaProgrammate INNER JOIN tabDiscipline ON tabAttivitaProgrammate.idDisciplina=tabDiscipline.idDisciplina WHERE IdAtt=$id;");
                $riga=mysqli_fetch_array($risultato);

?>
               <!DOCTYPE html>
          <html>
          <head>
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
                  <h2>Modifica Attività Programmate</h2>
                  <form action='' method='post'>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="attivitaPrevista">Attività Previste</label>
                              <input type="text" name='attivitaPrevista' value="<?php echo $riga['attivitaPrevista']; ?>" class="form-control" id="attivitaPrevista">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="ore">Ore</label>
                              <input type="number" name='ore' class="form-control" id="ore" value="<?php echo $riga['ore']; ?>">
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="data_nascita">Stato</label>
                              <input type="text" name='stato' value="Non Svolto" class="form-control" id="stato" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                      <label for="discipline">Discipline:</label>
                      <?php
                      		$riga3=mysqli_fetch_assoc($discipline_c);
                       ?>
                      <select class="form-control" id="idDisciplina" name="idDisciplina">
                        <option value="<?php echo $riga3['idDisciplina']; ?>"><?php echo $riga3['nomeDisciplina']; ?></option>
                        <?php
                           while($riga1=mysqli_fetch_assoc($discipline)){
                                echo "<option value='".$riga1['idDisciplina']."'>".$riga1['nomeDisciplina']."</option>";
                           }
                         ?>
                      </select>
                    </div>
                      <button type="submit" name='invio' class="btn btn-primary">Invia</button>
                      <a href="../tutor.php" class="btn btn-primary">Torna alla home</a>
                  </form>
              </div>
              <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
          </body>
          </html>
          <?php
			}
        
        }
        
    }
    $ogg=new AttivitaP();
?>
