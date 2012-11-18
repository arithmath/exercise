// コレクションの中に条件を満たす要素を含むかどうかを調べる
def containsOdd(nums: List[Int]) = nums.exists(_ % 2 == 1)

val list1 = List(1, 2, 3, 4, 5)
val list2 = List(2, 4)
val list3 = List(1, 3, 5)
println(containsOdd(list1))
println(containsOdd(list2))
println(containsOdd(list3))
