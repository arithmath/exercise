<?php
class Hoge{
    public $name = "hoge";
    public function printName(){
        echo "name : {$this->name}.\n";
    }

    // クロージャ内でthisを使うことができるようになった
    // use($this)する必要はなし
    public function closure(){
        $func = function(){
            echo "this is {$this->name}.\n";
        };
        return $func;
    }
}
// new式の直後にメンバ変数、メンバ関数へのアクセスを書けるようになった
echo (new Hoge())->name."\n";
(new Hoge())->printName();

$hoge = new Hoge();
$func = $hoge->closure();
$hoge->name = "hoge2";
$func();

?>
