<?php

$config = include('config.php');

if (isset($_GET["id"])) {
	$id = $_GET["id"];
    global $config;
    $conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT boundid FROM fosdem_alive where posid=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        if (is_numeric($id)) {
            $sql = "SELECT * FROM fosdem_print where printid=? and status = 0";
            $stmt = $conn->prepare($sql);
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $id);
                $stmt->execute();
                $meta = $stmt->result_metadata();

                while ($field = $meta->fetch_field()) {
                    $params[] = &$row[$field->name];
                }

                call_user_func_array(array($stmt, 'bind_result'), $params);

                while ($stmt->fetch()) {
                    foreach ($row as $key => $val) {
                        $c[$key] = $val;
                    }
                    $result[] = $c;
                }
            }
            $stmt->close();
            $conn->close();
            foreach($result as $key => &$value) {
                if (isset($value["print"])) {
                    $fileone = file_get_contents($value["print"]);
                    $fileone = str_replace("[nr]",$value["id"],$fileone);
                    $date = date("d-m-Y H:i:s");
                    $fileone = str_replace("[date]",$date,$fileone);
                    $printvalue = str_replace("(hoodie)","",$value["printvalue"]);
                    $fileone = str_replace("[donation]",$printvalue,$fileone);
                    $value["print"] = $fileone;
                }
                if (isset($value["print2"])) {
                    if ($value["print2"] != "none") {
                        $fileone = file_get_contents($value["print2"]);
                        $fileone = str_replace("[nr]",$value["id"],$fileone);
                        $date = date("d-m-Y H:i:s");
                        $fileone = str_replace("[date]",$date,$fileone);
                        $value["print2"] = $fileone;
                    }
                }
            }
            echo json_encode($result);
        }
    }
}
else if (isset($_GET["uid"])) {
	global $config;
	$uid = $_GET["uid"];
	$conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);
	$sql = "update fosdem_print set status = 1 where  id = ? ";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("i", $uid);
		$stmt->execute();
	}
	$stmt->close();
	$conn->close();
	echo "done";
}
