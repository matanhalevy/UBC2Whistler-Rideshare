<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
    //echo "Hello " . $_SESSION['user'];
} else {
    header('Location: index.php');
    exit;
}

require_once("db.php");

if (RideshareDB::getInstance()->get_user_type($_SESSION['user'])){
    header('Location: passengerhomepage.php');
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

                <h2><?php echo "Hello " . $_SESSION['user'];?>!</h2>

                <a href="createrideshare.php" class="btn btn-primary">Create Rideshare</a>

                <?php
                    $driverID = RideshareDB::getInstance()->get_driver_id_by_name($_SESSION['user']);
                    $maxprice = RideshareDB::getInstance()->get_max_price_driver($driverID);
                    $aveprice = RIDESHAREDB::getInstance()->get_ave_price_driver($driverID);
                    $minprice = RideshareDB::getInstance()->get_min_price_driver($driverID);
                    ?>
                    <p></p>
                    <h4> Stats: </h4><p></p> <h5>
                    <?php echo "Most expensive Rideshare: $" . $maxprice; ?> <p></p>
                    <?php echo "Least expensive Rideshare: $" . $minprice; ?> <p></p>
                    <?php echo "Average price of Rideshares: $" . $aveprice; ?>
                    </h5>

                    
            </div>
            <div class="col-md-12">
                <h3>Ongoing RideShares: </h3>
                <table class="table table-bordered" border="black">
                    <tr>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Price</th>
                        <th>Seats Left</th>
                        <th>Seats</th>
                        <th>Link</th>
                        <th></th>
                    </tr>
                    <?php
                    
                    $result = RideshareDB::getInstance()->get_current_drivers_rideshares($driverID);
                    while ($row = mysqli_fetch_array($result)) {
                        $RideID = $row['RID'];
                        echo "<tr><td>" . htmlentities($row['rdate']) . "</td>";
                        echo "<td>" . htmlentities($row['destination']) . "</td>";
                        echo "<td>" . htmlentities($row['price']) . "</td>";
                        echo "<td>" . htmlentities($row['seatsLeft']) . "</td>";
                        echo "<td>" . htmlentities($row['seats']) . "</td>";
                        echo "<td>" . htmlentities("") . "<a href=\"rideshareinfoTransactions.php?RideID=$RideID\">Go</a>" . "</td>";
                        ?>
                    <td>
                    <form name= "delete" action="deleteRS.php" method="POST">
                        <input type="hidden" name="RID" value="<?php echo $RideID;?>" />
                        <input type="submit" name="deleteRS" value="Delete">
                    </form>
                    </td>

                    <?php
                        echo "<\tr>\n";



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
                        <th>Seats Left</th>
                        <th>Seats</th>
                        <th>Link</th>
                    </tr>
                    <?php
                    $driverID = RideshareDB::getInstance()->get_driver_id_by_name($_SESSION['user']);
                    $result = RideshareDB::getInstance()->get_past_drivers_rideshares($driverID);
                    while ($row = mysqli_fetch_array($result)) {
                        $RideID = $row['RID'];
                        echo "<tr><td>" . htmlentities($row['rdate']) . "</td>";
                        echo "<td>" . htmlentities($row['destination']) . "</td>";
                        echo "<td>" . htmlentities($row['price']) . "</td>";
                        echo "<td>" . htmlentities($row['seatsLeft']) . "</td>";
                        echo "<td>" . htmlentities($row['seats']) . "</td>";
                        echo "<td>" . htmlentities("") . "<a href=\"rideshareinfoTransactions.php?RideID=$RideID\">Go</a>" . "</td>";

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


