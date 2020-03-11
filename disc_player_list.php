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
            <a href="disc_event_list.php" class="btn btn-success">Back</a>
        </p>
        </div>
	    
	    <div class="row">
                <h3>Player List</h3>
            </div>
            <div class="row">
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Profile Pic</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email Address</th>
                          <th>Mobile Number</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM players ORDER BY id DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td><img width=100 src="data:image/jpeg;base64,'. base64_encode( $row['filecontent']).'"/> </td>'; 
                                echo '<td>'. $row['fname'] . '</td>';
                                echo '<td>'. $row['lname'] . '</td>';
                                echo '<td>'. $row['email'] . '</td>';
                                echo '<td>'. $row['mobile'] . '</td>';
                                echo '<td width=225>';
                                echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
                                echo ' ';
                                if($id == $row['id']){
                                    echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                                    echo ' ';
                                    echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
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
