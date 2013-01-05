class Fraction(num: Int, den: Int) extends Ordered[Fraction]{
    private val numerator   = num;
    private val denominator = if(den == 0) throw new IllegalArgumentException else den

    // Orderedトレイトによって、compareだけを定義しておくと、<, <=, >, >=メソッドが使えるようになる
    // equalsだけは定義されない
    def compare(that: Fraction) = this.numerator * that.denominator - that.numerator * this.denominator
}
