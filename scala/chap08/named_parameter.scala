println("--- 名前付き引数 ---")
def printPoint(x: Int, y: Int) =
        println("(x, y) = (" + x + ", " + y + ")")

printPoint(10, 29)
printPoint(y = 10, x = 29) // 引数名を指定してコール


println("--- デフォルト引数 ---")
def printPoint2(x: Int = 0, y: Int = 0) =
        println("(x, y) = (" + x + ", " + y + ")")
printPoint2(10, 20)
printPoint2()       // 両方デフォルト値が使われる
printPoint2(10)     // 先頭の引数以外にデフォルト値が使われる
printPoint2(y = 20) // y以外のパラメータにデフォルト値が使われる
