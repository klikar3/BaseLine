<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PerfCounterPerServer".
 *
 * @property string $id
 * @property string $Server
 * @property integer $counter_id
 * @property string $counter_name
 * @property string $instance
 * @property string $AvgValue
 * @property string $StdDevValue
 * @property string $WarnValue
 * @property string $AlertValue
 * @property integer $is_perfmon
 * @property string $direction
 * @property string $belongsto
 * @property string $status
 */
class PerfCounterPerServer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PerfCounterPerServer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'counter_name'], 'required'],
            [['Server', 'counter_name', 'instance', 'direction', 'belongsto', 'status'], 'string'],
            [['counter_id', 'is_perfmon'], 'integer'],
            [['AvgValue', 'StdDevValue', 'WarnValue', 'AlertValue'], 'number']
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
            'counter_id' => Yii::t('app', 'Counter ID'),
            'counter_name' => Yii::t('app', 'Counter Name'),
            'instance' => Yii::t('app', 'Instance'),
            'AvgValue' => Yii::t('app', 'Avg Value'),
            'StdDevValue' => Yii::t('app', 'Std Dev Value'),
            'WarnValue' => Yii::t('app', 'Warn Value'),
            'AlertValue' => Yii::t('app', 'Alert Value'),
            'is_perfmon' => Yii::t('app', 'Is Perfmon'),
            'direction' => Yii::t('app', 'Direction'),
            'belongsto' => Yii::t('app', 'Belongsto'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
