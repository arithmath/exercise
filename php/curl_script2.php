<?php
require_once 'Curl.php';
$curl = new Curl('http://localhost/darima/wait.php?sec=10', 2);
for($i = 0; $i < 3; $i++){
    try{
        var_dump($curl->getBody(3));
    }catch(Exception $e){
        var_dump($e);
    }
}
?>
