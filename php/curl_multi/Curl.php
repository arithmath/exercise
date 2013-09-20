<?php
class Curl{
    private $url;
    private $body;
    private $header;
    private $curl;
    private $mh;
    private $isDone;
    private $isClosed;
    private $errorCode;
    private $errorMessage;
    private $statusCode;

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
        curl_setopt($this->curl, CURLOPT_HEADER, true);
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

    public function getStatusCode($suspendTime = 60){
        $this->waitToFinish($suspendTime);
        return $this->statusCode;
    }
    public function getHeader($key = '', $suspendTime = 60){
        $this->waitToFinish($suspendTime);
        return isset($this->header[$key])?$this->header[$key]:'';
    }

    public function getHeaders($suspendTime = 60){
        $this->waitToFinish($suspendTime);
        return $this->header;
    }

    public function getBody($suspendTime = 60){
        $this->waitToFinish($suspendTime);
        return($this->body);
    }

    public function waitToFinish($suspendTime = 60){
        if($this->isDone){
            return;
        }

        $startTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        while(true){
            list($curlCode, $runningCount) = $this->multiExec();
            if($runningCount === 0){
                $curlErrorCode = $this->getErrorCode();
                switch($curlErrorCode) {
                    case  0 :
                        $response = curl_multi_getcontent($this->curl);
                        list($header, $body) = $this->splitHeaderAndBody($response);
                        $this->recognizeHeader($header);
                        $this->body = $body;
                        $this->close();
                        return;
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

    protected function splitHeaderAndBody($responseBody){
        $splitedBody = explode("\r\n\r\n", $responseBody);
        if(!is_array($splitedBody) || count($splitedBody) === 0){
            throw new RuntimeException("レスポンスをヘッダとボディに分割するのに失敗");
        }elseif(count($splitedBody) === 1){
            echo "[INFO] レスポンスヘッダが空行を0個含んでいました\n";
            return array($responseBody, "");
        }elseif(count($splitedBody) === 2){
            echo "[INFO] レスポンスヘッダが空行を1個含んでいました\n";
            return array($splitedBody[0], $splitedBody[1]);
        }else{
            $header = array_shift($splitedBody);
            $body = implode("\r\n\r\n", $splitedBody);
            echo "[INFO] レスポンスヘッダが空行を" . (count($splitedBody)) . "個含んでいました\n";
            return array($header, $body);
        }
    }
    protected function recognizeHeader($header){
        $splitedHeader = explode("\r\n", $header);
        if(!is_array($splitedHeader) || count($splitedHeader) === 0){
            throw new RuntimeException("ヘッダの解析に失敗しました");
        }

        // ステータスコードを取得
        $firstLine = array_shift($splitedHeader);
        preg_match('/[0-9]{3}/u', $firstLine, $matches);
        if(count($matches) === 0) throw new RuntimeException("ヘッダの解析に失敗しました");

        $this->statusCode = $matches[0];

        foreach($splitedHeader as $headerLine){
            preg_match('/^([^\: ]+) *\: *([^ ].*)$/u', $headerLine, $matches);
            if(count($matches) === 3){
                $this->header[$matches[1]] = $matches[2];
            }
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
