<?php
require_once 'Curl.php';
$curl = new Curl('http://www.yahoo.co.jp');
$body = '';
while($body === ''){
    $body = $curl->getBody('1');
    echo "タイムアウト\n";
}
echo $body;

?>
