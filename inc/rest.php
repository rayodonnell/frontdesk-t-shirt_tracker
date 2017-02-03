<?php

include("functions.php");

if (isset($_REQUEST["call"])) {
	$call = $_REQUEST["call"];
	if (!is_numeric($_REQUEST["fid"])) {
		sendError();
	}
	if (!is_numeric($_REQUEST["group"])) {
		sendError();
	}
	switch ($call) {
		case "add":
			countFos($_REQUEST["fid"],$_REQUEST["group"],$_REQUEST["title"],$_REQUEST["room"],"+","added",$_REQUEST["print"],$_REQUEST["print2"]);
			break;
		case "min":
			countFos($_REQUEST["fid"],$_REQUEST["group"],$_REQUEST["title"],$_REQUEST["room"],"-","removed",$_REQUEST["print"],$_REQUEST["print2"]);
			break;
		case "visible":
			hideGroup($_REQUEST["group"],$_REQUEST["fid"]);
			break;
        case "bind":
            bind($_REQUEST["bind"],$_REQUEST["id"]);
            break;
		default:
			sendError();
	}
}



