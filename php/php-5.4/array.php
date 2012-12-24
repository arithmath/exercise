<?php
// 配列の略記表現
$array = ['alice', 'bob', 'carol'];
var_dump($array);

// 関数の戻り値に添字を書いて、配列のデータにアクセスできるように
$function = function(){
                return(['name' => 'alice', 'age' => 22]);
            };
echo $function()['name']."\n";
?>
