<?php
class RideshareDB extends mysqli
{

// single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "DataBasicTeam";
    private $pass = "CPSC304!";
    private $dbName = "DataBasic";
    private $dbHost = "databasic.cvhyllwoxxb3.us-west-1.rds.amazonaws.com";


    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    public function __construct()
    {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public function get_driver_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $driverID = $this->query("SELECT DID FROM Driver WHERE name = '"
            . $name . "'");

        if ($driverID->num_rows > 0){
            $row = $driverID->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_passenger_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $passengerID = $this->query("SELECT PID FROM Passenger WHERE name = '"
            . $name . "'");

        if ($passengerID->num_rows > 0){
            $row = $passengerID->fetch_row();
            return $row[0];
        } else
            return null;
    }

    //TRUE(1) is Passenger
    //FALSE(0) is Driver
    public function get_user_type($name){
        $name = $this->real_escape_string($name);

        $result = $this->query("SELECT 1 FROM Passenger WHERE name = '"
            . $name . "'");
        return $result->data_seek(0);
    }

    public function verify_user_credentials($name, $password)
    {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);

        $result = $this->query("SELECT 1 FROM Driver WHERE name = '"
            . $name . "' AND password = '" . $password . "'");

        if($result->data_seek(0) == FALSE) {
            $result = $this->query("SELECT 1 FROM Passenger WHERE name = '"
                . $name . "' AND password = '" . $password . "'");
            return $result->data_seek(0);
        }

        return $result->data_seek(0);
    }


    public function create_driver($name, $email, $phoneNum, $password, $licenseNum, $type, $color) {
        $name = $this->real_escape_string($name);
        $email = $this->real_escape_string($email);
        $phoneNum = $this->real_escape_string($phoneNum);
        $licenseNum = $this->real_escape_string($licenseNum);
        $password = $this->real_escape_string($password);
        $type = $this->real_escape_string($type);
        $color = $this->real_escape_string($color);

        $this->query("INSERT INTO Car (licenseNum, type, color)" .
            " VALUES ('" . $licenseNum . "',
             '" . $type. "',
              '" .$color."'
            )");

        $this->query("INSERT INTO Driver (name, email, phoneNum, licenseNum, password)" .
        "VALUES ('" . $name . "',
         '" . $email . "',
         '" . $phoneNum . "',
         '" . $licenseNum . "',
         '" . $password . "'
         )");
    }

    public function create_passenger($name, $email, $phoneNum, $password){
        $name = $this->real_escape_string($name);
        $email = $this->real_escape_string($email);
        $phoneNum = $this->real_escape_string($phoneNum);
        $password = $this->real_escape_string($password);

        $this->query("INSERT INTO Passenger (name, email, phoneNum, password)" .
            "VALUES ('" . $name . "',
         '" . $email . "',
         '" . $phoneNum . "',
         '" . $password . "'
         )");


    }

    function format_date_for_sql($date){
        if ($date == "")
            return null;
        else {
            $dateParts = date_parse($date);
            return $dateParts["year"]*10000 + $dateParts["month"]*100 + $dateParts["day"];
        }

    }


