<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
    //echo "Hello " . $_SESSION['user'];
} else {
    header('Location: index.php');
    exit;
}

require_once("db.php");


if (!(RideshareDB::getInstance()->get_user_type($_SESSION['user']))){
    header('Location: driverhomepage.php');
    exit;
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
                            <a href="/driverhomepage.php">Home</a>
                        </li>
                        <li>
                            <a href="/ridesharelist.php">Rideshare List</a>
                        </li>
                        <li>
                            <a href="/logout.php"> Logout </a>
                        </li>
                </div>
            </nav>

            <div class="jumbotron">

                <h2><?php if (array_key_exists("user", $_SESSION)) {
                        echo "Hello " . $_SESSION['user'];
                    } ?>!</h2>

                <a href="ridesharelist.php" class="btn btn-primary">Find a Rideshare</a>

                <form role="form" class="form-group" method="POST" action="passengeraverageseats.php">
                    <h3>Find Destination with Min or Max Seats!</h3>
                    <select class="form-control" name="maxormin">
                        <option value=“MAX”>Max</option>
                        <option value=“MIN”>Min</option>
                    </select>

                    <button class="btn btn-default" type="submit">Find it!</button>
                </form>

            </div>

            <div class="col-md-12">
                <h3>Upcoming RideShares: </h3>
                <table class="table table-bordered" border="black">
                    <tr>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Price</th>
                        <th>Seats Left</th>
                    </tr>
                    <?php
                    $passengerID = RideshareDB::getInstance()->get_passenger_id_by_name($_SESSION['user']);
                    $result = RideshareDB::getInstance()->get_current_passengers_rideshares($passengerID);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr><td>" . htmlentities($row['rdate']) . "</td>";
                        echo "<td>" . htmlentities($row['destination']) . "</td>";
                        echo "<td>" . htmlentities($row['price']) . "</td>";
                        echo "<td>" . htmlentities($row['seatsLeft']) . "</td></tr>\n";

                    }
                    mysqli_free_result($result);
                    ?>
                </table>


                <h3>Past RideShares: </h3>

                <table class="table table-bordered" border="black">
                    <tr>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Price</th>
                    </tr>
                    <?php
                    $passengerID = RideshareDB::getInstance()->get_passenger_id_by_name($_SESSION['user']);
                    $result = RideshareDB::getInstance()->get_past_passengers_rideshares($passengerID);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr><td>" . htmlentities($row['rdate']) . "</td>";
                        echo "<td>" . htmlentities($row['destination']) . "</td>";
                        echo "<td>" . htmlentities($row['price']) . "</td></td></tr>\n";
                    }
                    mysqli_free_result($result);
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

</body>


</html>
