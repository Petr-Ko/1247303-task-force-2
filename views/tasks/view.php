<?php
/** @var yii\web\View $this */
/** @var yii */

/** @var  $task */
/** @var  $responses */
/** @var  $addResponseForm */
/** @var  $completedTaskForm */


use app\models\User;
use TaskForce\classes\actions\Task\CompletedAction;
use TaskForce\classes\actions\Task\RefuseAction;
use TaskForce\classes\actions\Task\RespondAction;
use TaskForce\classes\actions\Task\ToWorkAction;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Task Force, Задание: $task->title";

$currentUser = (int) Yii::$app->user->getId();
?>

<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?= $task->title ?></h3>
        <p class="price price--big"><?= $task->price?> ₽</p>
    </div>
    <p class="task-description">
        <?=$task->description ?>
    </p>
    <?php if((new RespondAction())->isAvailable($task, $currentUser)): ?>
    <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
    <?php endif; ?>
    <?php if((new RefuseAction())->isAvailable($task, $currentUser)): ?>
    <a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
    <?php endif; ?>
    <?php if((new CompletedAction())->isAvailable($task, $currentUser)): ?>
    <a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>
    <?php endif; ?>
    <div class="task-map">
        <?= $this->render('_map', ['model' => $task->coordinates])?>
        <p class="map-address town"><?= $task->address['city'] ?? "Локация не определена" ?></p>
        <p class="map-address"><?= $task->address['street'].' '.$task->address['build_number'] ?></p>
    </div>
    <?php if((new ToWorkAction())->isAvailable($task, $currentUser)): ?>
    <h4 class="head-regular">Отклики на задание</h4>
    <?php foreach ($responses as $response): ?>
    <?php if(!$response->rejected): ?>
    <div class="response-card">
        <?php $executor = User::findOne($response->executor_id); ?>
        <img class="customer-photo" src="<?= $executor->avatar ?>" width="146" height="156" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <a href="<?= Url::to(['user/view', 'id' => $executor->user_id]); ?>" class="link link--block link--big">
                <?= $executor->first_name . ' ' .$executor->last_name; ?>
            </a>
            <div class="response-wrapper">
                <div class="stars-rating small">
                    <?php for ($i = 1; $i <= (int) $executor->rating; $i++): ?>
                        <span class="fill-star"></span>
                    <?php endfor; ?>
                    <?php for ($i = 1; $i <= 5 - (int) $executor->rating; $i++): ?>
                        <span></span>
                    <?php endfor; ?>
                </div>
                <p class="reviews"><?= $executor->getReviews()->count() . ' отзыва' ?></p>
            </div>
            <p class="response-message">
                <?= $response->description ?>
            </p>
        </div>
        <div class="feedback-wrapper">
            <p class="info-text"><span class="current-time"><?= Yii::$app->formatter->asRelativeTime($response->add_date); ?></span></p>
            <p class="price price--small"><?= $response->price ?> ₽</p>
        </div>
        <div class="button-popup">
            <?= Html::a(
                'Принять',
                ['/tasks/response'],
                [
                                            'class' => 'button button--blue button--small',
                                            'data-method' => 'POST',
                                            'data-params' => [
                                                'response_id' => $response->response_id,
                                                'action' => 'accepted'
                                            ],
                                        ]
            ) ?>
            <?= Html::a(
                'Отказать',
                ['/tasks/response'],
                [
                    'class' => 'button button--orange button--small',
                    'data-method' => 'POST',
                    'data-params' => [
                        'response_id' => $response->response_id,
                        'action' => 'rejected'
                    ],
                ]
            ) ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?= $task->category->name ?></dd>
            <dt>Дата публикации</dt>
            <dd><?php echo Yii::$app->formatter->asRelativeTime($task->add_date); ?></dd>
            <dt>Срок выполнения</dt>
            <dd><?= date_format(date_create($task->end_date), 'd F Y, H:i')?></dd>
            <dt>Статус</dt>
            <dd><?= $task::STATUS_NAMES[$task->status] ?></dd>
        </dl>
    </div>
    <?php if($task->taskFiles): ?>
    <div class="right-card white file-card">
        <h4 class="head-card">Файлы задания</h4>
        <ul class="enumeration-list">
            <?php foreach ($task->taskFiles as $file): ?>
            <li class="enumeration-item">
                <a href="<?= Url::to('/'.$file->file->path) ?>"  class="link link--block link--clip" download="">
                    <?= explode('/', $file->file->path)[1] ?>
                </a>
                <p class="file-size"><?=Yii::$app->formatter->asShortSize(filesize($file->file->path))  ?> </p>
            </li>

            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
<section class="pop-up pop-up--refusal pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отказ от задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <?= Html::a(
            'Отказаться',
            ['/tasks/refused'],
            [
            'class' => 'button button--pop-up button--orange',
            'data-method' => 'POST',
            'data-params' => [
            'task_id' => $task->task_id,
            ],
            ]
        ) ?>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $CompletedForm = ActiveForm::begin([
        'id' => 'form',
        'method' => 'post',
        'options' => ['class' => 'form-group'],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'template' => "{label}\n{input}\n{error}\n",
        ],
        ]); ?>
            <?= $CompletedForm->field($completedTaskForm, 'text')->textarea() ?>
            <?= $CompletedForm->field($completedTaskForm, 'score')->input('number') ?>
            <?= Html::input('submit', null, 'Завершить', ['class' => 'button button--pop-up button--blue']); ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <?php $ResponseForm = ActiveForm::begin([
            'id' => 'form',
            'method' => 'post',
            'options' => ['class' => 'form-group'],
            'fieldConfig' => [
                'options' => ['class' => 'form-group'],
                'template' => "{label}\n{input}\n{error}\n",
                ],
        ]); ?>
                <?= $ResponseForm->field($addResponseForm, 'description')->textarea() ?>
                <?= $ResponseForm->field($addResponseForm, 'price')->input('number') ?>
                <?= Html::input('submit', null, 'Завершить', ['class' => 'button button--pop-up button--blue']); ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<div class="overlay"></div>