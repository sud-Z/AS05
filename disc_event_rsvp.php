<?php 

    session_start();
    if(!isset($_SESSION["player_id"])){ // if "user" not set,
	   session_destroy();
	   header('Location: login.php');   // go to login page
	   exit;
    }
    $playerid = $_SESSION['player_id']; // for MyAssignments
    $sessionid = $_SESSION['player_id'];
    
	require 'database.php';
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	

 if ( !empty($_POST)) {
    $insert = true;
    $id = $_POST['id'];
	$pdo = Database::connect();	
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT * FROM disc_rsvp
	WHERE disc_event_id=' .$id.'';
    foreach ($pdo->query($sql) as $row) {
        
        if($row['disc_player_id'] == $playerid) {
            $insert = false;
        }   
    
    }

    if($insert){
        
	   $sql = "INSERT INTO disc_rsvp (disc_event_id,disc_player_id) values(?, ?)";
	   $q = $pdo->prepare($sql);
	   $q->execute(array($id,$playerid));
	   Database::disconnect();
	   header("Location: disc_event_list.php");
    }
    else{
        
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('You have already RSVPed for this event!');
    window.location.href='disc_event_list.php';
    </script>");
    }
 }
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
   <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>RSVP</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="disc_event_rsvp.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure you want to RSVP?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="disc_event_list.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
