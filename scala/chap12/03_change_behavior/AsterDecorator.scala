// Printerを継承すると、このトレイトをミックスインできるクラスをPrinterに限定できる
trait AsterDecorator extends Printer{

    // トレイトに限り、abstractメソッドでsuperを呼び出すことができる
    abstract override def print(str: String) = super.print(String.format("*** %s ***", str))
}
