<?php

namespace app\controllers;

use app\models\Categories;
use app\models\EditUserForm;
use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class UserController extends SecuredController
{
    public function actionView($id)
    {
        $user = User::findOne($id);

        $reviews = $user->reviews;



        return $this->render('view', ['user' => $user, 'reviews' => $reviews]);
    }

    public function actionEdit()
    {
        $currentUserId = Yii::$app->user->getId();

        $currentUser = User::findOne($currentUserId);

        $categories = Categories::find()->select(['name'])->indexBy('category_id')->column();

        $editUserForm = new EditUserForm();

        if ($editUserForm->load(Yii::$app->request->post()) && $editUserForm->validate()) {

            if (UploadedFile::getInstance($editUserForm, 'avatar')) {

                $editUserForm->avatar = UploadedFile::getInstance($editUserForm, 'avatar');

                $editUserForm->newAvatar($editUserForm->uploadAvatar($editUserForm->avatar), $currentUser);
            }


            if ($editUserForm->saveChanges($currentUser)) {

                return $this->redirect(Url::to('/user/view/' . $currentUser->user_id));
            }
        }

        return $this->render(
            'edit',
            [
                'currentUser' => $currentUser,
                'categories' => $categories,
                'editUserForm' => $editUserForm,
            ]
        );

    }
}
