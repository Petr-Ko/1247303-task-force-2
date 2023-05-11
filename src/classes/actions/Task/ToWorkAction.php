<?php

namespace TaskForce\classes\actions\Task;

use app\models\Task;

class ToWorkAction extends AbstractAction
{
    protected string $name = "Принять";
    protected string $code = "to_work";

    public function isAvailable(Task $task, int $currentUserId): bool
    {
        if ($currentUserId === $task->customer_id & $task->status === $task::STATUS_NEW) {
            return true;
        }

        return false;
    }
}
