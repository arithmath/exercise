trait Logger {
    // トレイトにはフィールド変数を持たせられる。
    // ただし、クラスパラメータから初期化することはできない。
    // つまりtrait Logger(prefix : String){...}という書き方はできない。
    val prefix : String

    def info(message: String)  = this.write("INFO", message)
    def warn(message: String)  = this.write("WARN", message)
    def error(message: String) = this.write("ERROR", message)
    def write(level: String, message:String) = println(String.format("%s : [%s] %s", prefix, level, message))
}
