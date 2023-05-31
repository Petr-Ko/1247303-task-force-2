<?php

namespace TaskForce\actions\Task;

use app\models\Task;

class RefuseAction extends AbstractAction
{
    protected string $name = "Отказаться";
    protected string $code = "refuse";

    public function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->executor_id && $task->status === $task::STATUS_IN_PROGRESS) {
            return true;
        }

        return false;
    }
}
