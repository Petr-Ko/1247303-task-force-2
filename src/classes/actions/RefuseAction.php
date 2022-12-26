<?php

namespace TaskForce\classes\actions;

use TaskForce\classes\Task;

//Написать проверку доступно ли действие для этого задания и пользователя
class RefuseAction extends AbstractAction
{
    protected string $name = "Отказаться";
    protected string $code = "refuse";

    public function isAvialable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->executor_id & $task->code_status === "in_progress") {
            return true;
        }

        return false;
    }
}
