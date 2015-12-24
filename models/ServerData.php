<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ServerData".
 *
 * @property string $id
 * @property string $Server
 * @property string $usertyp
 * @property string $user
 * @property string $password
 * @property string $snmp_pw
 * @property string $typ
 */
class ServerData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ServerData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'usertyp', 'typ'], 'required'],
            [['Server', 'usertyp', 'user', 'password', 'snmp_pw', 'typ'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Server' => Yii::t('app', 'Server'),
            'usertyp' => Yii::t('app', 'Usertyp'),
            'user' => Yii::t('app', 'User'),
            'password' => Yii::t('app', 'Password'),
            'snmp_pw' => Yii::t('app', 'Snmp Pw'),
            'typ' => Yii::t('app', 'Typ'),
        ];
    }
}
