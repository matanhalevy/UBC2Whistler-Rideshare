<?php
require_once("db.php");
$logonSuccess = false;

// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (RideshareDB::getInstance()->verify_user_credentials($_POST['user'], $_POST['password']));
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        // $_SESSION['PID'] = RideshareDB::getInstance()->get_passenger_id_by_name($_SESSION['user']);

        if (RideshareDB::getInstance()->get_user_type($_POST['user'])){
            header('Location: passengerhomepage.php');
            exit;
        }
        header('Location: driverhomepage.php');
        exit;
    }
}

?>

<!DOCTYPE HTML>
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

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button> <a class="navbar-brand" href="index.php">Rideshare App</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="/ridesharelist.php">Rideshare List</a>
                        </li>
                </div>

            </nav>

            <div class="jumbotron">
                <h2>
                    Welcome to our app!
                </h2>
                <p>
                    This is a ridesharing app build for CPSC 304.
                </p>

                <p>

                    <a href="createdriver.php" class="btn btn-primary">Create Driver</a>
                    <a href="createpassenger.php" class="btn btn-primary">Create Passenger</a>
                </p>


                    <form role="form" name="logon" action="index.php" method="POST">
                        <div class="form-group">

                            <label for="exampleInputEmail1">
                                Username
                            </label>
                            <input type="text" class="form-control" name="user" id="exampleInputEmail1" />
                        </div>
                        <div class="form-group">

                            <label for="exampleInputPassword1">
                                Password
                            </label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1" />
                        </div>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            if (!$logonSuccess)
                                echo "Invalid name and/or password";
                        }
                        ?>

                        <button type="submit" value="Login" class="btn btn-default">
                            Submit
                        </button>
                    </form>

            </div>

        </div>
    </div>
</div>


</body>
</html>