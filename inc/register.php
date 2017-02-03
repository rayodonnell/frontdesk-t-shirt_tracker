<?php


$config = include('config.php');
$data = json_decode(file_get_contents('php://input'), true);
date_default_timezone_set('Europe/Brussels');
$time = date("d-m H:i:s");

$conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$bindid = "none";

$sql = "INSERT INTO fosdem_alive (ip,posid,boundid,timepos) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE ip=?,timepos=?;";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssssss", $data["ip"],$data["id"],$bindid,$time,$data["ip"],$time);
    $stmt->execute();
    //printf("Error: %s.\n", $stmt->error);
}

$stmt->close();
$conn->close();

echo "pong\n";

//echo file_get_contents('php://input');