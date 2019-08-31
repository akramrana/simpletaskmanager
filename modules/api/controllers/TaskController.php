<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;

/**
 * Description of ApiController
 *
 * @author akram
 */
class TaskController extends Controller
{

    public $data;
    public $message = "";
    public $response_code = 201;

    public function init()
    {
        $headers = Yii::$app->response->headers;
        $headers->add("Cache-Control", "no-cache, no-store, must-revalidate");
        $headers->add("Pragma", "no-cache");
        $headers->add("Expires", 0);
    }

    /**
     *
     * @return array
     */
    private function response()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = $this->data;
        if (empty($response)) {
            $response = new \stdClass();
        }
        $data = [
            'status' => $this->response_code,
            'message' => $this->message,
            'data' => $response,
        ];
        return $data;
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->bodyParams;
        if (!empty($request)) {
            $user = \app\models\Users::find()
                    ->where(['id' => $request['user_id'], 'email' => $request['email']])
                    ->one();
            if (empty($user)) {
                $this->response_code = 404;
                $this->message = "User does not exist.";
                return $this->response();
            }
            if (!empty($request['parent_id'])) {
                $parent = \app\models\Tasks::findOne($request['parent_id']);
                if (empty($parent)) {
                    $this->response_code = 404;
                    $this->message = "Parent task does not exist.";
                    return $this->response();
                }
                $subtaskCount = \app\models\Tasks::find()
                        ->where(['parent_id' => $parent->id])
                        ->count();
                if ($subtaskCount == 5) {
                    $this->response_code = 500;
                    $this->message = "Subtask limit exceeded.Maximum 5 allowed";
                    return $this->response();
                }
            }
            $model = new \app\models\Tasks();
            $model->parent_id = isset($request['parent_id']) ? $request['parent_id'] : null;
            $model->user_id = $request['user_id'];
            $model->title = $request['title'];
            $model->points = $request['points'];
            $model->is_done = $request['is_done'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                //
                if ($model->parent_id != null && $model->is_done == 0) {
                    $parent->is_done = 0;
                    $parent->save();
                }
                if ($model->parent_id == null && $model->is_done == 1) {
                    \app\models\Tasks::updateAll(['is_done' => 1], ['parent_id' => $model->id]);
                }
                if ($model->parent_id != null) {
                    $subtaskPoint = \app\models\Tasks::find()
                            ->select('SUM(points) total_points')
                            ->where(['parent_id' => $parent->id])
                            ->asArray()
                            ->one();
                    $parent->points = $subtaskPoint['total_points'];
                    $parent->save(false);
                }
                //
                $result = [
                    'id' => $model->id,
                    'parent_id' => ($model->parent_id != null) ? $model->parent_id : "",
                    'user_id' => $model->user_id,
                    'title' => $model->title,
                    'points' => $model->points,
                    'is_done' => $model->is_done,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                ];
                $this->message = 'success';
                $this->data = $result;
            } else {
                $this->response_code = 400;
                $this->message = $model->errors;
            }
        } else {
            $this->response_code = 500;
            $this->message = 'There was an error processing the request';
        }
        return $this->response();
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request->bodyParams;
        if (!empty($request)) {
            $user = \app\models\Users::find()
                    ->where(['id' => $request['user_id'], 'email' => $request['email']])
                    ->one();
            if (empty($user)) {
                $this->response_code = 404;
                $this->message = "User does not exist.";
                return $this->response();
            }
            if (!empty($request['parent_id'])) {
                $parent = \app\models\Tasks::findOne($request['parent_id']);
                if (empty($parent)) {
                    $this->response_code = 404;
                    $this->message = "Parent task does not exist.";
                    return $this->response();
                }
                $subtaskCount = \app\models\Tasks::find()
                        ->where(['parent_id' => $parent->id])
                        ->count();
                if ($subtaskCount == 5) {
                    $this->response_code = 500;
                    $this->message = "Subtask limit exceeded.Maximum 5 allowed";
                    return $this->response();
                }
            }
            $model = \app\models\Tasks::findOne($id);
            if (!empty($model)) {
                $model->parent_id = isset($request['parent_id']) ? $request['parent_id'] : null;
                $model->user_id = $request['user_id'];
                $model->title = $request['title'];
                $model->points = $request['points'];
                $model->is_done = $request['is_done'];
                $model->updated_at = date('Y-m-d H:i:s');
                if ($model->save()) {

                    if ($model->parent_id == null) {
                        $allSubtaskPoint = \app\models\Tasks::find()
                                ->select('SUM(points) total_points')
                                ->where(['parent_id' => $model->id])
                                ->asArray()
                                ->one();
                        $points = $allSubtaskPoint['total_points'];
                        $model->points = $points;
                        $model->save(false);
                    }
                    //
                    if ($model->parent_id != null && $model->is_done == 0) {
                        $parent->is_done = 0;
                        $parent->save();
                    }
                    if ($model->parent_id == null && $model->is_done == 1) {
                        \app\models\Tasks::updateAll(['is_done' => 1], ['parent_id' => $model->id]);
                    }
                    if ($model->parent_id != null) {
                        $subtaskPoint = \app\models\Tasks::find()
                                ->select('SUM(points) total_points')
                                ->where(['parent_id' => $parent->id])
                                ->asArray()
                                ->one();
                        $parent->points = $subtaskPoint['total_points'];
                        $parent->save(false);
                    }
                    //
                    $result = [
                        'id' => $model->id,
                        'parent_id' => ($model->parent_id != null) ? $model->parent_id : "",
                        'user_id' => $model->user_id,
                        'title' => $model->title,
                        'points' => $model->points,
                        'is_done' => $model->is_done,
                        'created_at' => $model->created_at,
                        'updated_at' => $model->updated_at,
                    ];
                    $this->message = 'success';
                    $this->data = $result;
                } else {
                    $this->response_code = 400;
                    $this->message = $model->errors;
                }
            } else {
                $this->response_code = 404;
                $this->message = 'Requested task does not exist.';
            }
        } else {
            $this->response_code = 500;
            $this->message = 'There was an error processing the request';
        }
        return $this->response();
    }

}
