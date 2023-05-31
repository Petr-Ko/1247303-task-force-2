<?php

namespace app\controllers;

use app\models\User;
use TaskForce\extauth\AuthVk;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionIndex()
    {
        $vkAuthClient = new AuthVk();

        if (Yii::$app->request->get('code')) {

            $code = Yii::$app->request->get('code');
            $accessToken = $vkAuthClient->getVkAccessToken($code);
            $userEmail = $vkAuthClient->userEmail;

            if ($userEmail) {

                $findUSer = User::findOne(['email' => $userEmail]);

                if(isset($findUSer)) {

                    Yii::$app->user->login($findUSer);
                    return $this->goHome();
                }

                $userinfoVK = $vkAuthClient->getUserInfo($accessToken);

                foreach ($userinfoVK as $field) {
                    if (!isset($field)) {
                        exit('Из ВК не получено'. $field.' регистрация не завершена');
                    }
                }

                $user = new User();
                $user->first_name =  $userinfoVK['first_name'];
                $user->last_name = $userinfoVK['last_name'];
                $user->email = $userEmail;
                $user->is_executor = 0;
                $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->getSecurity()->generateRandomString());

                if($user->save()) {

                    return $this->goHome();
                }
            }

            if(isset($findUSer)) {

                Yii::$app->user->login($findUSer);
                return $this->goHome();
            }
        }
    }

}
