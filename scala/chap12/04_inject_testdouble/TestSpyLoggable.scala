trait TestSpyLoggable extends Loggable{
    public val log : MutableList[String] = new MutableList();

    def log(message : String) : Unit = {
        println("called TestSpyLogable.")
        this.log :: message
    }

}
