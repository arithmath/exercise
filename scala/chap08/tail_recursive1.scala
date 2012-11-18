// 末尾再帰ではない関数 : 最適化されない
def notTail(count : Int): Int = {
    if(count != 0)
        notTail(count - 1) + 1 // 最後がただのnotTail呼び出しでないので、末尾再帰最適化されない
                               // ほかにも、他の関数の引数にnotTailを使っている場合も、最適化されない
    else
        throw new Exception("例外発生")
}

// 末尾再帰関数 : 最適化される
def tail(count : Int): Int = {
    if(count != 0)
        tail(count - 1) // 最後がただのtail呼び出しなので、末尾再帰最適化がなされる
    else
        throw new Exception("例外発生")
}

// 相互末尾再帰 : 末尾再帰でない関数と同じで、最適化されない
def mutRec1(count : Int): Int = {
    if(count != 0)
        mutRec2(count - 1)
    else
        throw new Exception("例外発生")
}
def mutRec2(count : Int): Int = {
    if(count != 0)
        mutRec1(count - 1)
    else
        throw new Exception("例外発生")
}


println("--- 末尾再起でない場合 ---")
println("※ スタックトレースにnotTailが複数表示されます")
try{
    notTail(3);
}catch{
    case e : Exception => e.printStackTrace()
}

println("--- 末尾再起の場合 ---")
println("※ スタックトレースにtailが1つ表示されます")
try{
    tail(3);
}catch{
    case e : Exception => e.printStackTrace()
}

println("--- 相互末尾再起の場合 ---")
println("※ 末尾再帰でないのと同じようになります")
try{
    mutRec1(3);
}catch{
    case e : Exception => e.printStackTrace()
}
