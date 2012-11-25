// 2. withでトレイトをミックスインする
//    withキーワードはextendsキーワードの後ろにしか配置できない
//    複数のトレイトを継承する場合は、extendsの後ろにwithを複数用いればよい
class Minuser extends AnyRef with Logger{
    // Loggerトレイトのフィールドに値を設定
    val prefix = String.format("%s[%s]", this.getClass.getName, String.valueOf(this##));

    def calc(num1: Int, num2: Int) = {
        this.info(num1 + "と" + num2 + "を引く")
        num1 - num2
    }
}
