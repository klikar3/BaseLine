<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PerfMonData;

/**
 * PerfMonDataSearch represents the model behind the search form about `app\models\PerfMonData`.
 */
class PerfMonDataSearch extends PerfMonData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['Server', 'Counter', 'CaptureDate'], 'safe'],
            [['Value'], 'number'],
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
        $query = PerfMonData::find();

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
            'Value' => $this->Value,
            'CaptureDate' => $this->CaptureDate,
        ]);

        $query->andFilterWhere(['like', 'Server', $this->Server])
            ->andFilterWhere(['like', 'Counter', $this->Counter]);

        return $dataProvider;
    }
}
