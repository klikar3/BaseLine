<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Waits".
 *
 * @property integer $ServerId
 * @property integer $WaitTypeId
 * @property string $Wait_S
 * @property string $Resource_S
 * @property string $Signal_S
 * @property string $WaitCount
 * @property string $Percentage
 * @property string $AvgWait_S
 * @property string $AvgRes_S
 * @property string $AvgSig_S
 * @property string $CaptureBegin
 * @property string $CaptureEnd
 */
class Waits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Waits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ServerId', 'WaitTypeId', 'CaptureBegin', 'CaptureEnd'], 'required'],
            [['ServerId', 'WaitTypeId', 'WaitCount'], 'integer'],
            [['Wait_S', 'Resource_S', 'Signal_S', 'Percentage', 'AvgWait_S', 'AvgRes_S', 'AvgSig_S'], 'number'],
            [['CaptureBegin', 'CaptureEnd'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ServerId' => 'Server ID',
            'WaitTypeId' => 'Wait Type ID',
            'Wait_S' => 'Wait  S',
            'Resource_S' => 'Resource  S',
            'Signal_S' => 'Signal  S',
            'WaitCount' => 'Wait Count',
            'Percentage' => 'Percentage',
            'AvgWait_S' => 'Avg Wait  S',
            'AvgRes_S' => 'Avg Res  S',
            'AvgSig_S' => 'Avg Sig  S',
            'CaptureBegin' => 'Capture Begin',
            'CaptureEnd' => 'Capture End',
        ];
    }
}
