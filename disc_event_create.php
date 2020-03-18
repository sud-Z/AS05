<?php 

session_start();
if(!isset($_SESSION["player_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
	
require 'database.php';

$playerid = $_SESSION['player_id'];
$sessionid = $_SESSION['player_id'];

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
		
		// insert data
	if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO disc_events (disc_event_date,disc_event_time,disc_event_location,disc_event_description, event_creator_id) values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($disc_event_date,$disc_event_time,$disc_event_location,$disc_event_description, $playerid));
			Database::disconnect();
			header("Location: disc_event_list.php");
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
		    			<h3>Create an Event</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="disc_event_create.php" method="post">
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="date" type="date"  placeholder="Date" value="<?php echo !empty($date)?$date:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<input name="time" type="time" placeholder="Time" value="<?php echo !empty($time)?$time:'';?>">
					      	<?php if (!empty($timeError)): ?>
					      		<span class="help-inline"><?php echo $timeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
					    <label class="control-label">Location</label>
					    <div class="controls">
					      	<input name="location" type="text"  placeholder="Location" value="<?php echo !empty($location)?$location:'';?>">
					      	<?php if (!empty($locationError)): ?>
					      		<span class="help-inline"><?php echo $locationError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					   <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="description" type="text"  placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="disc_event_list.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
