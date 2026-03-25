<?php
	class gestValutazione{
    
    public function inserisciV(){
		include_once ("config.php");
		if(isset($_POST['invia'])){
    		$val=$_POST['val'];
        	$des=$_POST['des'];
            $studente=$_POST['studente'];
        	mysqli_query($conn,"INSERT INTO tabValutazioni VALUES (null,'$val','$des','$studente');");
            header("location:inserisciV.php");
    	}
    	else{
        	$r=mysqli_query($conn,"SELECT * FROM tabStudenti");
 ?>
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <title>Inserimento Voti</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      </head>
      <body>

        <div class="container">
          <h1>Inserimento Voti</h1>
          <form action='' method='post'>
            <div class="form-group">
              <label for="val">Voto:</label>
              <select class="form-control" id="val" name="val">
                <option value=''>Inserire voto</option>
                <option value='1'>1</option>
                <option value='1'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
                <option value='8'>8</option>
                <option value='9'>9</option>
                <option value='10'>10</option>
              </select>
            </div>
            <div class="form-group">
              <label for="des">Descrizione:</label>
              <input type="text" class="form-control" id="des" name="des" placeholder='Descrizione voto'>
            </div>
            <div class="form-group">
                <label for="studente">Studenti:</label>
                <select class="form-control" id="studente" name="studente">
                  <option value="">Seleziona uno studente</option>
                  <?php
                     while($riga=mysqli_fetch_assoc($r)){
                          echo "<option value='".$riga['idStudente']."'>".$riga['cognome']." ".$riga['nome']."</option>";
                     }
                   ?>
                </select>
              </div>
            <button type="submit" name='invia' class="btn btn-primary">Invia</button>
            <a href="../tutor.php" class="btn btn-primary">Torna alla home</a>
          </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      </body>
      </html>
<?php
      		}
		}
        
		public function index(){
    		include_once("config.php");
            $risultato=mysqli_query($conn, "SELECT * FROM tabValutazioni INNER JOIN tabStudenti ON tabValutazioni.idStudente=tabStudenti.idStudente order by nome;");
?>
<!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>

                <div class="container">
                <a href="gestValutazioni/inserisciV.php" class="btn btn-primary">Inserisci nuova valutazione</a><br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            	<th>Cognome</th>
                                <th>Nome</th>
                                <th>Voto</th>
                                <th>Descrizione</th>
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
           			<td><?php echo $riga['voto']; ?></td>
                    <td><?php echo $riga['descrizione']; ?></td>
                    <td><a href="gestValutazioni/cancellaV.php?id=<?php echo $riga['idVoto']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestValutazioni/modificaV.php?id=<?php echo $riga['idVoto']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
        
        public function cancellaV(){
        	include_once("config.php");
            $id=$_GET['id'];
            $risultato=mysqli_query($conn,"DELETE FROM tabValutazioni WHERE idVoto=$id;");
            header("location:../tutor.php");
        }
        
        public function modificaV(){
        	include_once("config.php");
            $id=$_GET['id'];
            
            if(isset($_POST['invia'])){
            	$voto=$_POST['val'];
                $des=$_POST['des'];
                $studente=$_POST['studente'];
                $ris=mysqli_query($conn,"UPDATE tabValutazioni SET voto='$voto', descrizione='$des', idStudente='$studente' WHERE idVoto=$id;");
                header("location:../tutor.php");
            }
            else{
				$risultato=mysqli_query($conn,"SELECT * FROM tabValutazioni WHERE idVoto=$id;");
                $r=mysqli_query($conn,"SELECT * FROM tabStudenti");
                $ris=mysqli_query($conn,"SELECT * FROM tabValutazioni INNER JOIN tabStudenti ON tabValutazioni.idStudente=tabStudenti.idStudente WHERE idVoto=$id;");
                $riga=mysqli_fetch_array($risultato);
?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="UTF-8">
                  <title>Modifica Voti</title>
                  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                </head>
                <body>

                  <div class="container">
                    <h1>Modifica Voti</h1>
                    <form action='' method='post'>
                        <div class="form-group">
                        <label for="val">Voto:</label>
                          <select class="form-control" id="val" name="val">
                            <option value='<?php echo $riga['voto']; ?>'><?php echo $riga['voto']; ?></option>
                            <option value='1'>1</option>
                            <option value='1'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="des">Descrizione:</label>
                        <input type="text" class="form-control" id="des" name="des" value="<?php echo $riga['descrizione']; ?>">
                      </div>
                      <div class="form-group">
                      <label for="studente">Studenti:</label>
                      <?php
                        $riga3=mysqli_fetch_assoc($ris);
                      ?>
                      <select class="form-control" id="studente" name="studente">
                        <option value="<?php echo $riga3['idStudente']; ?>"><?php echo $riga3['cognome']." ".$riga3['nome']; ?></option>
                        <?php
                           while($riga1=mysqli_fetch_assoc($r)){
                                echo "<option value='".$riga1['idStudente']."'>".$riga1['cognome']." ".$riga1['nome']."</option>";
                           }
                         ?>
                      </select>
                    </div>
                      <button type="submit" name='invia' class="btn btn-primary">Invia</button>
                      <a href="../tutor.php" class="btn btn-primary">Torna alla home</a>
                    </form>
                  </div>

                  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
                </body>
                </html>
<?php
            }
        }
        
    }
    $voto=new gestValutazione();
?>
