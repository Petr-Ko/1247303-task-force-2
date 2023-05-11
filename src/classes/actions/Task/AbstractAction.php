<?php

namespace TaskForce\classes\actions\Task;

use app\models\Task;

abstract class AbstractAction
{
    protected string $name;
    protected string $code;


    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    abstract public function isAvailable(Task $task, int $currentUserId): bool;
}
