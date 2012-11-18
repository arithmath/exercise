var assertionsEnabled = true // これがtrueの場合、assertを行う

// 名前付きパラメータを使用しない例
def myAssert1(predicate: () => Boolean) =
    if (assertionsEnabled && !predicate())
        throw new AssertionError
myAssert1{
    () => 5 > 3 // "() =>"がよけい
}

// 名前つきパラメータを使用
def myAssert2(predicate: => Boolean) =   // predictの型から()を取り除く
    if (assertionsEnabled && !predicate) // predictから()を取り除く
        throw new AssertionError
myAssert2{
    5 > 2
}

// 名前つきパラメータではなくて、単純に引数をBooleanにする
def myAssert3(predicate: Boolean) = // predictの型からさらに=>を取り除く
    if (assertionsEnabled && !predicate)
        throw new AssertionError
myAssert3{
    5 > 2
}

// myAssert2とmyAssert3では引数の評価のタイミングが異なる
assertionsEnabled = false // アサーションを無効化
myAssert2{
    // 名前付きパラメータを使用した場合、必要になったときに引数を評価する
    1 / 0 > 1 // assertionsEnabledがfalseなので、評価する必要がない
}
myAssert3{
    // 引数が先に評価される
    1 / 0 > 1 // 評価されるため、0除算でエラーになる
}
