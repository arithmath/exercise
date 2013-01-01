class Logic extends API{
    def execute(id : Int) : String = {
        val result = this.call(id);
        this.log(String.format("API result : %s", result));
        return(result);
    }

    def log(massage : String) : Unit = {
        // なにもしない
    }

    override def call(param : Int) : String = {
        return "success.";
    }
}

object Logic{
    def main(args : Array[String]): Unit = {
        val logic1 = new Logic() with Loggable;
        val res1 = logic1.execute(1);
    }
}
