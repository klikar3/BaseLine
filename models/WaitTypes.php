<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "WaitTypes".
 *
 * @property string $id
 * @property string $WaitType
 */
class WaitTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'WaitTypes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WaitType'], 'required'],
            [['WaitType'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'WaitType' => 'Wait Type',
        ];
    }
}
