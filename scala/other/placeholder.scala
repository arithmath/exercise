// メソッドが呼び出されるオブジェクトをプレースホルダーにしてみる
val func = (_: String).endsWith("hoge")

// 確認
println(func("alice"))
println(func("bob"))
println(func("test_hoge"))
