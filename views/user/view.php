<?php
/** @var yii\web\View $this */
/** @var yii */

/** @var  $user */
/** @var  $reviews */

use app\models\Categories;
use app\models\Task;
use yii\helpers\Url;


$this->title = 'Task Force, Пользователь: ' . $user->first_name .' '. $user->last_name;

?>

<div class="left-column">
    <h3 class="head-main"><?= $user->first_name .' '. $user->last_name ?></h3>
    <div class="user-card">
        <div class="photo-rate">
            <img class="card-photo" src="/img/man-glasses.png" width="191" height="190" alt="Фото пользователя">
            <div class="card-rate">
                <div class="stars-rating big"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                <span class="current-rate">4.23</span>
            </div>
        </div>
        <p class="user-description"><?= $user->information?></p>
    </div>
    <div class="specialization-bio">
        <?php if ($user->is_executor): ?>
        <div class="specialization">
            <p class="head-info">Специализации</p>
            <ul class="special-list">
                <?php foreach ($user->executorCategories as $categories) : ?>
                <li class="special-item">
                    <a href="#" class="link link--regular"><?= Categories::findOne(['category_id' => $categories->category_id])->name ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="bio">
            <p class="head-info">Био</p>
            <p class="bio-info"><span class="country-info">Россия</span>, <span class="town-info"><?= $user->cities->name ?></span>, <span class="age-info"><?= $user->age ?></span> лет</p>
        </div>
    </div>
    <h4 class="head-regular">Отзывы заказчиков</h4>
    <?php foreach ($reviews as $review): ?>
    <div class="response-card">
        <img class="customer-photo" src="/img/man-coat.png" width="120" height="127" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <p class="feedback"><?= $review->text ?></p>
            <p class="task">Задание «<a href="<?= Url::to(['/tasks/view', 'id' => $review->task->task_id ]) ?>" class="link link--small"><?= $review->task->title ?></a>» <?= Task::STATUS_NAMES[$review->task->status] ?></p>
        </div>
        <div class="feedback-wrapper">
            <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
            <p class="info-text"><span class="current-time"><?php echo Yii::$app->formatter->asRelativeTime($review->add_date); ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<div class="right-column">
    <div class="right-card black">
        <h4 class="head-card">Статистика исполнителя</h4>
        <dl class="black-list">
            <dt>Всего заказов</dt>
            <dd>
                <?=
                    $user->getTasks()->done()->count() .' выполнено '.
                    $user->getTasks()->failed()->count().' провалено'
                ?>
            </dd>
            <dt>Место в рейтинге</dt>
            <dd><?= $user->rating ?> место</dd>
            <dt>Дата регистрации</dt>
            <dd><?= date_format(date_create($user->add_date), 'd F Y, H:i')?></dd>
            <dt>Статус</dt>
            <dd>Открыт для новых заказов</dd>
        </dl>
    </div>
    <div class="right-card white">
        <h4 class="head-card">Контакты</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="#" class="link link--block link--phone"><?= $user->phone ?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--email"><?= $user->email ?></a>
            </li>
            <?php if(isset($user->telegram)):?>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--tg"><?= $user->telegram ?></a>
                </li>
            <?php endif;?>
        </ul>
    </div>
</div>