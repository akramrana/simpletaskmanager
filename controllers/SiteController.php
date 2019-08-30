<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site/login');
        }
        $users = \app\models\Users::find()
                ->select([
                    'users.*',
                    '(select count(id) from tasks where user_id = users.id and is_done = 1) as total_task_count',
                ])
                ->where(['is_deleted' => 0])
                ->andHaving(['>','total_task_count',0])
                ->asArray()
                ->all();
        $data = [];
        if (!empty($users)) {
            foreach ($users as $usr) {
                $parentTasks = \app\models\Tasks::find()
                        ->where(['user_id' => $usr['id'], 'is_done' => 1])
                        ->andWhere(['IS', 'parent_id', new \yii\db\Expression('NULL')])
                        ->asArray()
                        ->all();
                $tasks = [];
                if (!empty($parentTasks)) {
                    foreach ($parentTasks as $pt) {
                        $pt['sub_task'] = $this->getSubtasks($usr['id'],$pt['id']);
                        array_push($tasks, $pt);
                    }
                }
                $usr['task_point'] = \app\helpers\AppHelper::calculateUsertaskPoint($usr['id']);
                $usr['task_count'] = \app\helpers\AppHelper::calculateUsertaskCount($usr['id']);
                $usr['parent_task'] = $tasks;
                array_push($data, $usr);
            }
        }
        return $this->render('index', [
                    'users' => $data
        ]);
    }

    private function getSubtasks($uid,$id) {
        $models = \app\models\Tasks::find()
                ->where(['user_id' => $uid, 'is_done' => 1])
                ->andWhere(['=', 'parent_id', $id])
                ->asArray()
                ->all();
        $tasks = [];
        if (!empty($models)) {
            foreach ($models as $model) {
                $model['sub_task'] = $this->getSubtasks($uid,$model['id']);
                array_push($tasks, $model);
            }
        }
        return $tasks;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
