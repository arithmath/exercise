<?php
require_once __DIR__.'/Curl.php';
require_once __DIR__.'/Task.php';

class ParallelTaskExecutor{
    private static $defaultLogFunction = null;
    private static $noLogFunction = null;
    public $executingTasks;
    public $parallelNum;
    public $result;
    public $logFunction;

    public function __construct($parallelNum = 10){
        if(static::$defaultLogFunction === null){
            static::$defaultLogFunction =
                function($message){
                    $dateTime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
                    echo sprintf("[%s] %s\n", $dateTime->format('Y-m-d H:i:s u'), $message);
                };
        }
        if(static::$noLogFunction === null){
            static::$noLogFunction = function($message){};
        }

        $this->parallelNum = $parallelNum;
        $this->result = array();
        $this->disableLog();
    }

    /**
     */
    public function execute(array $tasks){
        array_map(function($task){if(!is_a($task, 'Task')){throw new InvalidArgumentException();}}, $tasks);

        $this->result = array();
        $this->executingTasks = array();

        // 1個1個タスクを追加して、parallelNum個たまったらタスクを実行する
        foreach($tasks as $key => $task){
            $this->store($key, $task);
        }

        // 残ったタスクを実行
        while(count($this->executingTasks) > 0){
            $this->progress();
        }

        // progressメソッドでためておいた、タスクの実行結果を返す
        $result = $this->result;
        $this->result = null;
        return($result);
    }

    /**
     * ログ出力を有効化させます
     */
    public function enableLog(Closure $logFunction = null){
        $this->logFunction = ($logFunction === null)?(static::$defaultLogFunction):($logFunction);
    }

    /**
     * ログ出力を無効化させます
     */
    public function disableLog(){
        $this->logFunction = static::$noLogFunction;
    }

    /**
     * $executingTasksにタスクを1つためます。
     * タスク数がある程度たまると、progressメソッドを実行します。
     */
    protected function store($key, Task $task){
        $this->log('store. key=['.$key.']');
        $this->executingTasks[$key] = $task;
        if(count($this->executingTasks) >= $this->parallelNum){
            $this->progress();
        }
    }

    /**
     * $executingTasksにためられているタスクを最低1つ完了させます。
     */
    protected function progress(){
        $this->log(sprintf('progress. count=[%s]', count($this->executingTasks)));
        $progress = false;
        while(true){
            foreach($this->executingTasks as $key => $task){
                $result = $task->execute();
                if($result === null){
                    continue;
                }
                unset($this->executingTasks[$key]);
                $progress = true;
                $this->result[$key] = $result;
                $this->log(sprintf('finish task. key=[%s]', $key));
            }
            if($progress === true) break;
            usleep(1);
        }
    }

    protected function log($message){
        $logFunction = $this->logFunction;
        $logFunction($message);
    }
}
?>
