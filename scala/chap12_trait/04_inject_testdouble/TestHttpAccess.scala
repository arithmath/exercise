import scala.collection.mutable.ArrayBuffer
import org.scalatest.FunSuite
object TestHttpAccess{
    def main(args : Array[String]){
        (new TestHttpAccess).execute();
    }
}

class TestHttpAccess extends FunSuite{
    test("ログの内容をテスト - テスト用内部トレイトを組み込み"){
        // テスト用ロガーを用意
        trait TestSpyLoggable extends Loggable{
            val history : ArrayBuffer[String] = new ArrayBuffer()

            override def log(message : String) = {
                history += message
            }
        }

        // テスト用ロガーをミックスインしてテスト対象オブジェクトを生成
        val sut = new HttpAccess() with TestSpyLoggable

        // テスト実施
        sut.access("http://localhost");

        // アサート
        assert(sut.history(0) == "httpアクセス開始 url[http://localhost]")
        assert(sut.history(1) == "httpアクセス終了 url[http://localhost]")
    }

    test("ログの内容をテスト - テスト用無名クラスでトレイトのメソッドを上書き"){
        // テスト用ロガーをミックスインしてテスト対象オブジェクトを生成
        val sut = new HttpAccess("testtest.txt"){ // with Loggableはあってもなくても良い
            val history : ArrayBuffer[String] = new ArrayBuffer()

            override def log(message : String) = {
                history += message
            }
        }

        // テスト実施
        sut.access("http://localhost");

        // アサート
        assert(sut.history(0) == "httpアクセス開始 url[http://localhost]")
        assert(sut.history(1) == "httpアクセス終了 url[http://localhost]")
    }
}
