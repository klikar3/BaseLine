<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PerfMonData".
 *
 * @property string $id
 * @property string $Server
 * @property string $Counter
 * @property number $Value
 * @property string $CaptureDate
 */
class PerfMonData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PerfMonData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'Counter'], 'string'],
            [['Value'], 'number'],
            [['CaptureDate'], 'safe']
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
            'Counter' => Yii::t('app', 'Counter'),
            'Value' => Yii::t('app', 'Value'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
        ];
    }
}
