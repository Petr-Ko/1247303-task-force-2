<?php

namespace TaskForce\classes\actions;

use TaskForce\classes\Task;

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

    abstract public function isAvialable(Task $task, int $currentUserId): bool;
}
