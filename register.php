<?php 
	session_start();
	include("cpnl/classes/DB.php");
	include("cpnl/classes/Users.php"); 
	$db = new DB();
	$user = new Users($db); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Re-Ticket - Create New Account</title>
        <link href="cpnl/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
		<style>
			.bg-primary2 {
				background-color: #242D4C;
				
			}
		</style>
    </head>
    <body class="bg-primary2">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
									<div class="col-lg-12 ">
										<div style="width: 50%; margin-left: auto; margin-right: auto">
											<a href="index.php">
											<img src="cpnl/images/logo.jpeg" style="width: 100%;"   /></a> 
										</div>
									</div>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create New Account</h3></div>
                                    <div class="card-body">
										<h4>Please fill all fields</h4>
								<?php
									 
									$fname = isset($_POST['fname'])?$_POST['fname']:""; 
									$lname = isset($_POST['lname'])?$_POST['lname']:""; 
									$username = isset($_POST['username'])?$_POST['username']:""; 
									$phone = isset($_POST['phone'])?$_POST['phone']:""; 
									$email  = isset($_POST['email'])?$_POST['email']:"";
									$password = isset($_POST['password'])?$_POST['password']:""; 
									
									$errLogin = false;
									if(isset($_POST['email']) && isset($_POST['password']) )
									{
										if($user->addUser($fname, $lname, $email, $phone, $username , $password ))
										{ 
											echo "<div class='info'>Your account have successfully created</div>";
											echo "<div class='info'><a href='login.php'>Click here to login</a>.</div>";
										}else{
											echo "<div class='info'>Could not create your account.</br>
														<a href='register.php' class='btn btn-lg btn-success btn-block'>Please try again</a>
													</div>"; 
											
										}
									}else{
										  
								?>
                                        <form action="" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputFName" type="text" name="fname"  required />
                                                <label for="inputFName">First Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputLName" type="text" name="lname"  required />
                                                <label for="inputLName">Last Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputUserName" type="text" name="username"  required />
                                                <label for="inputUserName">User Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPhone" type="phone" name="phone" required />
                                                <label for="inputPhone">Phone</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password"  name="password" placeholder="Password" required />
                                                <label for="inputPassword">Password</label>
                                            </div>   
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0"> 
                                                <button class="btn btn-primary" href="register.php">Create Account</button>
                                            </div>
											<p>Have an account? <a href="login.php">Sign in now</a></p>
											<p> <a href="index.php">Back Home</a></p>
                                        </form>
										
										<?php 
									}
										?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="cpnl/js/scripts.js"></script>
    </body>
</html>
