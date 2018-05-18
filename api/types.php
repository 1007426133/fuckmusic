<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With");
$types = require(dirname(__FILE__) . "/config.php");
//$array = array(array('id'=>1,"name"=>"网易云"),array('id'=>2,"name"=>"QQ音乐"),array('id'=>3,"name"=>"酷狗"));

echo json_encode($types);
