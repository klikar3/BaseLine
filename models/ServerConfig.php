<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ServerConfig".
 *
 * @property string $Server
 * @property string $Property
 * @property string $Value
 * @property string $CaptureDate
 */
class ServerConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ServerConfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'Property', 'Value'], 'string'],
            [['CaptureDate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Server' => Yii::t('app', 'Server'),
            'Property' => Yii::t('app', 'Property'),
            'Value' => Yii::t('app', 'Value'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
        ];
    }
}
