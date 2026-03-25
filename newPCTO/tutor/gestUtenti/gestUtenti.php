<?php

	class gestUtenti{
    
       public function insUtente(){
       		
            if(isset($_POST["invia"])){
            	include_once("config.php");
            	$email=$_POST['email'];
                $password=$_POST['password'];
                $password1=$_POST['password1'];
                $ruolo=$_POST['ruolo'];
                $nome=$_POST['nome'];
                $cognome=$_POST['cognome'];
                
                if($password==$password1){
                	mysqli_query($conn,"INSERT INTO tabUtenti(idUtente,cognome,nome,email,password,ruolo)values(null,'$cognome','$nome','$email','$password','$ruolo');");
        			header('location:../tutor.php');
                }
                else{
                	echo "<script language='Javascript'>
                    		alert('Le password non coincidono, reinserire!');
                            window.location.href = '../tutor.php';
                          </script>";
            	}
            }
            else{
?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Login Form</title>
                    <!-- Bootstrap CSS -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
                </head>
                <body>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-8 col-sm-10">
                                <div class="card mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center">REGISTRATI</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email address</label>
                                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password1" class="form-label">Conferma password</label>
                                                <input type="password" class="form-control" id="password1" name="password1" placeholder="Conferma password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nome" class="form-label">Nome</label>
                                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Enter name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="cognome" class="form-label">Cognome</label>
                                                <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Enter surname">
                                            </div>
                                            <div class="mb-3">
                                                <label for="ruolo" class="form-label">Ruolo</label>
                                                <select class="form-select" id="ruolo" name="ruolo">
                                                    <option value="">Scegli un ruolo</option>
                                                    <option value="tutor">Tutor</option>
                                                    <option value="docente">Docente</option>
                                                    <option value="esperto">Esperto</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block" name="invia">REGISTRATI</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bootstrap Bundle with Popper JS -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
                </body>
                </html>
<?php
            }
       }
        public function index(){
        include_once("gestUtenti/config.php");
        $risultato=mysqli_query($conn,"SELECT * FROM tabUtenti ORDER BY email;");
    ?>
            <!DOCTYPE html>
            <html>
            <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
            <body>

                <div class="container">
                <a href="gestUtenti/inserisci.php" class="btn btn-primary">Inserisci nuovo utente</a><br><br>
                    <table class="table table-bordered" id='tabella'>
                        <thead>
                            <tr>
                                <th>Cognome</th>
                                <th>Nome</th>
                                <th>Ruolo</th>
                                <th>Email</th>
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
                    <td><?php echo $riga['ruolo']; ?></td>
                    <td><?php echo $riga['email']; ?></td>
                    <td><a href="gestUtenti/cancella.php?id=<?php echo $riga['idUtente']; ?>" onclick='return confirm("Sei sicuro di voler eliminare?");'><img style="width:50px; height:50px" src="../images/trashbin.png"></a></td>
                    <td><a href='gestUtenti/modifica.php?id=<?php echo $riga['idUtente']; ?>'><img style="width:50px; height:50px" src="../images/pen.png"></a></td>
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
        }//chiusura metodo index

       public function cancella()
       {
       		include_once("config.php");
            $id=$_GET['id'];
            $risultato=mysqli_query($conn,"DELETE FROM tabUtenti WHERE idUtente=$id;");
            header("location:../tutor.php");
       }
       
      public function modifica(){
        include_once("config.php");
        $id=$_GET['id'];
        if(isset($_POST['invia'])){
            $email=$_POST['email'];
            $password=$_POST['password'];
            $ruolo=$_POST['ruolo'];
            $cognome=$_POST['cognome'];
            $nome=$_POST['nome'];
            mysqli_query($conn,"UPDATE tabUtenti SET email='$email',password='$password',nome='$nome',cognome='$cognome',ruolo='$ruolo' WHERE idUtente=$id;");
            header('location:../tutor.php');
    	}
        else
        {
            $risultato=mysqli_query($conn,"SELECT * FROM tabUtenti WHERE idUtente=$id;");
            $riga=mysqli_fetch_array($risultato);

        // Include Bootstrap stylesheet
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
                        <h2>Modifica Utenti</h2>
                        <form action='' method='post'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-Mail</label>
                                    <input type="text" name='email' value='<?php echo $riga['email']; ?>' class="form-control" id="email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="text" name='password' value='<?php echo $riga['password']; ?>' class="form-control" id="password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cognome">Cognome</label>
                                    <input type="text" name='cognome' value='<?php echo $riga['cognome']; ?>' class="form-control" id="cognome">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" name='nome' value='<?php echo $riga['nome']; ?>' class="form-control" id="nome">
                                </div>
                            </div>
                            <div class='form-group'>
                                  <label for='ruolo'>Ruolo:</label>
                                  <select class='form-control' id='ruolo' name='ruolo'>
                                      <option value='tutor'>tutor</option>
                                      <option value='docente'>docente</option>
                                      <option value='esperto'>esperto</option>
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
    }
}

    	
    }//chiusura classe
    $oggetto=new gestUtenti();


?>
