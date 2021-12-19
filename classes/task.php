<?php

namespace TaskForce;

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

    public const ACTION_NAMES = [
        "cancel" => "Отменить",
        "respond" => "Откликнуться",
        "completed" => "Выполнено",
        "refuse" => "Отказаться"
    ];

    public const TASK_ACTIONS = [
        "new" => [
            "customer" => [
                "cancel",
                "to_work"
            ],
            "executor" => ["respond"]
        ],
        "in_progress" => [
            "customer" => "completed",
            "executor" => "refuse"
        ]
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
    * Возвращает массив кодов действий, которые возможны в статусе, указанном в параметре
    * @param string $code_status Строка, содержащая код статуса
    * @return ?array
    *
    */
    public function getActionsStatus(string $code_status, int $current_user_id): ?array
    {
        if ($current_user_id === $this->customer_id) {
            return $this::TASK_ACTIONS[$code_status]["customer"] ?? null;
        }
        if ($current_user_id === $this->executor_id) {
            return $this::TASK_ACTIONS[$code_status]["executor"] ?? null;
        }

        return null;
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
