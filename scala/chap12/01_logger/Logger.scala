trait Logger {
    def info(message: String) = this.write("INFO", message)
    def warn(message: String) = this.write("WARN", message)
    def error(message: String) = this.write("ERROR", message)
    def write(level: String, message:String) = println(level + " : " + message)
}
