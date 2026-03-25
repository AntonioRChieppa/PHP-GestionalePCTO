<?php
	class Indirizzo{
    
    	public function inserisci(){
        	include_once("config.php");
            if(isset($_POST['invia'])){
            	$nome=$_POST['nome'];
                $risultato=mysqli_query($conn,"INSERT INTO tabIndirizzi VALUES (null,'$nome');");
                header('location:inserisci.php');
          }
          else{
          ?>
          <!DOCTYPE html>
          <html lang="it">
          <head>
            <title>Form per l'inserimento di un indirizzo</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          </head>
          <body>

          <div class="container">
            <h2>Inserisci Indirizzo</h2>
            <form action="" method="post">
              <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder='Nome indirizzo'>
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
        	include_once("gestIndirizzi/config.php");
            $risultato=mysqli_query($conn,"SELECT * FROM tabIndirizzi order by nomeIndirizzo;");
            $i=0;
           	?>
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>
            <body>

                <div class="container">
                <a href="gestIndirizzi/inserisci.php" class="btn btn-primary">Inserisci nuovo indirizzo</a><br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            	<th>N°</th>
                                <th>Nome</th>
                            </tr>
                        </thead>
<?php
           while($riga=mysqli_fetch_array($risultato)){
           $i++;
           ?>
           <tbody>
           		<tr>
                	<td><?php echo $i; ?></td>
           			<td><?php echo $riga['nomeIndirizzo']; ?></td>
                    <td><a href="gestIndirizzi/cancella.php?id=<?php echo $riga['idIndirizzo']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestIndirizzi/modifica.php?id=<?php echo $riga['idIndirizzo']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
           	$cancella=mysqli_query($conn,"DELETE FROM tabIndirizzi WHERE idIndirizzo=$id");
            header('location:../tutor.php');
       	}//chiusura metodo cancella
        
        public function modifica(){
        	include_once("config.php");
            $id=$_GET['id'];
            if(isset($_POST['invia'])){
            	$nome=$_POST['nome'];
                $ris=mysqli_query($conn,"UPDATE tabIndirizzi SET nomeIndirizzo='$nome' WHERE idIndirizzo='$id';");
                header('location:../tutor.php');
           }
           else{
               $riga=mysqli_query($conn,"SELECT * FROM tabIndirizzi;");
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
                        <h2>Modifica Indirizzo</h2>
                        <form action='' method='post'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" name='nome' value='<?php echo $riga['nomeIndirizzo']; ?>' class="form-control" id="nome">
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
    $obj=new Indirizzo();
?>