    public function create_participates($PID, $RID, $Type){

        $PID = $this->real_escape_string($PID);
        $RID = $this->real_escape_string($RID);
        $Type = $this->real_escape_string($Type);

        $seatsLeft = $this->get_seatsleft_by_rid($RID);

        if ($seatsLeft > 0) {
        $this->query("UPDATE RideShare
                              SET seatsLeft = seatsLeft - 1
                              WHERE RID = '$RID'
                              AND seatsLeft > 0");

        $this->query("INSERT INTO Participates (PID, RID, Type)" .
            "VALUES ('" . $PID . "',
         '" . $RID . "',
         '" . $Type . "')");

        }
        else{
            return null;
        }
    }

    public function check_participates($PID, $RID){
        return $this->query("SELECT P.PID
                            FROM Participates P
                            WHERE P.RID = $RID AND P.PID = $PID");
    }


    public function create_rideshare($DID, $postalCode,
                                     $destination, $price, $address,
                                     $rdate, $rtime, $seats, $seatsLeft, $city, $province){

        $DID = $this->real_escape_string($DID);
        $postalCode = $this->real_escape_string($postalCode);
        $destination = $this->real_escape_string($destination);
        $price = $this->real_escape_string($price);
        $address = $this->real_escape_string($address);
        $rdate = $this->real_escape_string($rdate);
        $rdate = $this->format_date_for_sql($rdate);
        $rtime = $this->real_escape_string($rtime);
        $seats = $this->real_escape_string($seats);
        $seatsLeft = $this->real_escape_string($seatsLeft);
        $city = $this->real_escape_string($city);
        $province = $this->real_escape_string($province);

        $this->query("INSERT INTO Location (postalCode, city, province) VALUES ('$postalCode', '$city','$province')
        ON DUPLICATE KEY UPDATE postalCode = '$postalCode'");

        $this->query("INSERT INTO RideShare (DID,  postalCode, destination, address, price, rdate, rtime, seats, seatsLeft, Cdatetime)
                      VALUES ( '$DID',
                                 '$postalCode', '$destination',
                                 '$address','$price',
                                 '$rdate','$rtime',
                                 '$seats','$seatsLeft', NOW())");

    }

    public function update_destination($Destination, $RID){

        $this->query("UPDATE RideShare
                      SET destination= '". $Destination ."'
                      WHERE RID=" . $RID);

    }


    public function get_available_rideshares(){
        return $this->query("SELECT rdate, name, destination, price, seats, seatsLeft, RID, color
                  FROM RideShare R, Driver D, Car C
                  WHERE R.DID = D.DID AND seatsLeft > 0 AND R.rdate >= curdate() AND D.licenseNum = C.licenseNum /*AND r.rtime >= cast(gettime() as time)*/");
    }

    public function get_rideshare_byid($RID){
        return $this->query("SELECT rdate, name, destination, price, seats, seatsLeft, RID, address, rtime
                  FROM RideShare R, Driver D
                  WHERE R.RID = $RID AND R.DID = D.DID AND seatsLeft > 0 AND R.rdate >= curdate() /*AND r.rtime >= cast(gettime() as time)*/");
    }

    public function get_current_drivers_rideshares($driverID){
        return $this->query("SELECT rdate, destination, price, seats, seatsLeft, RID
                  FROM RideShare R, Driver D
                  WHERE $driverID = D.DID AND R.DID = D.DID AND R.rdate >= curdate()");
    }

    public function get_past_drivers_rideshares($driverID){
        return $this->query("SELECT rdate, destination, price, seats, seatsLeft, RID
                  FROM RideShare R, Driver D
                  WHERE $driverID = D.DID AND R.DID = D.DID AND R.rdate < curdate()");
    }


    public function get_rideshare_transactions($rideShareID){
        return $this->query("SELECT p.name, pa.Type, R.price
                FROM Participates pa, Passenger p, RideShare R
                Where pa.PID = p.PID AND R.RID = $rideShareID AND pa.RID = $rideShareID");


//        return $this->query("SELECT name, price, Type
//                FROM RideShare R, Participates Pa, Passenger P
//                WHERE R.RID = $rideShareID AND Pa.RID = $rideShareID");
    }


    public function get_current_passengers_rideshares($passengerID){
    return $this->query("SELECT rdate, destination, price, seatsLeft
                  FROM RideShare R, Passenger P, Participates Pa
                  WHERE $passengerID = P.PID AND P.PID = Pa.PID AND R.RID = Pa.RID AND R.rdate >= curdate()");
    }

    public function get_past_passengers_rideshares($passengerID){
        return $this->query("SELECT rdate, destination, price
                  FROM RideShare R, Passenger P, Participates Pa
                  WHERE $passengerID = P.PID AND P.PID = Pa.PID AND R.RID = Pa.RID AND R.rdate < curdate()");
    }

    public function search_driver($search){
        return $this->query("SELECT rdate, name, destination, price, seats, seatsLeft, RID
                  FROM RideShare R, Driver D
                  WHERE R.DID = D.DID AND seatsLeft > 0 AND R.rdate >= curdate() AND D.name = $search");
    }

    public function get_seatsleft_by_rid($RID) {
        $RID = $this->real_escape_string($RID);
        $seatsLeft = $this->query("SELECT seatsLeft FROM RideShare WHERE RID = '$RID' ");

        if ($seatsLeft->num_rows > 0){
            $row = $seatsLeft->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function delete_rideshare($RID)
    {
        $seatsLeft = $this->get_seatsleft_by_rid($RID);

        if ($seatsLeft > 0) {
            $this->query("DELETE FROM RideShare WHERE RID = '$RID'");
        } else
            return null;
    }
    public function get_max_price_driver($driverID){
        $max_price = $this->query("SELECT MAX(price)
        FROM RideShare R, Driver D
        WHERE R.DID = ".$driverID);

        if ($max_price->num_rows > 0){
            $row = $max_price->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_ave_price_driver($driverID){
        $ave_price = $this->query("SELECT AVG(price)
        FROM RideShare R, Driver D
        WHERE R.DID = ".$driverID);

        if ($ave_price->num_rows > 0){
            $row = $ave_price->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_min_price_driver($driverID){
        $min_price = $this->query("SELECT MIN(price)
        FROM RideShare R, Driver D
        WHERE R.DID =". $driverID);

        if ($min_price->num_rows > 0){
            $row = $min_price->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function search($Driver, $Destination, $Color)
    {
        return $this->query("SELECT rdate, name, destination, price, seats, seatsLeft, RID, color
                  FROM RideShare R, Driver D, Car C
                  WHERE
                  R.DID = D.DID AND
                  seatsLeft > 0 AND
                  R.rdate >= curdate() AND
                  D.licenseNum = C.licenseNum AND
                  D.name like '%$Driver%' AND
                  C.color like '%$Color%' AND
                  R.destination like '%$Destination%'
                  ");
    }
    
    public function get_destination_ave_seats(){
        return $this->query("SELECT destination, AVG(seatsLeft) AS avgSeats
             FROM RideShare R
             WHERE R.rdate >= curdate()
             GROUP BY destination");
    }

    public function get_destination_ave_maximum_seats($minormax){
        if($minormax == "MIN"){
            return $this->query("SELECT destination, MIN(AveragesByLoc.avgSeats) AS avgSeats
       FROM (SELECT destination, AVG(seatsLeft) AS avgSeats
             FROM RideShare R
             WHERE R.rdate >= curdate()
             GROUP BY destination
            ) AveragesByLoc
       ");}
        else return $this->query("SELECT destination, MAX(AveragesByLoc.avgSeats) AS avgSeats
       FROM (SELECT destination, AVG(seatsLeft) AS avgSeats
             FROM RideShare R
             WHERE R.rdate >= curdate()
             GROUP BY destination
            ) AveragesByLoc
            ");
    }

    
}