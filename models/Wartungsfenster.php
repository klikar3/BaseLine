<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Wartungsfenster".
 *
 * @property int $id
 * @property int $ServerID
 * @property string|null $CaptureDate
 * @property int|null $quarter
 * @property string|null $w_value
 *
 * @property ServerData $server
 */
class Wartungsfenster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Wartungsfenster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ServerID'], 'required'],
            [['ServerID', 'quarter'], 'integer'],
            [['CaptureDate'], 'safe'],
            [['w_value'], 'string', 'max' => 1],
            [['ServerID'], 'exist', 'skipOnError' => true, 'targetClass' => ServerData::class, 'targetAttribute' => ['ServerID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ServerID' => 'Server ID',
            'CaptureDate' => 'Capture Date',
            'quarter' => 'Quarter',
            'w_value' => 'W Value',
        ];
    }

    /**
     * Gets query for [[Server]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(ServerData::class, ['id' => 'ServerID']);
    }
}
