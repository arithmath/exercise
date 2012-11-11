import java.net.URL
import java.net.MalformedURLException

// scalaのtry, catch, finallyは値を返すため、
// こんな書き方も可能になる
def url = try{
              new URL("aaaaa");
          }catch{
              case e: MalformedURLException => new URL("http://www.yahoo.co.jp");
          }
println(url.toString)
