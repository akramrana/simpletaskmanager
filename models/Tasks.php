<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $user_id
 * @property string $title
 * @property int $points
 * @property int $is_done
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 */
class Tasks extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['parent_id', 'user_id', 'points', 'is_done'], 'integer'],
            [['user_id', 'title', 'points', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['points'], 'number', 'min' => 1, 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent',
            'user_id' => 'User',
            'title' => 'Title',
            'points' => 'Points',
            'is_done' => 'Done?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getParentTitle($parent_id)
    {
        $model = Tasks::findOne($parent_id);
        return !empty($model)?$model->title:"";
    }
}
