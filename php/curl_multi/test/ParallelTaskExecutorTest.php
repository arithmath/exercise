<?php
require_once __DIR__.'/../ParallelTaskExecutor.php';

class ParallelTaskExecutorTest extends PHPUnit_Framework_TestCase{
    /**
     * @test
     */
    public function execute_引数で渡したタスク全てのexecuteメソッドが実行される(){
        $tasks[0] = $this->createMockTask();
        $tasks[1] = $this->createMockTask();
        $tasks[2] = $this->createMockTask();
        $setting =
            function($task){
                $task->expects($this->once())
                     ->method('execute')
                     ->will($this->returnValue($this->getMock('TaskResult', array(), array(), '', false)));
            };
        array_map($setting, $tasks);

        $target = new ParallelTaskExecutor(3);
        $target->execute($tasks);
    }

    /**
     * @test
     */
    public function execute_タスクが完了するまでタスクのexecuteメソッドが実行される(){
        $tasks[0] = $this->createMockTask();
        $tasks[1] = $this->createMockTask();
        $tasks[2] = $this->createMockTask();
        $setting =
            function($task){
                $task->expects($this->exactly(3))
                     ->method('execute')
                     ->will($this->onConsecutiveCalls(null, null, $this->getMock('TaskResult', array(), array(), '', false)));
            };
        array_map($setting, $tasks);

        $target = new ParallelTaskExecutor(3);
        $target->execute($tasks);
    }

    public function createMockTask(){
        return($this->getMock('Task', array('execute'), array(), '', false));
    }
}
