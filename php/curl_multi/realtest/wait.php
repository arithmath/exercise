<?php
$startDate = new DateTime("now", new DateTimeZone("Asia/Tokyo"));
$wait=isset($_GET['sec'])?$_GET['sec']:'0';
sleep($wait);
$endDate = new DateTime("now", new DateTimeZone("Asia/Tokyo"));
$format = 'Y/m/d H:i:s';
echo sprintf("start[%s] end[%s] wait[%s sec]\n", $startDate->format($format), $endDate->format($format), $wait);
?>
