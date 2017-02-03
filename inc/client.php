<?php

//print client ( connection test only, for full code view Pi repo )

require_once 'Config/Lite.php';

$url = "http://fosdem.thepreview.be/newv2/inc";

$config = new Config_Lite('config.ini');

$id = $config->get('config', 'id');

if ($id == "auto") {
    $id = _generateRandomString(8);
}

$config->set('config', 'id', $id);
$config->save();

$print = "FOSDEM POS TOOL \n \n";

echo "starting print server with id - " . $id . "\n";
$print .= "starting print server with id - " . $id . "\n";
$host= gethostname();
$ip = gethostbyname($host);

echo "registering device on printer server with the following ip : " . $ip . "\n\n";
$print .= "registering device on printer server with the following ip : " . $ip . "\n\n";

exec("echo \"print\" | lp -d Star_TSP143_ ",$cmd);

sendImAlive($id,$ip);

$i = 0;
while (true) {
    if ($i == 5) {
        $i = 0;
        sendImAlive($id,$ip);
    }
	$json = file_get_contents($url.'/print.php?id='.$id);
	$obj = json_decode($json);
	if (is_array($obj)) {
		foreach($obj as $key=>$value) {
			//add the code to print here


			//set printed
			$uid = $value->id;
			echo " got print job with ID : " . $uid . "\n";
            echo " \nprinting print 1 : " . $value->print;
            exec("echo ".$value->print." | lp -d Star_TSP143_ ",$cmd);

            if ($value->print2 != "none") {
                echo " \nprinting print 2 : " . $value->print2;
                exec("echo ".$value->print2." | lp -d Star_TSP143_ ",$cmd);
            }

			$removeid = file_get_contents($url.'/print.php?uid='.$uid);
		}
	}
	$i++;
	sleep(1);
}


function _generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendImAlive($id,$ip) {
    echo "ping\n";
    Global $url;
    $urlz = $url ."/register.php";
    $arr = array("ip"=>$ip,"id"=>$id);
    $content = json_encode($arr);

    $curl = curl_init($urlz);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    //$response = json_decode($json_response);
    echo $json_response ;
}

