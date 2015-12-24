<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ConfigData;

/**
 * ConfigDataSearch represents the model behind the search form about `app\models\ConfigData`.
 */
class ConfigDataSearch extends ConfigData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ConfigurationID'], 'integer'],
            [['Server', 'Name', 'Value', 'ValueInUse', 'CaptureDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ConfigData::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ConfigurationID' => $this->ConfigurationID,
            'CaptureDate' => $this->CaptureDate,
        ]);

        $query->andFilterWhere(['like', 'Server', $this->Server])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Value', $this->Value])
            ->andFilterWhere(['like', 'ValueInUse', $this->ValueInUse]);

        return $dataProvider;
    }
}
