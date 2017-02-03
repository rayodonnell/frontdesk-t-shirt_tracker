<?php

header("Content-Type: text/plain");

$json_url = "http://fosdem.thepreview.be/js/events.json.php";
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);
//print_r($data);
$output = "";
foreach($data["category"] as $key => $value) {
    if ($value["group"] == 2) {
        foreach($value["blobs"] as $keyt => $valuet) {
            //print_r($valuet);
            $output .= 'tshirts_distributed_total{conference="FOSDEM",edition="2017",model="'.$valuet["model"].'",size="'.str_replace("Girly ","",$valuet["name"]).'"} '.$valuet["counttotal"]."\n";
            $output .= 'tshirts_available_total{conference="FOSDEM",edition="2017",model="'.$valuet["model"].'",size="'.str_replace("Girly ","",$valuet["name"]).'"} '.$valuet["maxtotal"]."\n";
        }
    }
    if ($value["group"] == 3) {
        foreach($value["blobs"] as $keyt => $valuet) {
            //print_r($valuet);
            $output .= 'hoodies_distributed_total{conference="FOSDEM",edition="2017",size="'.$valuet["name"].'"} '.$valuet["counttotal"]."\n";
            $output .= 'hoodies_available_total{conference="FOSDEM",edition="2017",size="'.$valuet["name"].'"} '.$valuet["maxtotal"]."\n";
        }
    }
}

echo $output;