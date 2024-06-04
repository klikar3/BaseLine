<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PhysDriveData".
 *
 * @property string $id
 * @property string $ServerID
 * @property string $CaptureDate
 * @property string $wmiDeviceID
 * @property string $diskname
 * @property string $caption
 * @property string $PNPDeviceID
 * @property int $scsibus
 * @property int $scsilogicalunit
 *
 * @property ServerData $server
 */
class PhysDriveData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PhysDriveData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ServerID', 'scsibus', 'scsilogicalunit'], 'integer'],
            [['CaptureDate'], 'safe'],
            [['wmiDeviceID', 'diskname', 'caption', 'PNPDeviceID'], 'string'],
            [['ServerID'], 'exist', 'skipOnError' => true, 'targetClass' => ServerData::className(), 'targetAttribute' => ['ServerID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ServerID' => Yii::t('app', 'Server ID'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
            'wmiDeviceID' => Yii::t('app', 'Wmi Device ID'),
            'diskname' => Yii::t('app', 'Diskname'),
            'caption' => Yii::t('app', 'Caption'),
            'PNPDeviceID' => Yii::t('app', 'Pnpdevice ID'),
            'scsibus' => Yii::t('app', 'Scsibus'),
            'scsilogicalunit' => Yii::t('app', 'Scsilogicalunit'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(ServerData::className(), ['id' => 'ServerID']);
    }
}
