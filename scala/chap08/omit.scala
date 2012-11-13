val someNumbers = List(-11, -10, -5, 0, 4, 32)

// 型推論による引数の型の省略
println("--- 0より大きい値を表示 ---")
someNumbers.filter(x => x > 0) // filterメソッドの定義から、xの型が推論できる
           .foreach(x => println(x))

// プレースホルダー構文
println("--- 0より小さい値を表示 ---")
someNumbers.filter(_ < 0)
           .foreach(println(_))

// プレースホルダー構文は、各引数が1度だけ使われる時だけ使用可能。
// n個目の引数がn個目の_に対応するためである。
println("--- 12 + 33を実施 ---")
var add = (_: Int) + (_: Int) // 型推論ができないので、型を指定
println(add(12, 33));
