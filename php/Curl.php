<?php
class Curl{
    private $url;
    private $body;
    private $curl;
    private $mh;
    private $isDone;

    public function __construct($url = '', $timeout = 180){
        if(!is_string($url)){
            throw new InvalidArgumentException(sprintf('パラメータが文字列ではありません : $url=%s', var_export($url, true)));
        }
        if(!is_int($timeout)){
            throw new InvalidArgumentException(sprintf('パラメータが数字ではありません : $timeout=%s', var_export($timeout, true)));
        }

        $this->url  = $url;
        $this->curl = curl_init($url);
        $this->body = '';
        $this->mh   = curl_multi_init();
        $this->isDone = false;
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
        curl_multi_add_handle($this->mh, $this->curl);
        $this->multiExec();
    }

    function __destruct(){
        $this->close();
    }

    protected function multiExec(){
        $curlCode = curl_multi_exec($this->mh, $runningCount);
        return(array($curlCode, $runningCount));
    }

    public function getBody($timeout = 60){
        if($this->isDone){
            return($this->body);
        }

        $startTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        while(true){
            list($curlCode, $runningCount) = $this->multiExec();
            if($runningCount === 0){
                if($curlCode === CURLM_OK){
                    break;
                }else{
                    $this->close();
                    throw new Exception('curlError', $curlCode);
                }
            }
            // 完了していない場合の処理
            usleep(1);
            $currentTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $diff = $currentTime->diff($startTime);
            if(intval($diff->format('%s')) >= intval($timeout)){
                throw new OperationTimeoutException('タイムアウト');
            }
        }
        $this->body = curl_multi_getcontent($this->curl);
        $this->close();
        return($this->body);
    }
    private function close(){
        if($this->isDone === false){
            $this->isDone = true;
            curl_close($this->curl);
            curl_multi_remove_handle($this->mh, $this->curl);
            curl_multi_close($this->mh);
        }
    }

    public static function getBodies(array $curls = array(), $timeout = 60){
        $paramCheck =
            function($elem){
                if(!is_a($elem, 'Curl')){
                    throw new InvalidArgumentException('Curlクラスオブジェクトではありません');
                }
            };
        array_map($paramCheck, $curls);

        $getBody =
            function($curl){
                try{
                    return($curl->getBody(0));
                }catch(OperationTimeoutException $e){
                    return(false);
                }catch(Exception $e){
                    return(false);
                }
            };

        $startTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        while(true){
            $result = array_map($getBody, $curls);
            if(array_search(false, $result, true) === false){
                return($result);
            }

            usleep(1);
            $currentTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $diff = $currentTime->diff($startTime);
            if(intval($diff->format('%s')) >= intval($timeout)){
                return($result);
            }
        }
    }
}

class OperationTimeoutException extends Exception{

}
?>
