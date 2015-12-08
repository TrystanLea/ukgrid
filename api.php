<?php

$apikey = "SET-MANUAL-WRITE-APIKEY";
$datadir = "/home/user/ukgrid/";

error_reporting(E_ALL);
ini_set('display_errors', 'on');

if (!isset($_GET['q'])) die;
if (!isset($_GET['id'])) die;

$q = $_GET['q'];
$id = (int) $_GET['id'];

$logger = new EmonLogger();

require "PHPFina.php";
$phpfina = new PHPFina();
$phpfina->dir = $datadir;

header('Content-Type: application/json');
switch ($q)
{   
    case "create":
        if (isset($_GET['apikey']) && $apikey == $_GET['apikey']) { 
            print $phpfina->create($id,array("interval"=>get('interval'), "columns"=>get('columns')));
        }
        break;
    
    case "post":
        if (isset($_GET['apikey']) && $apikey == $_GET['apikey']) { 
            $time = time();
            print json_encode($phpfina->post($id,$time,explode(",",get('values'))));
        }
        break;

    case "data":
        print json_encode($phpfina->get_data($id,get('start'),get('end'),get('interval'),get('skipmissing'),get('limitinterval')));
        break;
    
    case "lastvalue":
        print json_encode($phpfina->lastvalue($id));
        break;
}
    
function get($index)
{
    $val = null;
    if (isset($_GET[$index])) $val = $_GET[$index];
    
    if (get_magic_quotes_gpc()) $val = stripslashes($val);
    return $val;
}

class EmonLogger {
    public function __construct() {}
    public function info ($message){ }
    public function warn ($message){ }
}
