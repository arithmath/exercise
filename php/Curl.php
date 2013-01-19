<?php
class Curl{
    private $curl;
    private $mh;

    public function __construct($url = '', $timeout = 180){
        if(!is_string($url)){
            throw new InvalidArgumentException(sprintf('パラメータが文字列ではありません : $url=%s', var_export($url, true)));
        }
        if(!is_int($timeout)){
            throw new InvalidArgumentException(sprintf('パラメータが数字ではありません : $timeout=%s', var_export($timeout, true)));
        }

        $this->curl = curl_init($url);
        $this->mh   = curl_multi_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
        curl_multi_add_handle($this->mh, $this->curl);
        $this->multiExec();
    }

    protected function multiExec(){
        $curlCode = curl_multi_exec($this->mh, $runningCount);
        return(array($curlCode, $runningCount));
    }

    public function getBody($timeout = '60'){
        $startTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));

        while(true){
            list($curlCode, $runningCount) = $this->multiExec();
            if($runningCount === 0){
                if($curlCode === CURLM_OK){
                    break;
                }else{
                    throw new Exception('curlError', $curlCode);
                }
            }
            // 完了していない場合の処理
            usleep(1);
            $currentTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $diff = $currentTime->diff($startTime);
            if(intval($diff->format('%s'))){
                throw new OperationTimeoutException('タイムアウト');
            }
        }
        return(curl_multi_getcontent($this->curl));
    }
}

class OperationTimeoutException extends Exception{

}
?>
