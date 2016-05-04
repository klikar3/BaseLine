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
 * @property string $stat_wait
 * @property string $stat_queries
 * @property string $stat_cpu
 * @property string $stat_mem
 * @property string $stat_disk
 * @property string $stat_sess
 * @property string $stat_net
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
            [['Server', 'usertyp', 'user', 'password', 'snmp_pw', 'typ', 'stat_wait', 'stat_queries', 'stat_cpu', 'stat_mem', 'stat_disk', 'stat_sess'], 'string']
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
            'stat_wait' => Yii::t('app', 'Wait'),
            'stat_queries' => Yii::t('app', 'Queries'),
            'stat_cpu' => Yii::t('app', 'Cpu'),
            'stat_mem' => Yii::t('app', 'Mem'),
            'stat_disk' => Yii::t('app', 'Disk'),
            'stat_sess' => Yii::t('app', 'Sess'),
            'stat_net' => Yii::t('app', 'Net'),
        ];
    }
}
