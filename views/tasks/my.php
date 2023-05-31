<?php

/** @var yii\web\View $this */
/** @var yii */

/** @var  $tasks */
/** @var  $is_executor */

use yii\helpers\Url;


$this->title = 'Мои задания, Task Force';

?>
<div class="left-menu">
    <h3 class="head-main head-task">Мои задания</h3>
    <ul class="side-menu-list">
        <li class="side-menu-item side-menu-item">
            <?php if(!$is_executor):?>
            <a href="<?=Url::to('/tasks/my/new') ?>" class="link link--nav">Новые</a>
            <?php else: ?>
            <a href="<?=Url::to('/tasks/my/overdue') ?>" class="link link--nav">Просрочено</a>
            <?php endif; ?>
        </li>
        <li class="side-menu-item">
            <a href="<?=Url::to('/tasks/my/progress') ?>" class="link link--nav">В процессе</a>
        </li>
        <li class="side-menu-item">
            <a href="<?=Url::to('/tasks/my/done') ?>" class="link link--nav">Закрытые</a>
        </li>
    </ul>
</div>
<div class="left-column left-column--task">
    <h3 class="head-main head-regular">Задания</h3>
    <?php foreach ($tasks as $task): ?>
    <div class="task-card">
        <div class="header-task">
            <a  href="<?= Url::to(['/tasks/view', 'id' => $task->task_id]) ?>" class="link link--block link--big"><?= $task->title ?></a>
            <p class="price price--task"><?= $task->price ?> ₽</p>
        </div>
        <p class="info-text"><span class="current-time"><?= Yii::$app->formatter->asRelativeTime($task->add_date); ?></p>
        <p class="task-text"><?= $task->description ?></p>
        <div class="footer-task">
            <p class="info-text town-text"><?= $task->address['city'] ?? "Локация не определена" ?></p>
            <p class="info-text category-text"><?= $task->category->name ?></p>
            <a href="<?= Url::to(['/tasks/view', 'id' => $task->task_id]) ?>" class="button button--black">Смотреть Задание</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
