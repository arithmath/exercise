<?php
require __DIR__.'/custom_array.php';
$array = new CustomArray();
$array['hoge'] = 'fuga';
$array['fuga'] = 'piyo';
var_dump($array);
var_dump($array['hoge']);
var_dump($array['fuga']);
var_dump($array['piyo']);
?>
