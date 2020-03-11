<?php 
session_start();
if(!isset($_SESSION["player_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}
$id = $_SESSION['player_id']; // for MyAssignments
$sessionid = $_SESSION['player_id'];
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
        
        <div style="padding-top:25px;" class="row">
        <p>
            <a href="create_disc_event.php" class="btn btn-success">Create Event</a>
            <a href="disc_player_list.php" class="btn btn-primary">View Player List</a>
        </p>
        </div>
    
        
            <div class="row">
                <h3>Disc Golf Events</h3>
            </div>
            <div class="row">
               
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Event Date</th>
                          <th>Event Time</th>
                          <th>Event Location</th>
                          <th>Host First Name</th>
                          <th>Host Last Name</th>
                          <th>Host Email</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM disc_events 
						LEFT JOIN players ON players.id = disc_events.event_creator_id 
						ORDER BY disc_event_date ASC, disc_event_time ASC, lname ASC;';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['disc_event_date'] . '</td>';
                                echo '<td>'. $row['disc_event_time'] . '</td>';
                                echo '<td>'. $row['disc_event_location'] . '</td>';
                                echo '<td>'. $row['fname'] . '</td>';
                                echo '<td>'. $row['lname'] . '</td>';
                                echo '<td>'. $row['email'] . '</td>';
                                echo '<td width=250>';
                                
                                echo '<a class="btn" href="assign_read.php?id='.$row[0].'">Who is Going?</a>';
                                echo ' ';
                                
                                if($id == $row['event_creator_id']){
                                    echo '<a class="btn btn-success" href="assign_update.php?id='.$row[0].'">Update</a>';
                                    echo ' ';
                                    echo '<a class="btn btn-danger" href="assign_delete.php?id='.$row[0].'">Delete</a>';
                                }
                                if($id != $row['event_creator_id'])
                                {
                                    echo '<a class="btn btn-primary" href="assign_read.php?id='.$row[0].'">RSVP</a>';
                                }
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
		
    	

    </div> <!-- end div: class="container" -->
	
</body>
</html>
