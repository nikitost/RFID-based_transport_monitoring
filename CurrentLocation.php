<?php
date_default_timezone_set("Asia/Yekaterinburg");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "publictransport";

$date = date('Y-m-d H:i:s');
$uid = $_GET['uid'];
$stop = $_GET['stop'];
$status = $_GET['status'];
//$stop = 1;
//$status = 2;

//создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

//проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully\r\n";

$sql1 = "SELECT id_unit FROM `transport` WHERE rfid_uid = '$uid'";
$result = $conn->query($sql1);

if ($conn->query($sql1) == TRUE) {
    echo "ID received\r\n";
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$unitid = $row["id_unit"];
		}
} else {
    die("UNKNOWN TAG UID");//echo "0 results";
}

$sql3 = "SELECT id_location FROM `currentlocation` WHERE unit_id = '$unitid'";
$result = $conn->query($sql3);
if ($conn->query($sql3) == TRUE) {
    echo "ID location received\r\n";
} else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
}
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$idlocation = $row["id_location"];
		$sql4 = "UPDATE `currentlocation` SET `stop_id` = '$stop', `time` = '$date', `status_id` = '$status' WHERE `currentlocation`.`id_location` = '$idlocation'";
		if ($conn->query($sql4) == TRUE) {
			echo "Data Updated\r\n";
		} else {
			echo "Error: " . $sql4 . "<br>" . $conn->error;
			echo " UNKNOWN STOP ID OR STATUS ID";
		}
		}
} else {
    //echo "0 results";
	$sql2 = "INSERT INTO `currentlocation` (`id_location`, `unit_id`, `stop_id`, `time`, `status_id`) VALUES (NULL, '$unitid', '$stop', '$date', '$status')";

	if ($conn->query($sql2) == TRUE) {
		echo "Data inserted\r\n";
	} else {
		echo "Error: " . $sql2 . "<br>" . $conn->error;
		echo " UNKNOWN STOP ID OR STATUS ID";
	}
}

$conn->close();

//проверитть на наличие машины в таблице локаций SELECT id_location FROM `currentlocation` WHERE unit_id = '3'

//SELECT id_unit FROM `transport` WHERE rfid_uid = '03e14d1b'

//INSERT INTO `currentlocation` (`id_location`, `unit_id`, `stop_id`, `time`, `status_id`) VALUES (NULL, '2', '1', '2019-05-19 12:34:59', '1');

//UPDATE `currentlocation` SET `stop_id` = '2', `status_id` = '1' WHERE `currentlocation`.`id_location` = 26

//для выполнения - http://localhost/CurrentLocation.php?uid=xxxxxxxx&stop=xxxxxx&status=xx 
?>
 