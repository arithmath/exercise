class ArrayElement2(conts: Array[String]) extends Element{
    // Scalaではフィールドとメソッドが同じ名前空間
    // そのためフィールドでメソッドをオーバーライドできる
    val contents: Array[String] = conts
}
