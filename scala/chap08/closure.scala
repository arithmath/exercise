println("--- クロージャのテスト ---")
def adder(init : Int) = (x : Int) => x + init
val func1 = adder(100);
val func2 = adder(1000);

println(func1(1))
println(func1(5))
println(func1(10))
println(func2(1))
println(func2(5))
println(func2(10))

// 自由変数の共有
println("--- 自由変数の振る舞いの確認 ---")
var share = 0 // 自由変数を用意
def incrementer() = {
        share += 1 // 自由変数を更新
        share
    }
println("shareの値" + share)
println("inc1にクロージャを代入")
val inc1 = incrementer
println("shareの値" + share)
println("inc2にクロージャを代入")
val inc2 = incrementer
println("shareの値" + share)
println("inc1を実行" + inc1)
println("inc1を実行" + inc1)
println("inc2を実行" + inc2)
println("inc2を実行" + inc2)
println("inc1を実行" + inc1)
println("shareの値" + share)
println("自由変数を1000に変更")
share = 1000;
println("shareの値" + share)
println("inc1を実行" + inc1)
println("inc2を実行" + inc2)
println("shareの値" + share)

// カウンタを生成する
println("--- カウンタをクロージャで生成 ---")
def counter(init : Int) = {
        var count = init;
        () => {
            val currentCount = count
            count = count + 1
            currentCount
        }
    }

val counter1 = counter(10000);
val counter2 = counter(20000);
println(counter1());
println(counter2());
println(counter1());
println(counter2());
