<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
    //echo "Hello " . $_SESSION['user'];
} else {
    header('Location: index.php');
    exit;
}

require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $minormax = $_POST['maxormin'];

}
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


            <table class="table table-striped table-bordered table-condensed"border="black">
                <tr>
                    <th>Destination</th>
                    <th>Average Seats by Location</th>
                </tr>
                <?php
                $result2 = RideshareDB::getInstance()->get_destination_ave_maximum_seats($minormax);
                while ($row = mysqli_fetch_array($result2)) {
                    echo "<tr><td>" . htmlentities($row['destination']) . "</td>";
                    echo "<td>" . htmlentities($row['avgSeats']) . "</td></tr>\n";
                }
                mysqli_free_result($result2);
                ?>
            </table>


            <table class="table table-striped table-bordered table-condensed" border="black">
                <tr>
                    <th>Destination</th>
                    <th>Average Seats by Location</th>
                </tr>
                <?php
                    $result = RideshareDB::getInstance()->get_destination_ave_seats();
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>" . htmlentities($row['destination']) . "</td>";
                    echo "<td>" . htmlentities($row['avgSeats']) . "</td></tr>\n";
                }
                mysqli_free_result($result);
                ?>
            </table>
