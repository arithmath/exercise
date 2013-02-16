<?php
require_once '../Curl.php';

$start = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
echo sprintf("--- start [%s] ---\n", $start->format('Y/m/d H:i:s'));

$url[0] = "http://localhost/darima/wait.php?sec=2";
$url[1] = "http://localhost/darima/wait.php?sec=2";
$num = 10;
for($i = 0; $i < $num; $i++){
    $curl[$i] = new Curl($url[$i % 2]);
}

//$bodies = Curl::getBodies($curl);
//foreach($bodies as $body)
//{
//    echo $body;
//}

for($i = 0; $i < $num; $i++){
    echo sprintf("%s : %s", $i, $curl[$i]->getBody());
}
?>
