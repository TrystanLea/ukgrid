<?php

  #See: https://www.elexonportal.co.uk/SCRIPTING
  $url = "https://downloads.elexonportal.co.uk/fuel/download/latest?key=ELEXON-BMRS-API-KEY";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec ($ch);
  curl_close ($ch);

  $xml = simplexml_load_string($output);

  $len = count($xml->INST->FUEL);


  $intensity = array(
    "CCGT"=>360,
    "OCGT"=>480,
    "COAL"=>910,
    "NUCLEAR"=>0,
    "WIND"=>0,
    "PS"=>0,
    "NPSHYD"=>0,
    "OTHER"=>300,
    "OIL"=>610,
    "INTFR"=>90,
    "INTIRL"=>450,
    "INTNED"=>550,
    "INTEW"=>450
  );

  $co2intensity = 0;
  $totalsupply = 0;

  $data = array();
  $values = array();

  for ($i=0; $i<$len; $i++) {
    $name = $xml->INST->FUEL[$i]['TYPE']."";
    $val = $xml->INST->FUEL[$i]['VAL']*1.0;
    $pct = $xml->INST->FUEL[$i]['PCT']*0.01;

    $co2intensity += $pct*$intensity[$name];

    $data["".$name."_val"] = $val;
    $data["".$name."_prc"] = $pct;
    $values[] = $val;
    $totalsupply += $val;
  }

  $data["gridintensity"] = $co2intensity / 0.93;
  $data["totalsupply"] = $totalsupply;
  $values[] = $data["gridintensity"];
  $values[] = $data["totalsupply"];

  file_get_contents("http://localhost/ukgrid/api.php?q=post&id=1&apikey=MANUAL-WRITE-APIKEY&values=".implode(",",$values));

