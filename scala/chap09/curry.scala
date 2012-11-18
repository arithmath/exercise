def normalAdd(x: Int, y:Int) = x + y
def curryAdd(x: Int)(y: Int) = x + y

println(curryAdd(4)(5))
def threeAdd = curryAdd(3)_
println(threeAdd(5))
