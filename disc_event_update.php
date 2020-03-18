<?php 

    session_start();
    if(!isset($_SESSION["player_id"])){ // if "user" not set,
     	session_destroy();
    	header('Location: login.php');   // go to login page
	    exit;
   }
   
$playerid = $_SESSION['player_id']; // for MyAssignments
$sessionid = $_SESSION['player_id'];

$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$disc_event_dateError = null;
		$disc_event_timeError = null;
		$disc_event_locationError = null;
		$disc_event_descriptionError = null;
		
		// keep track post values
		$disc_event_date = $_POST['date'];
		$disc_event_time = $_POST['time'];
		$disc_event_location = $_POST['location'];
		$disc_event_description = $_POST['description'];
		
		// validate input
		$valid = true;
		if (empty($disc_event_date)) {
			$disc_event_dateError = 'Please enter Date';
			$valid = false;
		}
		
		if (empty($disc_event_time)) {
			$disc_event_timeError = 'Please enter Time';
			$valid = false;
		}
		
		if (empty($disc_event_location)) {
			$disc_event_locationError = 'Please enter Location';
			$valid = false;
		}
		
		if (empty($disc_event_description)) {
			$disc_event_descriptionError = 'Please enter Description';
			$valid = false;
		}
		
		// update data
				if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE disc_events set disc_event_date = ?, disc_event_time = ?, disc_event_location =?, disc_event_description =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($disc_event_date,$disc_event_time,$disc_event_location,$disc_event_description,$id));
			Database::disconnect();
			header("Location: disc_event_list.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM disc_events where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$disc_event_date = $data['disc_event_date'];
		$disc_event_time = $data['disc_event_time'];
		$disc_event_location = $data['disc_event_location'];
		$disc_event_description = $data['disc_event_description'];
		Database::disconnect();
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
		    			<h3>Update a Disc Golf Event</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="disc_event_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="date" type="date"  placeholder="Date" value="<?php echo !empty($disc_event_date)?$disc_event_date:'';?>">
					      	<?php if (!empty($disc_event_dateError)): ?>
					      		<span class="help-inline"><?php echo $disc_event_dateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($disc_event_timeError)?'error':'';?>">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<input name="time" type="time" placeholder="Time" value="<?php echo !empty($disc_event_time)?$disc_event_time:'';?>">
					      	<?php if (!empty($disc_event_timeError)): ?>
					      		<span class="help-inline"><?php echo $disc_event_timeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($disc_event_locationError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="location" type="text"  placeholder="Location" value="<?php echo !empty($disc_event_location)?$disc_event_location:'';?>">
					      	<?php if (!empty($disc_event_locationError)): ?>
					      		<span class="help-inline"><?php echo $disc_event_locationError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($disc_event_descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="description" type="text"  placeholder="Description" value="<?php echo !empty($disc_event_description)?$disc_event_description:'';?>">
					      	<?php if (!empty($disc_event_descriptionError)): ?>
					      		<span class="help-inline"><?php echo $disc_event_descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="disc_event_list.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
