<?php
//SELECT model, route_number, explanation, name, time  FROM currentlocation, transport, stops, status WHERE transport.id_unit = currentlocation.unit_id && stops.id_stop = currentlocation.stop_id && status.id_status = currentlocation.status_id
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "publictransport";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: \n" . $conn->connect_error);
}

$sql = "SELECT model, route_number, explanation, name, time  FROM currentlocation, transport, stops, status WHERE transport.id_unit = currentlocation.unit_id && stops.id_stop = currentlocation.stop_id && status.id_status = currentlocation.status_id ORDER BY route_number";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<h1 align = \"center\"><b>Текущее местоположение транспорта</b></h1>";
	echo "<table border=\"2\" cellpadding=\"5\" align = \"center\"><tr><th>Модель</th><th>Маршрут</th><th>Действие</th><th>Остановка</th><th>Время</th></tr>";
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo 	"<td align = \"center\">" . $row["model"] . "</td>";
		echo	"<td align = \"center\">" . $row["route_number"] . "</td>";
		echo	"<td align = \"center\">" . $row["explanation"] . "</td>";
		echo	"<td align = \"center\">" . $row["name"] . "</td>";
		echo	"<td align = \"center\">" . $row["time"] . "</td>";
            //for ($j = 0 ; $j < 3 ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>