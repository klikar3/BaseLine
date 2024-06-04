<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "NetmonDataAgg1H".
 *
 * @property string $Server
 * @property integer $Counter_id
 * @property string $wmiNetAdapterName
 * @property string $TimeSlotStart
 * @property string $BytesTotalPersec
 * @property string $BytesReceivedPersec
 * @property string $BytesSentPersec
 * @property string $CurrentBandwidth
 * @property string $BTMinVal
 * @property string $BTAvgVal
 * @property string $BTMaxVal
 * @property string $BTMedian
 * @property double $BTStdDev
 * @property string $BRMinVal
 * @property string $BRAvgVal
 * @property string $BRMaxVal
 * @property string $BRMedian
 * @property double $BRStdDev
 * @property string $BSMinVal
 * @property string $BSAvgVal
 * @property string $BSMaxVal
 * @property string $BSMedian
 * @property double $BSStdDev
 */
class NetmonDataAgg1H extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'NetmonDataAgg1H';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'wmiNetAdapterName', 'TimeSlotStart'], 'required'],
            [['Server', 'wmiNetAdapterName'], 'string'],
            [['Counter_id', 'BytesTotalPersec', 'BytesReceivedPersec', 'BytesSentPersec', 'CurrentBandwidth'], 'integer'],
            [['TimeSlotStart'], 'safe'],
            [['BTMinVal', 'BTAvgVal', 'BTMaxVal', 'BTMedian', 'BTStdDev', 'BRMinVal', 'BRAvgVal', 'BRMaxVal', 'BRMedian', 'BRStdDev', 'BSMinVal', 'BSAvgVal', 'BSMaxVal', 'BSMedian', 'BSStdDev'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Server' => 'Server',
            'Counter_id' => 'Counter ID',
            'wmiNetAdapterName' => 'Wmi Net Adapter Name',
            'TimeSlotStart' => 'Time Slot Start',
            'BytesTotalPersec' => 'Bytes Total Persec',
            'BytesReceivedPersec' => 'Bytes Received Persec',
            'BytesSentPersec' => 'Bytes Sent Persec',
            'CurrentBandwidth' => 'Current Bandwidth',
            'BTMinVal' => 'Btmin Val',
            'BTAvgVal' => 'Btavg Val',
            'BTMaxVal' => 'Btmax Val',
            'BTMedian' => 'Btmedian',
            'BTStdDev' => 'Btstd Dev',
            'BRMinVal' => 'Brmin Val',
            'BRAvgVal' => 'Bravg Val',
            'BRMaxVal' => 'Brmax Val',
            'BRMedian' => 'Brmedian',
            'BRStdDev' => 'Brstd Dev',
            'BSMinVal' => 'Bsmin Val',
            'BSAvgVal' => 'Bsavg Val',
            'BSMaxVal' => 'Bsmax Val',
            'BSMedian' => 'Bsmedian',
            'BSStdDev' => 'Bsstd Dev',
        ];
    }
}
