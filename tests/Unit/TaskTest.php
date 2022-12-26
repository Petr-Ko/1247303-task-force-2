<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use TaskForce\classes\Task;
use TaskForce\classes\actions\CancelAction;
use TaskForce\classes\actions\CompletedAction;
use TaskForce\classes\actions\RefuseAction;
use TaskForce\classes\actions\RespondAction;
use TaskForce\classes\actions\ToWorkAction;

class TaskTest extends TestCase
{
    public function testNextStatusTask()
    {
        $task = new Task(1, 2, "new");

        $this->assertEquals($task->getNextStatus("respond"), "new");
    }

    public function testActionStatusNew()
    {
        $task = new Task(1, 2, "new");

        $testValueCustomer = [new CancelAction(), new ToWorkAction()];

        $testValueExecutor = [new RespondAction()];

        $this->assertEquals($task->getActions(1), $testValueCustomer);

        $this->assertEquals($task->getActions(2), $testValueExecutor);
    }

    public function testActionStatusInProgress()
    {
        $task = new Task(1, 2, "in_progress");

        $testValueCustomer = [new CompletedAction()];

        $testValueExecutor = [new RefuseAction()];

        $this->assertEquals($task->getActions(1), $testValueCustomer);

        $this->assertEquals($task->getActions(2), $testValueExecutor);
    }
}
