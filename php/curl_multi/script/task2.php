<?php
require_once 'Curl.php';
$echoNormal = function($body){echo "success. [{$body}]\n";};
$echoError = function($e){echo sprintf("fail. [%s]\n", $e->getMessage());};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 1, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 1, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 1, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal, $echoError);
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 1, $echoNormal, $echoError);
$executor = new ParallelTaskExecutor(3);
$res = $executor->execute($tasks);
echo "--------------\n";
//var_dump($res);
?>
