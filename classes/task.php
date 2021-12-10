<?php 

class Task 
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    public $status_names = [
        "new" => "Новое",
        "cancelled" => "Отменено",
        "in_progress" => "В работе",
        "done" => "Выполнено",
        "failed" => "Провалено"
    ];

    public $action_names = [
        "cancel" => "Отменить", 
        "respond" => "Откликнуться",
        "completed" => "Выполнено",
        "refuse" => "Отказаться" 
    ];

    private $task_actions = [
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

    private $next_statuses = [
        "new" => [
            "cancelled",
            "in_progress"
        ],
        "in_progress" => [
            "done",
            "failed"
        ]
    ];

    private $results_of_actions = [
        "respond" => "new",
        "cancel" => "cancelled",
        "to_work" => "in_progress",
        "completed" => "done",
        "refuse" => "failed"
    ];

    private $current_status = null;

    public function __construct(int $customer_id, int $employe_id)
    {
       $this->customer_id = $customer_id;
       $this->employe_id = $employe_id;
    }

    
    /**
    * Возвращает статус, в который возможен переход при действие указанном в параметере
    * @param string $action Строка, содержащая наименование действия
    * @return ?string
    *
    */
    public function GetNextStatus(string $action): ?string
    {
        foreach($this->results_of_actions as $key => $result){
            if($action === $key) {

                $this->current_status = $result;

                return $result;
            }
        }
        return null;
    }

    /**
    * Возвращает список действий, которые возможны в статусе указанном в параметре
    * @param string $status Строка, содержащая наименование статуса
    * @return ?array 
    *
    */
    public function GetActionsStatus(string $status): ?array 
    {

        foreach($this->task_actions as $key => $action){
            if($status === $key) {

                return $action;
            }
        }
        return null;
    }

};













