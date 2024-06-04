<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ConfigData".
 *
 * @property string $id
 * @property string $Server
 * @property integer $ConfigurationID
 * @property string $Name
 * @property string $Value
 * @property string $ValueInUse
 * @property string $CaptureDate
 */
class ConfigData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ConfigData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'ConfigurationID', 'Name'], 'required'],
            [['Server', 'Name', 'Value', 'ValueInUse'], 'string'],
            [['ConfigurationID'], 'integer'],
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
            'ConfigurationID' => Yii::t('app', 'Configuration ID'),
            'Name' => Yii::t('app', 'Name'),
            'Value' => Yii::t('app', 'Value'),
            'ValueInUse' => Yii::t('app', 'Value In Use'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
        ];
    }
}
