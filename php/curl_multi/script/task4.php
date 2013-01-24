<?php
require_once 'Curl.php';
$echoNormal = function($body){echo "success. [{$body}]\n";};
$echoError = function($e){echo sprintf("fail. [%s]\n", $e->getMessage());};
for($i = 0; $i < 100; $i++){
    $tasks[$i] = new Task('http://localhost/darima/wait.php?sec=5', 10, $echoNormal, $echoError);
}
$executor = new ParallelTaskExecutor(100);
$res = $executor->execute($tasks);
echo "--------------\n";
//var_dump($res);
?>
