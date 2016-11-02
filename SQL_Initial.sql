ALTER TABLE DataBasic.Participates DROP FOREIGN KEY Participates_ibfk_1;
ALTER TABLE DataBasic.Participates DROP FOREIGN KEY Participates_ibfk_2;
ALTER TABLE DataBasic.RideShare DROP FOREIGN KEY RideShare_ibfk_1;
ALTER TABLE DataBasic.RideShare DROP FOREIGN KEY RideShare_Location_postalCode_fk;
ALTER TABLE DataBasic.Driver DROP FOREIGN KEY Driver_ibfk_1;
DROP TABLE DataBasic.Participates;
DROP TABLE DataBasic.RideShare;
DROP TABLE DataBasic.Driver;
DROP TABLE DataBasic.Passenger;
DROP TABLE DataBasic.Location;
DROP TABLE DataBasic.Car;

USE DataBasic;

CREATE TABLE `Car` (
 `licenseNum` char(25) NOT NULL,
 `type` char(25) NOT NULL,
 `color` char(25) NOT NULL,
 PRIMARY KEY (`licenseNum`),
 UNIQUE KEY `Car_licenseNum_uindex` (`licenseNum`)
);

CREATE TABLE `Driver` (
 `DID` int(11) NOT NULL AUTO_INCREMENT,
 `email` char(25) NOT NULL,
 `password` char(25) NOT NULL,
 `phoneNum` char(25) NOT NULL,
 `name` char(25) NOT NULL,
 `licenseNum` char(25) NOT NULL,
 PRIMARY KEY (`DID`),
 UNIQUE KEY `Driver_name_uindex` (`name`),
 KEY `licenseNum` (`licenseNum`),
 CONSTRAINT `Driver_ibfk_1` FOREIGN KEY (`licenseNum`) REFERENCES `Car` (`licenseNum`)
);

CREATE TABLE `Location` (
 `postalCode` char(25) NOT NULL,
 `city` char(25) NOT NULL,
 `province` char(25) NOT NULL,
 PRIMARY KEY (`postalCode`),
 UNIQUE KEY `Location_postalCode_uindex` (`postalCode`)
);

