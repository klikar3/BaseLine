<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DbData".
 *
 * @property string $id
 * @property string $Server
 * @property string $db
 * @property string $Description
 * @property string $LogicalFileName
 * @property string $PhysicalFileName
 * @property integer $sizeMB
 * @property string $CaptureDate
 */
class DbData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DbData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'db', 'Description', 'LogicalFileName', 'PhysicalFileName'], 'string'],
            [['sizeMB'], 'integer'],
            [['CaptureDate'], 'safe'],
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
            'db' => Yii::t('app', 'Db'),
            'Description' => Yii::t('app', 'Description'),
            'LogicalFileName' => Yii::t('app', 'Logical File Name'),
            'PhysicalFileName' => Yii::t('app', 'Physical File Name'),
            'sizeMB' => Yii::t('app', 'Size Mb'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
        ];
    }
}
