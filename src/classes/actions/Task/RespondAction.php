<?php

namespace TaskForce\classes\actions\Task;

use app\models\Task;
use app\models\User;

class RespondAction extends AbstractAction
{
    protected string $name = "Откликнуться";
    protected string $code = "respond";

    public function isAvailable(Task $task, int $currentUserId): bool
    {
        if (User::findOne($currentUserId)->is_executor & !$task->executor_id & $task->status === $task::STATUS_NEW) {
            return true;
        }
        return false;
    }
}