CREATE TABLE `Participates` (
 `PID` int(11) NOT NULL,
 `RID` int(11) NOT NULL,
 `Type` char(25) DEFAULT NULL,
 PRIMARY KEY (`PID`,`RID`),
 KEY `RID` (`RID`),
 CONSTRAINT `Participates_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `Passenger` (`PID`),
 CONSTRAINT `Participates_ibfk_2` FOREIGN KEY (`RID`) REFERENCES `RideShare` (`RID`) ON DELETE CASCADE
);

CREATE TABLE `Passenger` (
 `PID` int(11) NOT NULL AUTO_INCREMENT,
 `email` char(25) NOT NULL,
 `password` char(25) NOT NULL,
 `phoneNum` char(25) NOT NULL,
 `name` char(25) NOT NULL,
 PRIMARY KEY (`PID`),
 UNIQUE KEY `Passenger_name_uindex` (`name`)
);

CREATE TABLE `RideShare1` (
 `RID` int(11) NOT NULL AUTO_INCREMENT,
 `destination` char(25) NOT NULL,
 `price` float NOT NULL,
 `DID` int(11) NOT NULL,
 `address` char(25) DEFAULT NULL,
 `postalCode` char(25) NOT NULL,
 `rdate` date NOT NULL,
 `rtime` time DEFAULT NULL,
 `seats` int(11) NOT NULL,
 `seatsLeft` int(11) NOT NULL,
 `Cdatetime` datetime NOT NULL,
 PRIMARY KEY (`RID`),
 KEY `DID` (`DID`),
 KEY `RideShare_Location_postalCode_fk` (`postalCode`),
 CONSTRAINT `RideShare_Location_postalCode_fk` FOREIGN KEY (`postalCode`) REFERENCES `Location` (`postalCode`),
 CONSTRAINT `RideShare_ibfk_1` FOREIGN KEY (`DID`) REFERENCES `Driver` (`DID`),
 CHECK (destination='Whistler' OR 'Victoria' OR 'Richmond' OR 'Vancouver' OR 'MaCrib')
);

INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('123poi', 'Sedan', 'Red');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('123sdf', 'Sedan', 'Black');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('123wer', 'SUV', 'Gold');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('BRY123', 'Sedan', 'Blue');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('GTH657', 'Truck', 'Green');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('MAT123', 'Sedan', 'Bronze');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('MAT456', 'Truck', 'Gold');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('RAH123', 'Van', 'Red');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('RAH456', 'Truck', 'Grey');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('SCO123', 'Truck', 'Blue');
INSERT INTO DataBasic.Car (licenseNum, type, color) VALUES ('SCO456', 'Sedan', 'Green');

INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (1, 'laks@mail.com', '123', '6049831234', 'Laks', 'GTH657');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (2, 'dasfasd@asdf.com', '123', '6041234567', 'Nadine', '123sdf');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (3, 'rahul@mail.com', '123', '6043962446', 'Rahul', 'RAH123');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (4, 'scott@mail.com', '123', '6042093841', 'Scott', 'SCO123');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (5, 'scott1@mail.com', '123', '6042919401', 'Henry', 'SCO456');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (6, 'matan@mail.com', '123', '6041239584', 'Matan', 'MAT123');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (7, 'matan1@mail.com', '123', '6047830134', 'Halevy', 'MAT456');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (8, 'bryan@mail.com', '123', '6089401034', 'Bryan', 'BRY123');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (9, 'bryan1@mail.com', '123', '7783489219', 'Jiang', 'GTH657');
INSERT INTO DataBasic.Driver (DID, email, password, phoneNum, name, licenseNum) VALUES (10, '2134321@dfs.com', '123', '7781234567', 'Kobe', '123wer');

INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('123ahj', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('123asd', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('321asd', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('v4r2e2', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('v5y6t7', 'Surrey', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('V6T 1Z1', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('V6T1Z4', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('V6T4T6', 'Vancouver', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('V6Y 3C5', 'Richmond', 'BC');
INSERT INTO DataBasic.Location (postalCode, city, province) VALUES ('v7r3r3', 'Vancouver', 'BC');

INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (1, 'mbh159@gmail.com', '123', '6044187452', 'Angus');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (2, 'test123@gmail.com', '123', '6044187451', 'Kaiser');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (4, 'asdf@adsf.com', '123', '6044187455', 'Hasan');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (5, 'adsf@asdf.com', '123', '6044187458', 'Yeung');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (6, 'cameron@mail.com', '123', '6049323450', 'Cameron');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (7, 'rooney@mail.com', '123', '7789432342', 'Rooney');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (8, 'sadsa@asd.com', '123', '7787787788', 'Ronaldo');
INSERT INTO DataBasic.Passenger (PID, email, password, phoneNum, name) VALUES (9, 'christianbale@batman.com', '123', '6041234567', 'christianbale');

INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (1, 'Whistler', 10, 1, '3535 West Mall', 'V6T4T6', '2018-12-16', '00:07:00', 4, 0, '2016-04-04 05:28:39');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (2, 'Whistler', 10, 2, '123 B Street', '123asd', '2016-04-25', '11:11:00', 5, 3, '2016-04-04 05:30:34');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (3, 'Dubai', 45, 2, '123 A Street', '123ahj', '2016-05-11', '11:11:00', 7, 5, '2016-04-04 05:36:38');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (4, 'Victoria', 15, 4, '453 C Street', '321asd', '2016-04-16', '11:12:00', 6, 5, '2016-04-03 23:08:30');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (5, 'Whistler', 100, 3, '2205 Lower Mall', 'V6T1Z4', '2016-04-25', '16:00:00', 4, 4, '2016-04-04 06:17:21');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (6, 'Richmond', 22, 10, '2053 Main Mall', 'V6T 1Z1', '2016-03-11', '11:11:00', 5, 5, '2016-04-04 06:19:54');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (7, 'Kelowna', 30, 10, '2051 Main Mall', 'V6T 1Z1', '2016-05-11', '11:11:00', 9, 9, '2016-04-04 06:21:03');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (8, 'Kamloops', 10, 10, '2051 Main Mall', 'V6T 1Z1', '2016-05-19', '11:11:00', 4, 4, '2016-04-04 06:21:47');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (9, 'Prince Rupert', 25, 10, '123 Main Mall', 'V6T 1Z1', '2016-05-29', '11:11:00', 6, 6, '2016-04-04 06:22:32');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (10, 'Seattle', 15, 2, '321 3rd Street', 'v7r3r3', '2015-06-23', '11:11:00', 6, 6, '2016-04-04 06:24:57');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (12, 'Whistler', 10, 6, '9531 McBurney dr.', 'V6Y 3C5', '2017-02-15', '13:02:00', 4, 4, '2016-04-04 06:29:34');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (13, 'Richmond', 25, 6, '9531 McBurney dr.', 'V6Y 3C5', '2016-10-15', '11:58:00', 1, 1, '2016-04-04 06:30:31');
INSERT INTO DataBasic.RideShare (RID, destination, price, DID, address, postalCode, rdate, rtime, seats, seatsLeft, Cdatetime) VALUES (14, 'Victoria', 20, 4, '543 D Street', 'v5y6t7', '2016-07-20', '12:34:00', 7, 7, '2016-04-04 06:32:14');

INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (1, 2, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (5, 3, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (8, 2, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (8, 3, 'paypal');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (8, 4, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (10, 2, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (10, 5, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (10, 9, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (10, 10, 'cash');
INSERT INTO DataBasic.Participates (PID, RID, Type) VALUES (10, 14, 'cash');