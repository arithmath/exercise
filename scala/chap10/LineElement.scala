// スーパークラスのコンストラクタを使用
// extendsの部分で引数を指定
class LineElement(s: String) extends ArrayElement(Array(s)){
    // 抽象メソッドをオーバーライドする時はoverride修飾子はオプションだが
    // 具象メソッドをオーバーライドするときはoverride修飾子が必要
    override def width  = s.length
    override def height = 1
}

