// zipメソッドは二つの配列の同じインデックスの要素を結合させたタプルの配列を作る。
// 二つの配列の要素数が異なる場合、多い方の要素が切り捨てられる
val array1 = Array("alice", "bob", "carol")
val array2 = Array("dave", "eve")
val array3 = array1 zip array2 // (alice, dave)と(bob, eve)ができる

println(array3(0))
println(array3(1))
// println(array3(2))
