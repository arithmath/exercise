<?php
require_once 'Curl.php';

$str = 'no0';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$str = 'no1';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$str = 'no2';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$str = 'no3';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$str = 'no4';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$str = 'no5';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$str = 'no6';
$echoNormal = function($body) use($str){echo "success. [{$str}] [{$body}]\n";};
$tasks[] = new Task('http://localhost/darima/wait.php?sec=3', 5, $echoNormal);

$executor = new ParallelTaskExecutor(3);
$executor->enableLog();
$res = $executor->execute($tasks);
echo "--------------\n";
//var_dump($res);
?>
