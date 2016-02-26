<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PerfCounterDefault".
 *
 * @property integer $id
 * @property string $counter_name
 * @property string $AvgValue
 * @property string $StdDefValue
 * @property string $WarnValue
 * @property string $AlertValue
 * @property integer $is_perfmon
 * @property string $direction
 * @property string $belongsto
 */
class PerfCounterDefault extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PerfCounterDefault';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['counter_name'], 'required'],
            [['counter_name', 'direction', 'belongsto'], 'string'],
            [['AvgValue', 'StdDefValue', 'WarnValue', 'AlertValue'], 'number'],
            [['is_perfmon'], 'integer'],
            [['counter_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'counter_name' => Yii::t('app', 'Counter Name'),
            'AvgValue' => Yii::t('app', 'Avg Value'),
            'StdDefValue' => Yii::t('app', 'Std Def Value'),
            'WarnValue' => Yii::t('app', 'Warn Value'),
            'AlertValue' => Yii::t('app', 'Alert Value'),
            'is_perfmon' => Yii::t('app', 'Is Perfmon'),
            'direction' => Yii::t('app', 'Direction'),
            'belongsto' => Yii::t('app', 'Belongsto'),
        ];
    }
}
