<?php
trait Loggable1{
    public function log($message){
        echo("-- $message --\n");
    }
}

trait Loggable2{
    public function log($message){
        echo("** $message **\n");
    }
    public function log2($message){
        echo("**** $message ****\n");
    }
}

class Fuga{
    // 共通するメソッドを持つトレイトをミックスインしたら、
    // insteadofで優先するものを指定する
    use Loggable1, Loggable2{
        Loggable1::log insteadof Loggable2;
    }
    public $name = 'default name';
    public function printName(){
        echo($this->name);
    }
}

$fuga = new Fuga();
$fuga->log('test.');
$fuga->log2('test.');


trait Loggable3{
    // trait側で、ミックスインされる側のメソッドを指定可能
    abstract public function getName();
    // abstract public function getName(){
    //     return('|'.parent::getName().'|');
    // }

    // ミックスインされる側のgetNameメソッドを使ってトレイトのメソッドを定義できる
    public function log($message){
        echo "{$this->getName()} : $message\n";
    }
}

class Piyo{
    use Loggable3;
    public $name = 'default';
    public function getName(){
        return($this->name);
    }
}

$piyo = new Piyo();
$piyo->log("test.");


// メソッドの優先順位
// 自分のメソッドのクラスとして定義されていればそれが一番優先される。
// その次にトレイト。
// 最後が親クラス。
trait DateTimeCreater{
    public function createDateTime(){
        return new DateTime('now', new DateTimeZone('Asia/Tokyo'));
    }
}
trait StubDateTimeCreater{
    public function createDateTime(){
        return new DateTime('2012/01/02', new DateTimeZone('Asia/Tokyo'));
    }
}

// 自分のクラスのcreateDateTimeが優先される
class DateTimeUser{
    use DateTimeCreater; // この行をコメントアウトしてもしなくても挙動は一緒
                         // DateTimeUser2の振る舞いにも影響なし
    public function createDateTime(){
        return new DateTime('2012/03/04', new DateTimeZone('Asia/Tokyo'));
    }
}

// トレイトのStubDateTimeCreaterが優先される
class DateTimeUser2 extends DateTimeUser{
    use StubDateTimeCreater;
}

$creater1 = new DateTimeUser();
echo $creater1->createDateTime()->format("Y/m/d h:i:s")."\n";
$creater2 = new DateTimeUser2();
echo $creater2->createDateTime()->format("Y/m/d h:i:s")."\n";
