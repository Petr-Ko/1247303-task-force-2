<?php

namespace Tests\Unit;

require  __DIR__. "/../../classes/Task.php";

use PHPUnit\Framework\TestCase;

use Task;

class TaskTest extends TestCase
{
    public function testMethodsTask()
    {
        $task = new Task(1, 2, "new");

        $this->assertEquals($task->getActionsStatus("new", 1), ["cancel","to_work"]);

        $this->assertEquals($task->getActionsStatus("new", 2), ["respond"]);

        $this->assertEquals($task->getNextStatus("respond"), "new");

        $this->assertEquals($task->getStatusName(), "Новое");

        $this->assertEquals($task->getActionName("respond"), "Откликнуться");
    }
}
