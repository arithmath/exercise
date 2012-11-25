class Printer{
    def print(str: String) = println(str)
}

// Printerクラスにトレイトをミックスインした時の動作を見るためのコンパニオンオブジェクト
object Printer{
    // AsterDecoratorをミックスインしたPrinterを定義
    class AsterPrinter extends AsterDecorator
    
    def test(): Unit = {
        // AsterPrinterオブジェクトを生成
        println("--- AsterPrinter ---")
        val aster1 = new AsterPrinter
        aster1.print("alice")

        // new式にwithを用いて、AsterDecoratorトレイトをミックスインしたPrinterオブジェクトを生成することもできる
        println("--- AsterDecoratorをnew式でミックスイン ---")
        val aster2 = new Printer with AsterDecorator
        aster2.print("bob")

        // 2種類のトレイトをミックスインした時の適用順序を確認。
        // AsterDecorator、ParenDecoratorの順にミックスイン。
        // 適用される順番は基本的に逆順になる
        println("--- AsterDecoratorをミックスイン後, ParenDecoratorをミックスイン ---")
        val aster_paren = new Printer with AsterDecorator with ParenDecorator
        aster_paren.print("carol")
    }
}
