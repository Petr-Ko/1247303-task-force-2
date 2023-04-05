<?php
/** @var yii\web\View $this */
/** @var yii */
/** @var $registrationForm */
/** @var $cities */

use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Task Force, Регистрация нового пользователя";

?>

<div class="center-block">
    <div class="registration-form regular-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form',
            'method' => 'post',
            'options' => ['class' => ''],
            'fieldConfig' => [
                'options' => ['class' => 'form-group'],
                'template' => "{label}\n{input}\n{error}\n",
            ],
        ]); ?>
        <h3 class="head-main head-task">Регистрация нового пользователя</h3>
            <?= $form->field($registrationForm, 'first_name') ?>
            <?= $form->field($registrationForm, 'last_name') ?>
        <div class="half-wrapper">
                <?= $form->field($registrationForm, 'email')->input('email') ?>
                <?= $form->field($registrationForm, 'city_id')->dropDownList($cities) ?>
        </div>
        <div class="half-wrapper">
                <?= $form->field($registrationForm, 'password')->input('password') ?>
        </div>
        <div class="half-wrapper">
                <?= $form->field($registrationForm, 'password_repeat')->input('password') ?>
        </div>
        <div class="half-wrapper">
                <?= $form->field($registrationForm, 'is_executor')->checkbox() ?>
        </div>
        <?= Html::input('submit',null, 'Создать аккаунт',['class' => 'button button--blue']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
