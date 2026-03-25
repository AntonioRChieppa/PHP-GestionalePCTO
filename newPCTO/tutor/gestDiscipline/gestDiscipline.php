<?php
	class Disciplina{
    
    	public function inserisci(){
        	include_once("config.php");
            if(isset($_POST['invia'])){
            	$nome=$_POST['nome'];
                $idUtente=$_POST['idUtente'];
                $risultato=mysqli_query($conn,"INSERT INTO tabDiscipline VALUES (null,'$nome','$idUtente');");
                header('location:inserisci.php');
          }
          else{
          	$ris=mysqli_query($conn,"SELECT * FROM tabUtenti WHERE ruolo='docente'");
          ?>
          <!DOCTYPE html>
          <html lang="it">
          <head>
            <title>Form per l'inserimento di un docente</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          </head>
          <body>

          <div class="container">
            <h2>Inserisci Disciplina</h2>
            <form action="" method="post">
              <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder='Nome disciplina'>
              </div>
              <div class="form-group">
                <label for="docenti">Docenti:</label>
                <select class="form-control" id="idUtente" name="idUtente">
                  <option value="">Seleziona un docente</option>
                  <?php
                     while($riga=mysqli_fetch_assoc($ris)){
                          echo "<option value='".$riga['idUtente']."'>".$riga['cognome']."</option>";
                     }
                   ?>
                </select>
              </div>
              <button type="submit" name='invia' class="btn btn-primary">Invia</button>
              <a href="../tutor.php" class="btn btn-primary">Torna alla home</a>
            </form>
          </div>

          </body>
          </html>    
<?php
		}//chiudo else
	}//chiudo metodo inserisci
    
    	public function index(){
        	include_once("gestDiscipline/config.php");
            $risultato=mysqli_query($conn,"SELECT * FROM tabDiscipline INNER JOIN tabUtenti ON tabDiscipline.idUtente=tabUtenti.idUtente order by nomeDisciplina;");
           	?>
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>

                <div class="container">
                <a href="gestDiscipline/inserisci.php" class="btn btn-primary">Inserisci nuova disciplina</a><br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Docente</th>
                                <th>Cancella</th>
                                <th>Modifica</th>
                            </tr>
                        </thead>
<?php
           while($riga=mysqli_fetch_array($risultato)){
           ?>
           <tbody>
           		<tr>
           			<td><?php echo $riga['nomeDisciplina']; ?></td>
                    <td><?php echo $riga['cognome']; ?></td>
                    <td><a href="gestDiscipline/cancella.php?id=<?php echo $riga['idDisciplina']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestDiscipline/modifica.php?id=<?php echo $riga['idDisciplina']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
           	$cancella=mysqli_query($conn,"DELETE FROM tabDiscipline WHERE idDisciplina=$id");
            header('location:../tutor.php');
       	}//chiusura metodo cancella
        
        public function modifica(){
        	include_once("config.php");
            $id=$_GET['id'];
            if(isset($_POST['invia'])){
            	$nome=$_POST['nome'];
                $idUtente=$_POST['idUtente'];
                $ris=mysqli_query($conn,"UPDATE tabDiscipline SET nomeDisciplina='$nome', idUtente='$idUtente' WHERE idDisciplina='$id' ;");
                header('location:../tutor.php');
           }
           else{
               $ris2=mysqli_query($conn,"SELECT * FROM tabDiscipline WHERE idDisciplina='$id';");
               $docenti=mysqli_query($conn,"SELECT * FROM tabUtenti WHERE ruolo='docente'");
               $doc1=mysqli_query($conn,"SELECT * FROM tabDiscipline INNER JOIN tabUtenti ON tabDiscipline.idUtente=tabUtenti.idUtente WHERE idDisciplina='$id';");
               $riga1=mysqli_fetch_array($ris2);
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
                        <h2>Modifica Disciplina</h2>
                        <form action='' method='post'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" name='nome' value='<?php echo $riga1['nomeDisciplina']; ?>' class="form-control" id="nome">
                                </div>
                                <div class="form-group">
                                <label for="docenti">Docenti:</label>
                                <?php
                                	$riga3=mysqli_fetch_assoc($doc1);
                             	?>
                                <select class="form-control" id="idUtente" name="idUtente">
                                  <option value="<?php echo $riga3['idUtente']; ?>"><?php echo $riga3['cognome']; ?></option>
                                  <?php
                                     while($riga=mysqli_fetch_assoc($docenti)){
                                          echo "<option value='".$riga['idUtente']."'>".$riga['cognome']."</option>";
                                     }
                                   ?>
                                </select>
                              </div>
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
    $obj=new Disciplina();
?>