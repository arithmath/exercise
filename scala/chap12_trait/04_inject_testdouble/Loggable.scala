import java.io.FileWriter
import java.io.BufferedWriter
import java.io.PrintWriter
import java.nio.file.Path
import java.nio.file.Paths

trait Loggable{
    val file : String;

    // ファイル出力用オブジェクトを用意
    lazy val filePath : Path = Paths.get(file);

    def log(message : String){
        // ファイル出力用オブジェクトを用意
        val fw = new FileWriter(filePath.toFile(), true)
        val bw = new BufferedWriter(fw)
        val pw = new PrintWriter(bw)

        pw.println(message)

        pw.close()
    }
}
