<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
<body>
<?php

$con = mysqli_connect("databasic.cvhyllwoxxb3.us-west-1.rds.amazonaws.com", "DataBasicTeam", "CPSC304!");
if (!$con) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}
//set the default client character set
mysqli_set_charset($con, 'utf-8');

?>
</body>
</html>




