<?php
require_once 'Curl.php';
$curl = new Curl('http://localhost/darima/wait.php?sec=4', 5);
$curl2 = new Curl('http://localhost/darima/wait.php?sec=4', 5);

$result = Curl::getBodies(array($curl, $curl2), 60);
var_dump($result);
?>
