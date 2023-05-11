<?php

namespace TaskForce\classes;

use TaskForce\classes\actions\Task\CancelAction;
use TaskForce\classes\actions\Task\CompletedAction;
use TaskForce\classes\actions\Task\RefuseAction;
use TaskForce\classes\actions\Task\RespondAction;
use TaskForce\classes\actions\Task\ToWorkAction;
use TaskForce\classes\ex\StatusAvailableException;

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public const STATUS_NAMES = [
        "new" => "Новое",
        "cancelled" => "Отменено",
        "in_progress" => "В работе",
        "done" => "Выполнено",
        "failed" => "Провалено"
    ];

    public const NEXT_STATUS = [
        "new" => [
            "cancelled",
            "in_progress"
        ],
        "in_progress" => [
            "done",
            "failed"
        ]
    ];

    public const RESULT_OF_ACTIONS = [
        "respond" => "new",
        "cancel" => "cancelled",
        "to_work" => "in_progress",
        "completed" => "done",
        "refuse" => "failed"
    ];


    public function __construct(int $customer_id, int $executor_id, string $code_status)
    {

        $status_available = array_key_exists($code_status, $this::STATUS_NAMES);

        if($status_available === false) {
            throw new StatusAvailableException("Недопустимый код статуса: $code_status");
        };  

        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->code_status = $code_status;


    }


    /**
    * Возвращает код статуса, в который возможен переход при действие указанном в параметере
    * @param string $action Строка, содержащая код действия
    * @return ?string
    *
    */
    public function getNextStatus(string $code_action): ?string
    {
        return $this::RESULT_OF_ACTIONS[$code_action] ?? null;
    }

    /**
    * Возвращает массив объектов действий с заданием, доступных для пользователя, указанного в параметре
    * @param int $currentUserId число, ID пользователя
    * @return ?array
    */
    public function getActions(int $currentUserId): ?array
    {
        $actions = [];

        $cancelAction = new CancelAction();
        $completedActicon = new CompletedAction();
        $refuseAction = new RefuseAction();
        $respondAction = new RespondAction();
        $toWorkAction = new ToWorkAction();

        if ($cancelAction->isAvialable($this, $currentUserId)) {
            array_push($actions, $cancelAction);
        }

        if ($completedActicon->isAvialable($this, $currentUserId)) {
            array_push($actions, $completedActicon);
        }

        if ($refuseAction->isAvialable($this, $currentUserId)) {
            array_push($actions, $refuseAction);
        }

        if ($respondAction->isAvialable($this, $currentUserId)) {
            array_push($actions, $respondAction);
        }

        if ($toWorkAction->isAvialable($this, $currentUserId)) {
            array_push($actions, $toWorkAction);
        }

        return $actions;
    }

    /**
    * Возвращает наименование статуса, указанного в параметре экземпляра класса
    * @return ?string
    *
    */
    public function getStatusName(): ?string
    {
        return $this::STATUS_NAMES[$this->code_status] ?? null;
    }

    /**
    * Возвращает наименование действия, по коду статуса, указанного в параметре
    * @param string $code_action Строка, содержащая код действия
    * @return ?string
    *
    */
    public function getActionName(string $code_action): ?string
    {
        return $this::ACTION_NAMES[$code_action] ?? null;
    }
};
