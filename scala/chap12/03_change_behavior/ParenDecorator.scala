trait ParenDecorator extends Printer{
    abstract override def print(str: String) = super.print(String.format("(%s)", str))
}
