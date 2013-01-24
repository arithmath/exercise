<?php
require_once __DIR__.'/Curl.php';

class Task{
    private static $defaultErrorAction = null;
    private $curl;
    private $url;
    private $timeout;
    private $isDone;
    private $normalAction;
    private $errorAction;

    public function __construct($url, $timeout, Closure $normalAction, Closure $errorAction = null)
    {
        if(static::$defaultErrorAction === null){
            static::$defaultErrorAction = function($exception){return $exception;};
        }
        $this->curl         = null;
        $this->url          = $url;
        $this->timeout      = $timeout;
        $this->isDone       = false;
        $this->normalAction = $normalAction;
        $this->errorAction  = ($errorAction === null)?(static::$defaultErrorAction):$errorAction;
    }

    public function execute($suspendTime = 0){
        if($this->isDone){
            throw new Exception('完了したタスクが再度実行されました');
        }
        if($this->curl === null){
            $this->curl = new Curl($this->url, $this->timeout);
        }
        try{
            $body = $this->curl->getBody($suspendTime);
            $this->finish();
            $action = $this->normalAction;
            return(new TaskResult(true, $action($body)));
        }catch(SuspendException $e){
            return(null);
        }catch(Exception $e){
            $this->finish();
            $action = $this->errorAction;
            return(new TaskResult(false, $action($e)));
        }
    }

    private function finish(){
        $this->isDone = true;
        $this->curl = null;
    }
}

class TaskResult{
    private $success;
    private $result;
    public function __construct($success, $result){
        if(!is_bool($success)) throw new InvalidArgumentException();

        $this->success = $success;
        $this->result = $result;
    }
    public function isSuccess(){
        return($this->success);
    }
    public function get(){
        return($this->result);
    }
}
?>
