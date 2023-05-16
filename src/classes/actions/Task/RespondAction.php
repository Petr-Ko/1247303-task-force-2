<?php

namespace TaskForce\classes\actions\Task;

use app\models\Responses;
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

    public function acceptResponse(Task $task, Responses $response)
    {

        $task->status = Task::STATUS_IN_PROGRESS;
        $task->executor_id = $response->executor_id;
        $task->price = $response->price;

        if($task->save()) {

            return true;
        }
        return false;
    }
}
