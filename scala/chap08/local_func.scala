import scala.io.Source

object LongLines{
    def processFile(filename : String, width : Int){

        // 関数の中に関数を定義
        def processLine(line : String){
            if(line.length > width) // 外部で定義されたwidthが使える
                println(filename + ": " + line)
        }

        var source = Source.fromFile(filename)
        for(line <- source.getLines())
            processLine(line)
    }
}

LongLines.processFile("local_func_input.txt", 5)
