<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "IoCounters".
 *
 * @property string $id
 * @property string $server
 * @property string $datenbank
 * @property string $filename
 * @property string $io_stall_read_ms
 * @property string $num_of_reads
 * @property string $io_stall_write_ms
 * @property string $num_of_writes
 * @property string $io_stalls
 * @property string $io
 * @property string $CaptureDate
 */
class IoCounters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'IoCounters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server', 'datenbank', 'filename', 'CaptureDate'], 'required'],
            [['server', 'datenbank', 'filename'], 'string'],
            [['io_stall_read_ms', 'num_of_reads', 'io_stall_write_ms', 'num_of_writes', 'io_stalls', 'io'], 'integer'],
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
            'server' => Yii::t('app', 'Server'),
            'datenbank' => Yii::t('app', 'Datenbank'),
            'filename' => Yii::t('app', 'Filename'),
            'io_stall_read_ms' => Yii::t('app', 'Io Stall Read Ms'),
            'num_of_reads' => Yii::t('app', 'Num Of Reads'),
            'io_stall_write_ms' => Yii::t('app', 'Io Stall Write Ms'),
            'num_of_writes' => Yii::t('app', 'Num Of Writes'),
            'io_stalls' => Yii::t('app', 'Io Stalls'),
            'io' => Yii::t('app', 'Io'),
            'CaptureDate' => Yii::t('app', 'Capture Date'),
        ];
    }
}
