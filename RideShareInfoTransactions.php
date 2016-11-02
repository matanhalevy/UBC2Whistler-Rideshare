<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
} else {
    header('Location: index.php');
    exit;
}

require_once("db.php");

$RideID = $_GET['RideID'];



if ($_SERVER['REQUEST_METHOD'] == "POST") {


    RideshareDB::getInstance()->update_destination($_POST['location'], $RideID);

    $Dest = RideshareDB::getInstance()->get_rideshare_byid($RideID);
    $D = $Dest->fetch_assoc();
    $Dest1 = $D['destination'];

    if ($_POST['location'] = $Dest1){
        echo " destination changed to " . $_POST['location'];
    } else {
        echo "update failed: invalid destination";
    }

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
                        echo "Here's your RideShare Info ". $_SESSION['user'];
                    } ?>!</h2>

            </div>

            <div>

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
                } else {
                    echo "0 results";
                }

                ?>
            </table>
        </div>

        <h3>Change destination to:</h3>

        <div class="form-group">
            <form role = "form" name="updaterideshare" action="rideshareinfoTransactions.php?RideID=<?php echo $RideID; ?>" method="POST">
                <input type="text" name="location" value="<?php echo $Destination; ?>"/>
                <input type="submit" name="test" value="Update"/>
            </form>
        </div>

        <div>
        <h3>RideShare Passenger & Transaction Method:</h3>


        <table class = "table table-striped table-bordered table-condensed" border="black">
            <tr>
                <th>Passenger Name</th>
                <th>Price</th>
                <th>Payment Method</th>

            </tr>
            <?php

            $result = RideshareDB::getInstance()->get_rideshare_transactions($RideID);

                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlentities($row['name']) . "</td>";
                    echo "<td>" . htmlentities($row['price']) . "</td>";
                    echo "<td>" . htmlentities($row['Type']) . "</td></tr>\n";
                }

            // mysqli_free_result($result);
            ?>

        </table>
    </div>
</div>


</body>


</html>



