<?php

namespace TaskForce\classes\actions;

use TaskForce\classes\Task;

class CompletedAction extends AbstractAction
{
    protected string $name = "Выполнено";
    protected string $code = "completed";

    public function isAvialable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->customer_id & $task->code_status === "in_progress") {
            return true;
        }

        return false;
    }
}
