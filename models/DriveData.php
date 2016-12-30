<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DriveData".
 *
 * @property string $id
 * @property integer $ServerID
 * @property string $CaptureDate
 * @property string $wmiDeviceID
 * @property string $DriveLetter
 * @property integer $DriveType
 * @property string $FreeSpace
 * @property string $Capacity
 * @property string $PercentFree
 */
class DriveData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DriveData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ServerID', 'DriveType'], 'integer'],
            [['CaptureDate'], 'safe'],
            [['wmiDeviceID', 'DriveLetter'], 'string'],
            [['FreeSpace', 'Capacity', 'PercentFree'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ServerID' => 'Server ID',
            'CaptureDate' => 'Capture Date',
            'wmiDeviceID' => 'Wmi Device ID',
            'DriveLetter' => 'Drive Letter',
            'DriveType' => 'Drive Type',
            'FreeSpace' => 'Free Space',
            'Capacity' => 'Capacity',
            'PercentFree' => 'Percent Free',
        ];
    }
}
