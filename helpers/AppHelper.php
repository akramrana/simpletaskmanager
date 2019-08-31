<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppHelper
 *
 * @author akram
 */

namespace app\helpers;

use Yii;

class AppHelper
{

    //put your code here
    static function generateRecursiveTaskList($uid, $tasks)
    {
        $htm = '';
        if (!empty($tasks)) {
            $htm = '<ul>';
            foreach ($tasks as $t) {
                $hasSubtask = self::checkSubtask($uid, $t['id']);
                $points = self::calculateTaskPoint($uid, $t['id']);
                $listStyle = '';
                if ($hasSubtask) {
                    $listStyle = 'list-style-type:none;';
                }
                $htm .= '<li>' . $t['title'] . '(' . $points . ')</li>';
                if (!empty($t['sub_task'])) {
                    $htm .= '<li style="' . $listStyle . '">' . self::generateRecursiveTaskList($uid, $t['sub_task']) . '</li>';
                }
            }
            $htm .= '</ul>';
        }
        return $htm;
    }

    static function calculateSubtaskPoint($uid, $id)
    {
        $model = \app\models\Tasks::find()
                ->select([
                    'SUM(points) as total_points'
                ])
                ->where(['parent_id' => $id, 'user_id' => $uid])
                ->asArray()
                ->one();
        return isset($model['total_points']) ? $model['total_points'] : 0;
    }

    static function checkSubtask($uid, $id)
    {
        $query = \app\models\Tasks::find()
                ->where(['parent_id' => $id, 'user_id' => $uid]);
        //echo $query->createCommand()->rawSql;
        $model = $query->asArray()->count();
        if ($model > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function calculateUsertaskPoint($uid)
    {
        $models = \app\models\Tasks::find()
                ->where(['user_id' => $uid])
                ->asArray()
                ->all();
        $points = 0;
        if (!empty($models)) {
            foreach ($models as $row) {
                $hasSubtask = self::checkSubtask($uid, $row['id']);
                if ($hasSubtask == false) {
                    $points += $row['points'];
                }
            }
        }
        return $points;
    }

    static function calculateTaskPoint($uid, $id)
    {
        $model = \app\models\Tasks::find()
                ->where(['user_id' => $uid, 'id' => $id])
                ->asArray()
                ->one();
        $points = 0;
        if (!empty($model)) {
            $hasSubtask = self::checkSubtask($uid, $model['id']);
            if ($hasSubtask == false) {
                $points += $model['points'];
            } else {
                $points += self::getUserSubtaskPoint($uid, $model['id']);
            }
        }
        return $points;
    }

    static function getUserSubtaskPoint($uid, $id)
    {
        $models = \app\models\Tasks::find()
                ->where(['user_id' => $uid, 'parent_id' => $id])
                ->asArray()
                ->all();
        $points = 0;
        if (!empty($models)) {
            foreach ($models as $row) {
                $hasSubtask = self::checkSubtask($uid, $row['id']);
                if ($hasSubtask == false) {
                    $points += $row['points'];
                } else {
                    $points += self::getUserSubtaskPoint($uid, $row['id']);
                }
            }
        }
        return $points;
    }

    static function calculateUsertaskCount($uid)
    {
        $models = \app\models\Tasks::find()
                ->where(['user_id' => $uid])
                ->asArray()
                ->all();
        $count = 0;
        if (!empty($models)) {
            foreach ($models as $row) {
                $hasSubtask = self::checkSubtask($uid, $row['id']);
                if ($hasSubtask == false) {
                    $count += 1;
                }
            }
        }
        return $count;
    }

}
