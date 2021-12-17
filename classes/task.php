<?php 

class Task 
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const STATUS_NAMES = [
        "new" => "Новое",
        "cancelled" => "Отменено",
        "in_progress" => "В работе",
        "done" => "Выполнено",
        "failed" => "Провалено"
    ];

    const ACTION_NAMES = [
        "cancel" => "Отменить", 
        "respond" => "Откликнуться",
        "completed" => "Выполнено",
        "refuse" => "Отказаться" 
    ];

    const TASK_ACTIONS = [
        "new" => [
            "customer" => [
                "cancel",
                "to_work"
            ],
            "employee" => "respond"
        ],
        "in_progress" => [
            "customer" => "completed",
            "employe" => "refuse"
        ]
    ];

    const NEXT_STATUS = [
        "new" => [
            "cancelled",
            "in_progress"
        ],
        "in_progress" => [
            "done",
            "failed"
        ]
    ];

    const RESULT_OF_ACTIONS = [
        "respond" => "new",
        "cancel" => "cancelled",
        "to_work" => "in_progress",
        "completed" => "done",
        "refuse" => "failed"
    ];

  
    public function __construct(int $customer_id, int $employe_id, string $current_status)
    {
       $this->customer_id = $customer_id;
       $this->employe_id = $employe_id;
       $this->current_status = $current_status;
    }

    
    /**
    * Возвращает статус, в который возможен переход при действие указанном в параметере
    * @param string $action Строка, содержащая наименование действия
    * @return ?string
    *
    */
    public function getNextStatus(string $action): ?string
    {
        return $this->RESULT_OF_ACTIONS[$action] ?? null;
    }

    /**
    * Возвращает список действий, которые возможны в статусе указанном в параметре
    * @param string $status Строка, содержащая наименование статуса
    * @return ?array 
    *
    */
    public function getActionsStatus(string $status): ?array 
    {

        return $this->TASK_ACTIONS[$status] ?? null;
    }

};













