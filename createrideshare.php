<?php
session_start();
require_once("db.php");

// Get POST variables
$DID = RideshareDB::getInstance()->get_driver_id_by_name($_SESSION['user']);
// $DID = '1';
$postalCode = $_POST['postalCode'];
$destination = $_POST['destination'];
$price = $_POST['price'];
$address = $_POST['address'];
$rdate = $_POST['rdate']; // format_date_for_sql()
$rtime = $_POST['rtime'];
date_default_timezone_set('America/Vancouver');
$mySql_rtime = date('H:i:s',strtotime($rtime));
$seats = $_POST['seats'];
$seatsLeft = $seats;
$city = $_POST['city'];
$province = $_POST['province'];


if ($_SERVER['REQUEST_METHOD'] == "POST"){

    if ($seats > 0) {

        RideshareDB::getInstance()->create_rideshare($DID, $postalCode,
            $destination, $price, $address, $rdate, $mySql_rtime, $seats, $seatsLeft, $city, $province);

        header('Location: driverhomepage.php');
        exit;
    } else {
        echo "Seats must be greater than 0";
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

    <title>Create a new rideshare</title>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button> <a class="navbar-brand" href="index.php">Rideshare App</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/driverhomepage.php">Home</a>
                        </li>
                        <li>
                            <a href="/ridesharelist.php">Rideshare List</a>
                        </li>
                </div>

            </nav>

            <div class = "jumbotron">

<form role = "form" name="createRideshare" action="createrideshare.php" method="POST">
    <h1>New RideShare</h1>

    <div class = "form-group">
        <label for = "Destination:">
            Destination:
        </label>
        <input class = "form-control" type="text" name = "destination" required/>
    </div>

    <div class = "form-group">
        <label for = "Price:">
            Price:
        </label>
        <input class = "form-control" type="text" name="price" required/>
    </div>

    <div class = "form-group">
        <label for = "Address:">
            Address:
        </label>
        <input class = "form-control" type="text" name="address" required/>
    </div>

    <div class = "form-group">
        <label for = "Postal Code:">
            Postal Code:
        </label>
        <input class = "form-control" type="text" name="postalCode" required/>
    </div>

    <div class = "form-group">
        <label for = "Province:">
            Province:
        </label>
        <input class = "form-control" type="text" name="province" required/>
    </div>

    <div class = "form-group">
        <label for = "City:">
            City:
        </label>
        <input class = "form-control" type="text" name="city" required/>
    </div>

    <div class = "form-group">
        <label for = "Departure Date:">
            Departure Date: (Month Date(DD), Year(YYYY))
        </label>
        <input class = "form-control" type="text" name="rdate" required/>
    </div>

    <div class = "form-group">
        <label for = "Departure Time:">
            Departure Time: (HH : MM : AM/PM)
        </label>
        <input class = "form-control" type="time" name="rtime" required/>
    </div>

    <div class = "form-group">
        <label for = "Seats: ">
            Seats:
        </label>
        <input class = "form-control" type="text" name="seats" required/>
    </div>

    <input type="submit" value="Create New Rideshare" class = "btn btn-dfault"><br>
</form>
</body>
</html>
