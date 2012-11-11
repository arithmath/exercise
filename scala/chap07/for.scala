import java.io.File

val filesHere = (new java.io.File(".")).listFiles

println("---- file ----")
for(file <- filesHere)
  println(file)

println("---- filtering : only scala file ----")
for(file <- filesHere
    if file.isFile
    if file.getName.endsWith(".scala"))
  println(file)

// 1つのforループに複数のイテレータを使用できる
println("---- filtering : only scala file and line with println ----")
for(file <- filesHere
    if file.isFile
    if file.getName.endsWith(".scala");
    line <- scala.io.Source.fromFile(file).getLines().toList
    if line.trim.matches(".*println.*"))
    println(line);

// forで使用するコレクションを取得
println("---- yielded list ----")
def scalaFiles = for(file <- filesHere
                     if file.isFile
                     if file.getName.endsWith(".scala")) yield file
for(file <- scalaFiles)
    println(file.getName);

// 数字を使ったfor文
println("---- basic for ----")
for (i <- 1 to 4)
  println("Iteration " + i)


