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
    
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    
    if ( null==$id ) {
        header("Location: disc_event_list.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        # get assignment details
        $sql = "SELECT disc_rsvp.disc_player_id, players.id, players.fname, players.lname, players.filecontent 
        FROM disc_rsvp
        INNER JOIN players ON disc_rsvp.disc_player_id = players.id";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetchAll();
        //print_r ($data);
    
        /*# get volunteer details
        $sql = 'SELECT * FROM players where id = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($data['disc_player_id']));
        $perdata = $q->fetchAll();*/

        # get event details
        $sql = "SELECT * FROM disc_events where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $eventdata = $q->fetch(PDO::FETCH_ASSOC);
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
                        <h3>Event Details</h3>
                    </div>
                     <div class="form-horizontal" >
                     
                      <div class="control-group">
                        <label class="control-label">Event Location:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($eventdata['disc_event_location']);?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Event Date:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($eventdata['disc_event_date']);?>
                            </label>
                        </div>
                      </div>
                       <div class="control-group">
                        <label class="control-label">Event Description:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($eventdata['disc_event_description']);?>
                            </label>
                        </div>
            <div class="row">
                <h3>Competitor List</h3>
            </div>
            <div class="row">
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Profile Pic</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       foreach ($data as $p) {
                           if($p['id'] == $id){
                                echo '<tr>';
                                echo '<td><img width=100 src="data:image/jpeg;base64,'. base64_encode( $p['filecontent']).'"/> </td>'; 
                                echo '<td>'. $p['fname'] . '</td>';
                                echo '<td>'. $p['lname'] . '</td>';
                                echo '</tr>';
                           }
                       }
                       //Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
                      </div>
                        <div class="form-actions">
                          <a class="btn" href="disc_event_list.php">Back</a>
                       </div>
                         </div>
                         
                     
                 
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
