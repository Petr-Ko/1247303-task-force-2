<?php

/** @var yii\web\View $this */
/** @var yii */

/** @var  $tasks_new */
/** @var  $filterForm */
/** @var  $categories */
/** @var  $pages */

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


$this->title = 'Новые задания, Task Force';

?>

<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>
    <?php foreach($tasks_new as $task): ?>
    <div class="task-card">
        <div class="header-task">
            <a  href="tasks/view/<?=$task->task_id ?>" class="link link--block link--big"><?=$task->title ?> </a>
            <p class="price price--task"><?=$task->price ?> ₽</p>
        </div>
        <p class="info-text"><span class="current-time"><?php echo Yii::$app->formatter->asRelativeTime($task->add_date); ?></span></p>
        <p class="task-text"><?=$task->description ?></p>
        <div class="footer-task">
            <p class="info-text town-text">Санкт-Петербург, Центральный район</p>
            <p class="info-text category-text"><?=$task->category->name ?></p>
            <a href="#" class="button button--black">Смотреть Задание</a>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="pagination-wrapper">
    <?= LinkPager::widget([
            'pagination' => $pages,
            'options' => ['class' => 'pagination-list',],
            'prevPageCssClass' => 'pagination-item mark',
            'nextPageCssClass' => 'pagination-item mark',
            'nextPageLabel' => '',
            'prevPageLabel' => '',
            'activePageCssClass' => 'pagination-item--active',
            'linkOptions' => ['class' => 'link link--page'],
            'linkContainerOptions' => ['class' => 'pagination-item'],
        ])?>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <?php $form = ActiveForm::begin([
                'id' => 'form',
                'method' => 'get',
                'options' => ['class' => 'form'],
                'fieldConfig' => [
                        'options' => ['tag' => false],
                    ],
            ]);
            ?>
            <h4 class="head-card">Категории</h4>
            <div class = 'form-group'>
            <?= $form->field($filterForm, 'category',
                ['template'=> "{input}\n",])
                ->checkboxList($categories,
                [
                    'unselect' => null,
                    'tag' => false,
                    'item' => function ($index, $label, $name, $checked, $value)
                    {

                        return
                            '<div class="checkbox-wrapper"><label class="control-label">'
                            . Html::checkbox($name, $checked, ['value' => $value]) . $label
                            . '</label></div>';
                    }
                ])
            ?>
            </div>
            <h4 class="head-card">Дополнительно</h4>
            <div class = 'form-group'>
                <?= $form->field($filterForm , 'additionally',
                    ['template'=> "{input}\n",])
                    ->checkboxList($filterForm->additional(),
                    [
                        'unselect' => null,
                        'tag' => false,
                        'item' => function ($index, $label, $name, $checked, $value)
                        {
                            return
                                '<div class="checkbox-wrapper"><label class="control-label">'
                                . Html::checkbox($name, $checked, ['value' => $value]) . $label
                                . '</label></div>';
                        }
                    ])
                ?>
            </div>
            <h4 class="head-card">Период</h4>
            <div class = 'form-group'>
                <?= $form->field($filterForm, 'period', ['template'=> "{input}\n"])->dropDownList($filterForm ->period()) ?>
            </div>
            <?= Html::input('submit',null, 'Искать',['class' => 'button button--blue']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

