import java.io.PrintWriter
import java.io.File

// カリー化を使用しない
def withPrintWriter(file: File, op: PrintWriter => Unit){
    val writer = new PrintWriter(file)
    try{
        op(writer)
    }finally{
        writer.close()
    }
}

val file1 = new File("date1.txt")
withPrintWriter(
    file1,
    writer => writer.println(new java.util.Date))

// カリー化を使用
def withPrintWriterCurry(file: File)(op: PrintWriter => Unit){
    val writer = new PrintWriter(file)
    try{
        op(writer)
    }finally{
        writer.close()
    }
}

val file2 = new File("date2.txt")
withPrintWriterCurry(file2){
    writer => writer.println(new java.util.Date)
}
