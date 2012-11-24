class ArrayElement(conts: Array[String]) extends Element{
    // 抽象メソッドをオーバーライド。
    // override修飾子をつけなくてよい(具象メソッドでは必須)。
    def contents: Array[String] = conts
}
