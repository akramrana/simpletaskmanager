<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property int $admin_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_active
 * @property int $is_deleted
 */
class Admins extends \yii\db\ActiveRecord
{
    public $password_hash,$confirm_password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_active', 'is_deleted'], 'integer'],
            [['name', 'email'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 32],
            ['email', 'email'],
            ['email', 'unique'],
            [['password_hash','confirm_password'], 'required', 'on' => 'create'],
            [['password_hash'],'string','min'=>6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password_hash','message' => Yii::t('yii', 'Confirm Password must be equal to "Password"')],
            ['phone', 'match', 'pattern' => '/^[0-9-+]+$/', 'message' => Yii::t('yii', 'Your phone can only contain numeric characters with +/-')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'password_hash' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm Password'),
        ];
    }
}
