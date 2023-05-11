<?php

namespace TaskForce\classes\actions\Task;

use app\models\Task;

class CompletedAction extends AbstractAction
{
    protected string $name = "Завершить";
    protected string $code = "completed";

    public function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->customer_id & $task->status === $task::STATUS_IN_PROGRESS) {
            return true;
        }

        return false;
    }
}
