<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Win32_Event_Log".
 *
 * @property string $id
 * @property string $ServerId
 * @property string $Category
 * @property string $CategoryString
 * @property string $ComputerName
 * @property string $EventCode
 * @property string $EventIdentifier
 * @property string $EventType
 * @property string $Logfile
 * @property string $Message
 * @property string $RecordNumber
 * @property string $SourceName
 * @property string $TimeGenerated
 * @property string $TimeWritten
 * @property string $Type
 * @property string $user
 *
 * @property ServerData $server
 */
class Win32EventLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Win32_Event_Log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ServerId', 'Category', 'EventCode', 'EventIdentifier', 'EventType', 'RecordNumber'], 'integer'],
            [['CategoryString', 'ComputerName', 'Logfile', 'Message', 'SourceName', 'TimeGenerated', 'TimeWritten', 'Type', 'user'], 'string'],
            [['ServerId'], 'exist', 'skipOnError' => true, 'targetClass' => ServerData::className(), 'targetAttribute' => ['ServerId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ServerId' => Yii::t('app', 'Server ID'),
            'Category' => Yii::t('app', 'Category'),
            'CategoryString' => Yii::t('app', 'Category String'),
            'ComputerName' => Yii::t('app', 'Computer Name'),
            'EventCode' => Yii::t('app', 'Event Code'),
            'EventIdentifier' => Yii::t('app', 'Event Identifier'),
            'EventType' => Yii::t('app', 'Event Type'),
            'Logfile' => Yii::t('app', 'Logfile'),
            'Message' => Yii::t('app', 'Message'),
            'RecordNumber' => Yii::t('app', 'Record Number'),
            'SourceName' => Yii::t('app', 'Source Name'),
            'TimeGenerated' => Yii::t('app', 'Time Generated'),
            'TimeWritten' => Yii::t('app', 'Time Written'),
            'Type' => Yii::t('app', 'Type'),
            'user' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(ServerData::className(), ['id' => 'ServerId']);
    }
}
