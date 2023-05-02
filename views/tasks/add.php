<?php
/** @var yii\web\View $this */
/** @var yii */

/** @var  $addForm */
/** @var  $categories */

use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;


$this->title = "Task Force, Создание задания";
?>

<div class="add-task-form regular-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'method' => 'post',
        'options' => ['class' => 'form-group'],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'template' => "{label}\n{input}\n{error}\n",
        ],
    ]); ?>
    <h3 class="head-main head-main">Публикация нового задания</h3>
    <?= $form->field($addForm,'title')->textInput() ?>
    <?= $form->field($addForm,'description')->textarea() ?>
    <?= $form->field($addForm, 'category')->dropDownList($categories) ?>
    <?= $form->field($addForm,'location')->textInput(['class' => 'location-icon']) ?>
    <?= $form->field($addForm,'price')->input('number',['class' => 'budget-icon']) ?>
    <?= $form->field($addForm,'end_date')->input('date') ?>
    <?= $form->field($addForm,'files')->fileInput(['multiple'=>true]) ?>
    <?= Html::input('submit',null, 'Опубликовать',['class' => 'button button--blue']) ?>
    <?php ActiveForm::end(); ?>
</div>
