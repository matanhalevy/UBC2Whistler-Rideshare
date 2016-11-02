<?php
session_start();
require_once("db.php");


$link = mysqli_connect('databasic.cvhyllwoxxb3.us-west-1.rds.amazonaws.com', 'DataBasicTeam', 'CPSC304!');
if (!mysqli_ping($link)) {
    die('Not connected : ' . mysqli_error());
}

$RideID = $_GET['RideID'];
$CPID = RideshareDB::getInstance()->get_passenger_id_by_name($_SESSION['user']);


   if (RideshareDB::getInstance()->check_participates($CPID, $RideID)->num_rows > 0){
       echo "you're already in this rideshare!";
   } else {
       if ($_SERVER['REQUEST_METHOD'] == "POST") {

           RideshareDB::getInstance()->create_participates($CPID, $RideID, $_POST['type']);
           echo "you have successfully joined the rideshare!";
   }

    //exit;

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                            class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Rideshare App</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="passengerhomepage.php">Home</a>
                        </li>
                        <li>
                            <a href="/ridesharelist.php">Rideshare List</a>
                        </li>
                </div>
            </nav>

            <div class="jumbotron">
                <h2><?php if (array_key_exists("user", $_SESSION)) {
                        echo "Hello " . $_SESSION['user'];} ?>! </h2>
                    </div>

                    <div>
                        <h3>Rideshare Info</h3>

                        <table class = "table table-striped table-bordered table-condensed" border="black">
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Driver Name</th>
                                <th>Destination</th>
                                <th>PickUp</th>
                                <th>Price</th>
                                <th>Seats</th>
                                <th>Seats Left</th>
                            </tr>

                            <?php

                            $result = RideshareDB::getInstance()->get_rideshare_byid($RideID);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . htmlentities($row['rdate']) . "</td>";
                                    echo "<td>" . htmlentities($row['rtime']) . "</td>";
                                    echo "<td>" . htmlentities($row['name']) . "</td>";
                                    echo "<td>" . htmlentities($row['destination']) . "</td>";
                                    echo "<td>" . htmlentities($row['address']) . "</td>";
                                    echo "<td>" . htmlentities($row['price']) . "</td>";
                                    echo "<td>" . htmlentities($row['seats']) . "</td>";
                                    echo "<td>" . htmlentities($row['seatsLeft']) . "</td></tr>\n";
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <div>
                        <form role = "form" name="joinRideshare" action="rideshareinfo.php?RideID=<?php echo $RideID; ?>" method="POST">
                            <h3> Select payment type: </h3>
                                <select class = "form-control" name="type">
                                    <option value="cash">Cash</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                                <input type="submit" name="joinit" value="Join">
                            </form>
                    </div>
                </body>

</html>


