val increase = (x : Int) => x + 1
println("--- 5を1増やす ---")
println(increase(5))

// foreachメソッドに関数リテラルを渡す
val someNumbers = List(-11, -10, -5, 0, 5, 10)
println("--- 整数リスト ---")
someNumbers.foreach((x : Int) => println(x))

// filterメソッドに関数リテラルを渡す
val positiveNumbers = someNumbers.filter((x : Int) => x > 0)
println("--- 正の数リスト ---")
positiveNumbers.foreach((x : Int) => println(x))

