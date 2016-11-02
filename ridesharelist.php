<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
    //echo "Hello " . $_SESSION['user'];
} else {
    header('Location: index.php');
    exit;
}

require_once("db.php");



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
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
                        echo "Hello " . $_SESSION['user'];
                    } ?>!</h2>


               

            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Search</h3>

                    <div class="form-group">
                        <form role="form" action="searchridesharelist.php" method="POST">
                        <input type="text" class="form-control" name="Driver" placeholder="Enter a driver here....">
                            <input type="text" class="form-control" name="Color" placeholder="Enter a car color here....">
                            <input type="text" class="form-control" name="Destination" placeholder="Enter a destination here....">

                        <button class="btn btn-default" type="submit">Search</button>
                        </form>
                    </div>

                    <div>
                        <h3>Available RideShares</h3>

                        <table class="table table-bordered" border="black">
                            <tr>
                                <th>Date</th>
                                <th>Driver Name</th>
                                <th>Color</th>
                                <th>Destination</th>
                                <th>Price</th>
                                <th>Seats Left</th>
                                <th>Link</th>
                            </tr>
                            <?php
                            //$result = RideshareDB::getInstance()->search($Driver, $Destination, $Color, $SeatsLeft, $Order);

                            $result = RideshareDB::getInstance()->get_available_rideshares();
                            while ($row = mysqli_fetch_array($result)) {
                                $RideID = $row['RID'];
                                echo "<tr><td>" . htmlentities($row['rdate']) . "</td>";
                                echo "<td>" . htmlentities($row['name']) . "</td>";
                                echo "<td>" . htmlentities($row['color']) . "</td>";
                                echo "<td>" . htmlentities($row['destination']) . "</td>";
                                echo "<td>" . htmlentities($row['price']) . "</td>";
                                echo "<td>" . htmlentities($row['seatsLeft']) . "</td>";
                                echo "<td>" . htmlentities("") . "<a href=\"rideshareinfo.php?RideID=$RideID\">Go</a>" . "</td>";

                            }
                            mysqli_free_result($result);
                            ?>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>


