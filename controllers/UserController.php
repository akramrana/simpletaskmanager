<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex() {
        //check api for new users
        $this->reloadUsers();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->save();

        Yii::$app->session->setFlash('success', 'User successfully deleted');
        return $this->redirect(['index']);
    }

    /**
     * Load users list from https://gitlab.iterato.lt/snippets/3/raw
     * initially this will load all users from api
     * after 1st request, we will check for new users after 10min of previous request
     * if some users deleted from api, this method will remove those users from db as well
     * if any user exist in db, this method will update the user data instead create
     */
    private function reloadUsers() {
        if (!empty(Yii::$app->session['_request_date_time'])) {
            $requestDate = new \DateTime(Yii::$app->session['_request_date_time'], new \DateTimeZone(date_default_timezone_get()));
            $requestDateTime = new \DateTime($requestDate->format('Y-m-d H:i:s'));
            //
            $currentTime = new \DateTime(date("Y-m-d H:i:s"), new \DateTimeZone(date_default_timezone_get()));
            $timeFromCreate = $requestDateTime->diff(new \DateTime($currentTime->format('Y-m-d H:i:s')));
            $minutes = $timeFromCreate->days * 24 * 60;
            $minutes += $timeFromCreate->h * 60;
            $minutes += $timeFromCreate->i;
            if ($minutes > 10) {
                $sendCurlRequest = true;
            } else {
                $sendCurlRequest = false;
            }
        } else {
            $sendCurlRequest = true;
        }
        if ($sendCurlRequest) {
            //assign request time to session to use in reloadUsers method
            Yii::$app->session->set('_request_date_time', date('Y-m-d H:i:s'));
            $ch = curl_init();
            $url = "https://gitlab.iterato.lt/snippets/3/raw";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            //curl_setopt($ch,CURLOPT_URL, $url);
            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
            $json = json_decode($result, true);
            if (!empty($json)) {
                $userIds = [];
                foreach ($json['data'] as $usr) {
                    $userIds[] = $usr['id'];
                    $user = Users::find()
                            ->where(['email' => $usr['email']])
                            ->one();
                    if (empty($user)) {
                        $user = new Users();
                        $user->id = $usr['id'];
                        $user->created_at = date('Y-m-d H:i:s', strtotime($usr['created_at']));
                    }
                    $user->first_name = $usr['first_name'];
                    $user->last_name = $usr['last_name'];
                    $user->email = $usr['email'];
                    $user->updated_at = date('Y-m-d H:i:s', strtotime($usr['updated_at']));
                    $user->save();
                }
                $allDbUsers = Users::find()
                        ->where(['is_deleted' => 0])
                        ->all();
                if (!empty($allDbUsers)) {
                    foreach ($allDbUsers as $user) {
                        if (!in_array($user->id, $userIds)) {
                            $user->is_deleted = 1;
                            $user->save(false);
                        }
                    }
                }
            }
        }
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
