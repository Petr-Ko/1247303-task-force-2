<?php

namespace TaskForce\classes\actions;

use TaskForce\classes\Task;

class ToWorkAction extends AbstractAction
{
    protected string $name = "В работу";
    protected string $code = "to_work";

    public function isAvialable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->customer_id & $task->code_status === "new") {
            return true;
        }

        return false;
    }
}
