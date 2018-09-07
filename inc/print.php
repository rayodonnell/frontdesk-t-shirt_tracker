<?php

$config = include('config.php');

if (isset($_GET["id"])) {
	$id = $_GET["id"];

    global $config;

    $conn = pg_connect($config['conn_str']);
    if (pg_connection_status($conn) != PGSQL_CONNECTION_OK) {
        die('Connection failed: ' . pg_last_error($conn));
    }

    $sql = 'select boundid from fosdem_alive where posid = $1';
    $rs = pg_query_params($conn, $sql, array($id));

    if ($rs === false) {
        die('Error: ' . pg_last_error($conn));
    }
    else {
        $row = pg_fetch_assoc($rs);
        if ($row === false) {
            die('Error: no rows returned'); // TODO: Does this work here?
        }
        else {
            if (is_numeric($id)) {
                $sql = 'select * from fosdem_print where printid = $1 and status = 0';
                $rsPrint = pg_query_params($conn, $sql, array($id));

                if ($rsPrint === false) {
                    die('Error: ' . pg_last_error($conn));
                }
                else {
                    $result = array();

                    while ($printRow = pg_fetch_assoc($rsPrint)) {
                        if (isset($printRow['print'])) {
                            $fileone = file_get_contents($printRow['print']);
                            $fileone = str_replace('[nr]', $printRow['id'], $fileone);
                            $date = date("d-m-Y H:i:s");
                            $fileone = str_replace('[date]', $date, $fileone);
                            $printvalue = str_replace('(hoodie)', '', $printRow['printvalue']);
                            $fileone = str_replace('[donation]', $printvalue, $fileone);
                            $printRow["print"] = $fileone;
                        }
                        if (isset($printRow['print2'])) {
                            if ($printRow['print2'] != 'none') {
                                $fileone = file_get_contents($printRow['print2']);
                                $fileone = str_replace('[nr]', $printRow['id'], $fileone);
                                $date = date('d-m-Y H:i:s');
                                $fileone = str_replace('[date]', $date, $fileone);
                                $printRow['print2'] = $fileone;
                            }
                        }
                        $result[] = $printRow;
                    }
                    pg_free_result($rsPrint);

                }
                echo json_encode($result);
            }
        }
        pg_free_result($rs);
    }
    pg_close($conn);
}
else if (isset($_GET["uid"])) {
	global $config;

	$uid = $_GET["uid"];

    $conn = pg_connect($config['conn_str']);
    if (pg_connection_status($conn) != PGSQL_CONNECTION_OK) {
        die('Connection failed: ' . pg_last_error($conn));
    }

	$sql = 'update fosdem_print set status = 1 where  id = $1';
    pg_query_params($conn, $sql, array($uid));
    pg_close($conn);

    echo "done";
}
