<?php
require_once("db.php");
// $RIDEID = $_POST['RID'];
// echo $RIDEID;

RideshareDB::getInstance()->delete_rideshare( ($_POST['RID']));
header('Location: driverhomepage.php');
