// 1. extendsでトレイトをミックスインする
class Adder extends Logger{
    // Loggerトレイトのフィールドに値を設定
    val prefix = String.valueOf(this##)

    def calc(num1: Int, num2: Int) = {
        this.info(num1 + "と" + num2 + "を足す")
        num1 + num2
    }
}
