<?php
	class Login{
    	
        public function accedi(){
        
        	include_once("config.php");
        	if(isset($_POST['invia'])){
    			$email=$_POST['email'];
        		$password=$_POST['password'];
        		$ruolo=$_POST['ruolo'];
        		
                $email=filter_var($email, FILTER_SANITIZE_EMAIL);
                $password=filter_var($password, FILTER_SANITIZE_STRING);
                $ruolo=filter_var($ruolo, FILTER_SANITIZE_STRING);
        		$risultato=mysqli_query($conn,"SELECT * FROM tabUtenti");
        		while($riga=mysqli_fetch_array($risultato)){
            		if(trim($email)==trim($riga['email']) && trim($password)==trim($riga['password']) && trim($ruolo)==trim($riga['ruolo'])){
            			session_start();
                        if($ruolo=='tutor'){
                        	$_SESSION['accedi']=$riga['nome'];
							$nome='cookie_tutor';
							$valoreCookie=$email;
							$scadenza=time() + (600);
							setcookie($nome,$valoreCookie,$scadenza,"/");
                        	header('location:tutor/tutor.php');
                        }
                        else if($ruolo=='docente'){
                        	$_SESSION['accedi']=$riga['nome'];
							$nome='cookie_docente';
							$valoreCookie=$email;
							$scadenza=time() + (600);
							setcookie($nome,$valoreCookie,$scadenza,"/");
                        	header('location:docente/docente.php');
                        }
                        else{
                        	$_SESSION['accedi']=$riga['nome'];
							$nome='cookie_esperto';
							$valoreCookie=$email;
							$scadenza=time() + (600);
							setcookie($nome,$valoreCookie,$scadenza,"/");
                        	header('location:esperto/esperto.php');
                        }
                	}
            	}
                
        	}//chiusura isset
    		else{
            ?>
			<!DOCTYPE html>
            <html>
            <head>
                <title>Login Form</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            </head>
            <body>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                  Accedi alla piattaforma
                                </div>
                                <div class="card-body">
                                    <form action='' method='post'>
                                        <div class="form-group">
                                            <label for="email">Indirizzo E-mail</label>
                                            <input type="email" name='email' class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name='password' class="form-control" id="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="user-type">Ruolo:</label>
                                            <select class="form-control" id="user-type" name='ruolo'>
                                                <option value="docente">Docente</option>
                                                <option value="esperto">Esperto</option>
                                                <option value="tutor">Tutor</option>
                                            </select>
                                        </div>
                                        <button type="submit" name='invia' class="btn btn-primary">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </body>
            </html>
            <?php
   			}//chiusura else
		}//chiusura metodo login
        
        public function logout(){
        	session_start();
        	session_unset();
        	session_destroy();
    		header('location:index.php');
        }//chiusura metodo logout

		public function sessioneScaduta(){
			echo "sessione scaduta!"."<br>";
			echo "<a href='logout.php'>Effettua il login</a>";
		}
        
    }//chiusura classe
    $oggetto=new Login();
?>
