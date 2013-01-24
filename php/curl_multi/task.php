<?php
require_once 'Curl.php';
$echoNormal = function($body){echo "success. [{$body}]\n";};
$echoError = function($e){echo sprintf("fail. [%s]\n", var_export($e, true));};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=10', 15, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=2',  15, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=5',  15, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=1',  15, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3',  15, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=4',  15, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=2',  15, $echoNormal, $echoError);
$executor = new ParallelTaskExecutor(3);
$res = $executor->execute($tasks);
echo "--------------\n";
var_dump($res);
?>
