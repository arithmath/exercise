def echo(args : String*) = for(arg <- args) println(arg)

// 通常の可変長引数呼び出し
echo("alice", "bob", "carol")

// 配列形式で渡す
println("---------")
var arr = Array("alice", "bob", "carol")
//echo(arr) // この記法だとコンパイルエラー
echo(arr : _*)
