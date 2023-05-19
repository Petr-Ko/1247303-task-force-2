<?php
/** @var yii\web\View $this */
/** @var yii */


/** @var  $currentUser */
/** @var  $categories */
/** @var  $editUserForm */


use yii\widgets\ActiveForm;
use yii\helpers\Html;


$this->title = 'Task Force, Настройки пользователя: ' . $currentUser->first_name .' '. $currentUser->last_name;

?>

<div class="left-menu left-menu--edit">
    <h3 class="head-main head-task">Настройки</h3>
    <ul class="side-menu-list">
        <li class="side-menu-item side-menu-item--active">
            <a class="link link--nav">Мой профиль</a>
        </li>
        <li class="side-menu-item">
            <a href="#" class="link link--nav">Безопасность</a>
        </li>
    </ul>
</div>
<div class="my-profile-form">
<?php $form = ActiveForm::begin(
    [
        'id' => 'form-edit-user',
        'method' => 'post',
        'options' => ['class' => 'form-group'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}\n",
        ],
    ]
);?>
    <h3 class="head-main head-regular">Мой профиль</h3>
    <div class="photo-editing">
        <div>
            <p class="form-label">Аватар</p>
            <img class="avatar-preview" src="/img/man-glasses.png" width="83" height="83">
            <?= $form->field($editUserForm, 'avatar')->input('file') ?>
        </div>
    </div>
    <?= $form->field($editUserForm, 'firstName')->input('text', [ 'value' => "$currentUser->first_name"]) ?>
    <?= $form->field($editUserForm, 'lastName')->input('text', [ 'value' => "$currentUser->last_name"]) ?>
    <div class="half-wrapper">
        <?= $form->field($editUserForm, 'email')->input('email', [ 'value' => "$currentUser->email"]) ?>
        <?= $form->field($editUserForm, 'birthday')->input('date', [ 'value' => "$currentUser->birthday"]) ?>
    </div>
    <div class="half-wrapper">
        <?= $form->field($editUserForm, 'phoneNumber')->input('number',[ 'value' => "$currentUser->phone"]) ?>
        <?= $form->field($editUserForm, 'telegram')->input('text', [ 'value' => "$currentUser->telegram"]) ?>
    </div>
    <?= $form->field($editUserForm, 'information')->textarea([ 'value' => "$currentUser->information"]) ?>
    <?= $form->field($editUserForm, 'categories', ['template'=> "{input}\n",])->checkboxList($categories,
            [
                'unselect' => null,
                'class'=> 'checkbox-profile',
                'item' => function ($index, $label, $name, $checked, $value)
                {

                    return
                        "<label class='control-label'>"
                        . Html::checkbox($name, $checked, ['value' => $value]) . $label
                        . "</label>";
                }
            ]) ?>
    <?= Html::input('submit',null, 'Сохранить',['class' => 'button button--blue']) ?>
  <?php ActiveForm::end(); ?>
</div>
