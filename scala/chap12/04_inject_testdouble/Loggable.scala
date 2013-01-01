trait Loggable{
    def log(message : String) : Unit = {
        println("called original Logable.")
        println(message)
    }

}
