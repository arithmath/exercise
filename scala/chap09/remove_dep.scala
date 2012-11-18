object FileMatcher{
    private def filesHere = (new java.io.File(".")).listFiles

    def filesMatching(query: String, matcher: (String, String) => Boolean) = {
        for(file <- filesHere
            if matcher(file.getName, query))
            yield file
    }

    def filesEnding(query : String) = filesMatching(query, _.endsWith(_))
    def filesContaining(query : String) = filesMatching(query, _.contains(_))
    def filesRegex(query : String) = filesMatching(query, _.matches(_))
}

FileMatcher.filesContaining("em").foreach(println _)


// クロージャを使用(queryが自由変数)
object FileMatcher2{
    private def filesHere = (new java.io.File(".")).listFiles

    def filesMatching(matcher: (String) => Boolean) = {
        for(file <- filesHere
            if matcher(file.getName))
            yield file
    }

    def filesEnding(query : String)     = filesMatching(_.endsWith(query))
    def filesContaining(query : String) = filesMatching(_.contains(query))
    def filesRegex(query : String)      = filesMatching(_.matches(query))
}
FileMatcher2.filesContaining("em").foreach(println _)
