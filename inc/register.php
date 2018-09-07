<?php


$config = include('config.php');

$data = json_decode(file_get_contents('php://input'), true);
date_default_timezone_set('Europe/Brussels');
$time = date("d-m H:i:s");

$conn = pg_connect($config['conn_str']);
if (pg_connection_status($conn) != PGSQL_CONNECTION_OK) {
    die('Connection failed: ' . pg_last_error($conn));
}

$sql = 'insert into fosdem_alive (ip, posid, boundid, timepos)'
    . ' values ($1, $2, $3, $4)';
pg_query_params($conn, $sql, array($data["ip"], $data["id"], 'none', $time));

pg_close($conn);

echo "pong\n";
