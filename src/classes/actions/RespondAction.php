<?php

namespace TaskForce\classes\actions;

use TaskForce\classes\Task;

class RespondAction extends AbstractAction
{
    protected string $name = "Откликнуться";
    protected string $code = "respond";

    public function isAvialable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->executor_id & $task->code_status === "new") {
            return true;
        }

        return false;
    }
}
