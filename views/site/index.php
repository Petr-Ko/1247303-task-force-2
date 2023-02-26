<?php

/** @var yii\web\View $this */
/** @var  $category_names */
/** @var  $executors */

use yii\bootstrap5\Html;

$this->title = 'Task Force';
;

?>

<h1><?= Html::encode($this->title) ?></h1>

<div>
    <p>Доступные категории заданий:</p>
    <ul>
        <?php foreach ($category_names as $category_name): ?>
            <li><?= Html::encode($category_name) ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Список исполнителей зарегистрованных в сервисе:</p>
    <ul>
        <?php foreach ($executors as $executor): ?>
            <li><?= Html::encode("ФИО: ". $executor['first_name']." " . $executor['last_name'].", город: ". $executor['cities']['name'])  ?></li>
        <?php endforeach; ?>
    </ul>
</div>
