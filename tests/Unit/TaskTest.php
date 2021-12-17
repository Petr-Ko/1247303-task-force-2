<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use common\Task;


class TaskTest extends TestCase
{
    public function testMethodsTask()
    {
        $task = new Task(1,1,"new");

        $this->assertEquals($task->getActionsStatus("new"), 
            [
            "customer" => [
                "cancel",
                "to_work"
            ],
            "employee" => "respond"
            ]
        );

        $this->assertEquals($task->getNextStatus("respond"), "new");

    }

}