<?php

$config = include('config.php');
session_start();

function bind($bind, $id)
{
    global $config;

    $conn = pg_connect($config['conn_str']);
    if (pg_connection_status($conn) != PGSQL_CONNECTION_OK) {
        die('Connection failed: ' . pg_last_error($conn));
    }

    $sql = 'update fosdem_alive set boundid = $1 where posid = $2';
    pg_query_params($conn, $sql, array($id, $bind));

    pg_close($conn);

    $status = array("status" => "done");
    echo json_encode($status);
}


function countFos($fid, $group, $title, $room, $operator, $text, $print, $print2)
{
    global $config;

    $conn = pg_connect($config['conn_str']);
    if (pg_connection_status($conn) != PGSQL_CONNECTION_OK) {
        die('Connection failed: ' . pg_last_error($conn));
    }

    $sql = 'select fcount from fosdem where fid = $1';
    $rs = pg_query_params($conn, $sql, array($fid));

    if ($rs === false) {
        die('Error: ' . pg_last_error($conn));
    }
    else {
        $total = 0;
        while ($row = pg_fetch_assoc($rs)) {
            if ($operator == '+') {
                $total = $row['fcount'] + 1;
            }
            else {
                $total = $row['fcount'] - 1;
            }
        }
    }

    pg_free_result($rs);

    $sql = 'insert into fosdem (fid, fgroup, fcount) values ($1, $2, $3)'
        . ' on conflict (fid) do update set fcount = excluded.fcount';
    pg_query_params($conn, $sql, array($fid, $group, $total));

    pg_close($conn);

    if ($operator == "+") {
        if ($print == "temp1") {
            printer($title, $room, $print, $print2, $fid);
        }
        else {
            if ($print == "temp3") {
                printer($title, $room, $print, $print2, $fid);
            }
        }
    }

    logger($fid, $group, "You " . $text . " the item: " . $title . " in room " . $room, $room);
    header('Content-type: application/json');
    echo json_encode("done");
}


function getCount($fid)
{
    global $config;
    $conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT fcount FROM fosdem where fid=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $fid);
        $stmt->execute();
        $total = 0;
        $stmt->bind_result($fcount);
        while ($stmt->fetch()) {
            $total = $fcount;
        }
    }
    $stmt->close();
    $conn->close();
    return $total;
}

function getCountTotal($fgroup)
{
    global $config;
    $conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT fcount FROM fosdem where fgroup=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $fgroup);
        $stmt->execute();
        $total = 0;
        $stmt->bind_result($fcount);
        while ($stmt->fetch()) {
            $total += $fcount;
        }
    }
    $stmt->close();
    $conn->close();
    return $total;
}

function printer($title, $room, $print, $print2, $id)
{
    global $config;
    $conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO fosdem_print (printid,printtype,printvalue,status,print,print2,eventid) VALUES (?,'donation',?,0,?,?,?);";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('isssi', $room, $title, $print, $print2, $id);
        $stmt->execute();
    }
    $stmt->close();
    $conn->close();
}

function logger($fid, $group, $action, $room)
{
    global $config;
    $conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $time = time();
    $sql = "INSERT INTO fosdem_logger (fid,fgroup,fdate,faction,room) VALUES (?,?,?,?,?);";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iisss", $fid, $group, $time, $action, $room);
        $stmt->execute();
    }
    $stmt->close();
    $conn->close();
}

function getVisible($gid)
{
    $total = 1;
    if (isset($_SESSION["G" . $gid])) {
        $total = $_SESSION["G" . $gid];
    }
    if ($total == 0) {
        $total = "hidden";
    }
    else {
        $total = "";
    }
    return $total;
}

function hideGroup($group, $state)
{
    $_SESSION["G" . $group] = $state;
}

function sendError()
{
    echo "error incorrect format";
    exit();
}