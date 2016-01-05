<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PerfCounterDefault".
 *
 * @property integer $id
 * @property string $counter_name
 * @property string $MinValue
 * @property string $MaxValue
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
            [['counter_name'], 'string'],
            [['MinValue', 'MaxValue'], 'number'],
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
            'MinValue' => Yii::t('app', 'Min Value'),
            'MaxValue' => Yii::t('app', 'Max Value'),
        ];
    }
}
