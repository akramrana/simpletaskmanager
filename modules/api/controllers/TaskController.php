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
class TaskController extends Controller{
    
    public $data;
    public $message = "";
    public $customKeys = [];
    public $response_code = 200;
    
    public function init() {
        $headers = Yii::$app->response->headers;
        $headers->add("Cache-Control", "no-cache, no-store, must-revalidate");
        $headers->add("Pragma", "no-cache");
        $headers->add("Expires", 0);
    }
    
    /**
     *
     * @return array
     */
    private function response() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = $this->data;
        if (empty($response)) {
            $response = new \stdClass();
        }
        $data = [
            'success' => Yii::$app->response->isSuccessful,
            'status' => $this->response_code,
            'message' => $this->message,
            'data' => $response,
        ];
        if (!empty($this->customKeys)) {
            $data = array_merge($data, $this->customKeys);
        }
        return $data;
    }
    
    public function actionCreate()
    {
        $request = Yii::$app->request->bodyParams;
        return $this->response();
    }
}
