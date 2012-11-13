def sum(arg1: Int, arg2: Int, arg3: Int) = arg1 + arg2 + arg3

// 2番目の引数以外に数字を当てはめた部分関数を作成
var partial_sum1 = (x: Int) => sum(2, x, 7)
println(partial_sum1(3));
println(partial_sum1.apply(3)); // 前の行と等価
// プレースホルダー構文で記載
var partial_sum2 = sum(2, _: Int, 7)
println(partial_sum2(3));

// 全引数を1個の_で置き換え、部分関数を作成することができる
var partial_sum3 = sum _
println(partial_sum3(1, 3, 4))

// 全引数を1個の_で置き換えた場合、その関数をその場で使うときは
// _まで省略することができる。
val numbers = List(1, 2, 3, 4, 5)
numbers.foreach(println) // 本来はprintln _
// その場で使用できない、以下のようなコードではエラーになる。
// var partial_sum4 = sum
