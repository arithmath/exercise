<?php
class Curl{
    private $url;
    private $body;
    private $curl;
    private $mh;
    private $isDone;
    private $isClosed;
    private $errorCode;
    private $errorMessage;

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
        $this->isClosed = false;
        $this->errorCode = null;
        $this->errorMessage = '';
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

    public function getBody($suspendTime = 60){
        if($this->isDone){
            return($this->body);
        }

        $startTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        while(true){
            list($curlCode, $runningCount) = $this->multiExec();
            if($runningCount === 0){
                $curlErrorCode = $this->getErrorCode();
                switch($curlErrorCode) {
                    case  0 :
                        $this->body = curl_multi_getcontent($this->curl);
                        $this->close();
                        return($this->body);
                    case 28 :
                        throw new TimeoutException($this);
                    default :
                        throw new CurlException($this);
                }
            }

            // 完了していない場合の処理
            $currentTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $diff = $currentTime->diff($startTime);
            if(intval($diff->format('%s')) >= intval($suspendTime)){
                throw new SuspendException('タイムアウト');
            }
            usleep(1);
        }
    }

    public function getErrorCode(){
        if($this->errorCode === null){
            $info = curl_multi_info_read($this->mh);
            if($info === false){
                return(null);
            }
            $this->errorCode = $info['result'];
        }
        return($this->errorCode);
    }

    public function getErrorMessage(){
        if($this->errorMessage === ''){
            $this->errorMessage = curl_error($this->curl);
        }
        return($this->errorMessage);
    }

    private function close(){
        if($this->isClosed === false){
            $this->isDone = true;
            $this->isClosed = true;
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
                }catch(SuspendException $e){
                    return(null);
                }catch(CurlException $e){
                    return($e);
                }
            };

        $startTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        while(true){
            $result = array_map($getBody, $curls);
            if(array_search(null, $result, true) === false){
                return($result);
            }

            $currentTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $diff = $currentTime->diff($startTime);
            if(intval($diff->format('%s')) >= intval($timeout)){
                return($result);
            }
            usleep(1);
        }
    }
}


class CurlException extends Exception{
    public function __construct(Curl $curl, $prev = null){
        parent::__construct($curl->getErrorMessage(), $curl->getErrorCode(), $prev);
    }
}
class TimeoutException extends CurlException{
}

class SuspendException extends Exception{
}
?>
