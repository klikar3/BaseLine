<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PerfmonDataAgg1H".
 *
 * @property string $Server
 * @property integer $Counter_id
 * @property string $instance
 * @property string $counter
 * @property string $TimeSlotStart
 * @property string $MinVal
 * @property string $AvgVal
 * @property string $MaxVal
 * @property string $Median
 * @property double $StdDev
 */
class PerfmonDataAgg1H extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PerfmonDataAgg1H';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'counter', 'TimeSlotStart'], 'required'],
            [['Server', 'instance', 'counter'], 'string'],
            [['Counter_id'], 'integer'],
            [['TimeSlotStart'], 'safe'],
            [['MinVal', 'AvgVal', 'MaxVal', 'Median', 'StdDev'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Server' => Yii::t('app', 'Server'),
            'Counter_id' => Yii::t('app', 'Counter ID'),
            'instance' => Yii::t('app', 'Instance'),
            'counter' => Yii::t('app', 'Counter'),
            'TimeSlotStart' => Yii::t('app', 'Time Slot Start'),
            'MinVal' => Yii::t('app', 'Min Val'),
            'AvgVal' => Yii::t('app', 'Avg Val'),
            'MaxVal' => Yii::t('app', 'Max Val'),
            'Median' => Yii::t('app', 'Median'),
            'StdDev' => Yii::t('app', 'Std Dev'),
        ];
    }
}
