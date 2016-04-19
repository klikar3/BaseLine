<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "NetMonData".
 *
 * @property string $id
 * @property string $Server
 * @property integer $counter_id
 * @property string $CaptureDate
 * @property string $wmiNetAdapterName
 * @property string $BytesTotalPersec
 * @property string $BytesReceivedPersec
 * @property string $BytesSentPersec
 * @property string $CurrentBandwidth
 * @property string $status
 * @property string $AvgBytesTotalPersec
 * @property string $AvgBytesReceivedPersec
 * @property string $AvgBytesSentPersec
 * @property string $StdDevValue
 */
class NetMonData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'NetMonData';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'wmiNetAdapterName', 'status'], 'string'],
            [['counter_id', 'BytesTotalPersec', 'BytesReceivedPersec', 'BytesSentPersec', 'CurrentBandwidth'], 'integer'],
            [['CaptureDate'], 'safe'],
            [['AvgBytesTotalPersec', 'AvgBytesReceivedPersec', 'AvgBytesSentPersec', 'StdDevValue'], 'number'],
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
            'counter_id' => Yii::t('app', 'Counter ID'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
            'wmiNetAdapterName' => Yii::t('app', 'Wmi Net Adapter Name'),
            'BytesTotalPersec' => Yii::t('app', 'Bytes Total Persec'),
            'BytesReceivedPersec' => Yii::t('app', 'Bytes Received Persec'),
            'BytesSentPersec' => Yii::t('app', 'Bytes Sent Persec'),
            'CurrentBandwidth' => Yii::t('app', 'Current Bandwidth'),
            'status' => Yii::t('app', 'Status'),
            'AvgBytesTotalPersec' => Yii::t('app', 'Avg Bytes Total Persec'),
            'AvgBytesReceivedPersec' => Yii::t('app', 'Avg Bytes Received Persec'),
            'AvgBytesSentPersec' => Yii::t('app', 'Avg Bytes Sent Persec'),
            'StdDevValue' => Yii::t('app', 'Std Dev Value'),
        ];
    }
}
