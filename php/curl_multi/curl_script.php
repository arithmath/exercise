<?php
require_once 'Curl.php';
$curl = new Curl('http://localhost/darima/wait.php?sec=10', 0);
$curl2 = new Curl('http://localhost/darima/wait.php?sec=10', 0);

//try{
//$curl2->getBody(1);
//}catch(Exception $e)
//{}
$body = 'hoghoge';
while($body === 'hoghoge'){
    try
    {
        $body = $curl->getBody(3);
    }
    catch(Exception $e)
    {
        echo $e->getMessage()."\n";
    }
}
echo $body;
echo $curl2->getBody();

?>
