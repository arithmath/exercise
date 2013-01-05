import scala.io.Source

class HttpAccess(val file : String = "/dev/null") extends Loggable{

    def access(url : String) = {
        log("httpアクセス開始 url[" + url + "]")
        var body = Source.fromURL(url).getLines.mkString
        log("httpアクセス終了 url[" + url + "]")
        body
    }
}
