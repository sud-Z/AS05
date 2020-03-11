<?php


// Start or resume session, and create: $_SESSION[] array
session_start(); 

require 'database.php';

if ( !empty($_POST)) { // if $_POST filled then process the form

	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	// echo $password . " " . $passwordhash; exit();
	// robot 87b7cb79481f317bde90c116cf36084b
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM players WHERE email = ? AND password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		echo "success!";
		$_SESSION['player_id'] = $data['id'];
		$sessionid = $data['id'];
		$_SESSION['player_name'] = $data['fname'];
		Database::disconnect();
		header("Location: home.php?id=$sessionid");
		// javascript below is necessary for system to work on github
		echo "<script type='text/javascript'> document.location = 'home.php'; </script>";
		exit();
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: login_error.html");
	}
} 
// if $_POST NOT filled then display login form, below.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
  
	<link rel="icon" href="https://p0.pikrepo.com/preview/457/230/disc-golf-frisbee-golf.jpg" type="image/png" />

</head>

<body>
    <div class="container">

		<div class="span10 offset1">
		
		  <!--
			<div class="logo">
				<img class="logo" src="https://p0.pikrepo.com/preview/457/230/disc-golf-frisbee-golf.jpg" />
			</div>
			-->
			
			<!--
			<div class="row">
				<br />
				<p style="color: red;">System temporarily unavailable.</p>
			</div>
			-->

			<div class="row">
				<h3>Disc Golf Player Login</h3>
			</div>

			<form class="form-horizontal" action="login.php" method="post">
								  
				<div class="control-group">
					<label class="control-label">Username (Email)</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="me@email.com" required> 
					</div>	
				</div> 
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="not your SVSU password, please" required> 
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="player_create.php">Join (New Player)</a>
				</div>
				
				<p><strong>Dear All</strong>: Thank you for joining our disc golf community. With your help we hope to grow the disc golf scene here at SVSU with friendly competition and exibition matches.</p>
				<p><strong>Dear NEW Players</strong>: Please register by clicking the blue "Join" button above.</p>
				<p><strong>Dear Registered Players</strong>: To log in, use your email address and password, and click the green "sign in" button.</p>
				<p><strong>Regarding passwords</strong>: Please create a new unique password for this site. <strong><em><span style="color: red;">Please do not use your regular SVSU password.</span><em></strong> If you forgot your password, to RE-SET your password for this site email "re-set password" to: Nicholas Ciesla, naciesla@svsu.edu.</p>
				
				<br />
				
				<footer>
					<small>&copy; Copyright 2020, Nicholas Ciesla
					</small>
				</footer>
				
			</form>


		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>
