<?php

require_once("db.php");

$passwordIsValid = true;
$passwordIsEmpty = false;
$password2IsEmpty = false;


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['user'] == "") {
        $userIsEmpty = true;
    }

    if ($_POST['password'] == "")
        $passwordIsEmpty = true;
    if ($_POST['password2'] == "")
        $password2IsEmpty = true;
    if ($_POST['password'] != $_POST['password2']) {
        $passwordIsValid = false;
    }

    if (!$passwordIsEmpty && !$password2IsEmpty && $passwordIsValid) {
        RideshareDB::getInstance()->create_passenger($_POST['user'],
            $_POST['email'], $_POST['phoneNum'], $_POST['password']);

        header('Location: index.php');
        exit;
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

            </nav>

            <div class="jumbotron">
                <form name="addPass" action="createpassenger.php" method="POST">

                    <form role="form" name="addPassenger" action="createpassenger.php" method="POST">
                        <h3>User Information</h3>
                        <div class="form-group">
                            <label for="username">
                                Username
                            </label>
                            <input type="text" class="form-control" name="user" required/>
                        </div>

                        <div class="form-group">
                            <label for="email">
                                Email
                            </label>
                            <input class="form-control" type="text" name="email" required/>
                        </div>

                        <div class="form-group">
                            <label for="phone">
                                Phone Number
                            </label>
                            <input class="form-control" type="text" name="phoneNum" required/>
                        </div>

                        <div class="form-group">
                            <label for="pass">
                                Password
                            </label>
                            <input class="form-control" type="password" name="password" required/>
                        </div>

                        <?php
                        if ($passwordIsEmpty) {
                            echo("Enter the password, please");
                            echo("<br/>");
                        }
                        ?>

                        <div class="form-group">
                            <label for="pass2">
                                Confirm password
                            </label>
                            <input class="form-control" type="password" name="password2" required/>
                        </div>

                        <?php
                        if ($password2IsEmpty) {
                            echo("Confirm your password, please");
                            echo("<br/>");
                        }
                        if (!$password2IsEmpty && !$passwordIsValid) {
                            echo("<div>The passwords do not match!</div>");
                            echo("<br/>");
                        }
                        ?>

                        <button type="submit" value="Save Changes" class="btn btn-default">Submit</button>
                    </form>
                 </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
