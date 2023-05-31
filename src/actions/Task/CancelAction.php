<?php

namespace TaskForce\actions\Task;

use app\models\Task;

class CancelAction extends AbstractAction
{
    protected string $name = "Отменить";
    protected string $code = "Cancel";


    public function isAvailable(Task $task, int $currentUserId): bool
    {

        if ($currentUserId === $task->customer_id && $task->status === $task::STATUS_NEW) {
            return true;
        }

        return false;
    }


}
