<?php
  class gestClassi{
            public function inserisci()
            {
                include_once "config.php";
                if(isset($_POST['invia']))
                {
                    $anno=$_POST['anno'];
                    $sezione=$_POST['sezione'];
                    $idindirizzo=$_POST['idIndirizzo'];
                    $risultato=mysqli_query($conn,"insert into tabClassi (idClasse,anno,sezione,idIndirizzo) VALUES (null,'$anno','$sezione','$idindirizzo');");
                    header('location:inserisci.php');
                }
                else{
                	$ris=mysqli_query($conn,"SELECT * FROM tabIndirizzi;");
                  ?>
                <!DOCTYPE html>
                <html>
                  <head>
                    <title>Inserisci</title>
                    <!-- Carica i file CSS di Bootstrap -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <style>
                    	.form-group input,select,option{width:20%; text-align:center};
                        .submit{color:white, background-color:blue;};
                    </style>
                  </head>
                  <body>
                    <div class="container" align=center>
                      <h1 align=center>Inserimento Classi</h1><br><br>
                       <form action='' method=post>
                        <div class="form-group">
                        <select name="anno"  class="form-control" id="anno" style="width:20%; text-align:center;">
                        		<option value="">Seleziona Anno</option>
                            	<option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                          <!--<input type="text" class="form-control" id="anno" name="anno" placeholder='Anno della classe'>-->
                        </div>
                        <div class="form-group">
                        	<select name="sezione" class="form-control" id="sezione" style="width:20%; text-align:center;">
                        		<option value="">Seleziona Sezione</option>
                            	<option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="idIndirizzo" name="idIndirizzo" style="width:20%; text-align:center;">
                              <option value="">Seleziona un indirizzo</option>
                              <?php
                                 while($riga=mysqli_fetch_assoc($ris)){
                                      echo "<option value='".$riga['idIndirizzo']."'>".$riga['nomeIndirizzo']."</option>";
                                 }
                               ?>
                            </select>
                        </div>
                         <button type="submit" class="btn btn-primary" name='invia'>Invia</button>
                      </form>
                      <br>
                      <a href="../tutor.php" class="btn btn-secondary">Visualizza Elenco</a>
                    </div>
                    <!-- Carica i file JavaScript di Bootstrap -->
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                  </body>
                </html>
                  <?php      
                }
            }//CHIUSURA inserisci
            
			public function index(){
                  include_once("gestClassi/config.php");
                  $risultato=mysqli_query($conn,"SELECT * FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo;");
                  ?>
                  <!DOCTYPE html>
                  <html>
                  <head>
                  <!-- Aggiungiamo il foglio di stile di Bootstrap -->
                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                  
                </head>
                  <body>

                      <div class="container">
                      <a href="gestClassi/inserisci.php" class="btn btn-primary">Inserisci nuova classe</a><br><br>
                          <table id="tabella" class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>Anno</th>
                                      <th>Sezione</th>
                                      <th>Indirizzo</th>
                                      <th>Cancella</th>
                                      <th>Modifica</th>
                                  </tr>
                              </thead>
      <?php
                 while($riga=mysqli_fetch_array($risultato)){
                 ?>
                 <tbody>
                      <tr>
                          <td><?php echo $riga['anno']; ?></td>
                          <td><?php echo $riga['sezione']; ?></td>
                          <td><?php echo $riga['nomeIndirizzo']; ?></td>
                          <td><a href="gestClassi/cancella.php?id=<?php echo $riga['idClasse']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                          <td><a href='gestClassi/modifica.php?id=<?php echo $riga['idClasse']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
                include_once "config.php";
                $id=$_GET['id'];
                $risultato=mysqli_query($conn,"DELETE FROM tabClassi WHERE idClasse=$id;");
                header("location:../tutor.php");

              }//CHUSURA cancella
             
              public function modifica()
              {
                include_once "config.php";
                $id=$_GET['id'];
                if(isset($_POST['invia']))
                {
                    $anno=$_POST['anno'];
                    $sezione=$_POST['sezione'];
                    $indirizzo=$_POST['indirizzo'];
                    $r=mysqli_query($conn,"UPDATE tabClassi SET anno='$anno', sezione='$sezione', indirizzo='$indirizzo' WHERE idClasse=$id;");
                    header("location:../tutor.php");
                }
                    $risultato=mysqli_query($conn,"SELECT * FROM tabClassi WHERE idClasse=$id;");
                 	$ind=mysqli_query($conn,"SELECT * FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo WHERE idClasse='$id';");
                    $indirizzi=mysqli_query($conn,"SELECT * FROM tabIndirizzi");
                    while($riga=mysqli_fetch_array($risultato)){
                        $a=$riga['anno'];
                        $s=$riga['sezione'];
                    }
                   ?>
                <!DOCTYPE html>
                <html>
                  <head>
                    <title>Modifica</title>
                    <!-- Carica i file CSS di Bootstrap -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <style>
                    	.form-group input{width:20%; text-align:center};
                        .submit{color:white, background-color:blue;};
                    </style>
                  </head>
                  <body>
                    <div class="container" align=center>
                      <h1 align=center>Modifica</h1><br><br>
                      <form action='' method=post>
                        <div class="form-group">
                         <select name="anno"  class="form-control" id="anno" style="width:20%; text-align:center;">
                        		<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
                            	<option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                          <!--<input type="text" class="form-control" id="anno" name="anno" value='<?php //echo $a ?>' placeholder="Anno">-->
                        </div>
                        <div class="form-group">
                        	<select name="sezione" class="form-control" id="sezione" style="width:20%; text-align:center;">
                        		<option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                            	<option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <div class="form-group">
                        	<label for="indirizzi">Indirizzi:</label>
                            <?php
                            	$riga2=mysqli_fetch_assoc($ind);
                            ?>
                            <select class="form-control" id="idIndirizzo" name="idIndirizzo">
                              <option value="<?php echo $riga2['idIndirizzo']; ?>"><?php echo $riga['nomeIndirizzo']; ?></option>
                              <?php
                                 while($r=mysqli_fetch_assoc($indirizzi)){
                                      echo "<option value='".$r['idIndirizzo']."'>".$r['nomeIndirizzo']."</option>";
                                 }
                               ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name='invia'>Invia</button>
                      </form>
                      <br>
                      <a href="../tutor.php" class="btn btn-secondary">Visualizza Elenco</a>
                    </div>
                    <!-- Carica i file JavaScript di Bootstrap -->
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                  </body>
                </html>

<?php

              }//CHUSURA modifica
                
         
        }// CHIUSURA CLASS
?>
