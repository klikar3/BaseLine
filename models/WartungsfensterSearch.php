<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Wartungsfenster;

/**
 * WartungsfensterSearch represents the model behind the search form of `app\models\Wartungsfenster`.
 */
class WartungsfensterSearch extends Wartungsfenster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ServerID', 'quarter'], 'integer'],
            [['CaptureDate', 'w_value'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Wartungsfenster::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ServerID' => $this->ServerID,
            'CaptureDate' => $this->CaptureDate,
            'quarter' => $this->quarter,
        ]);

        $query->andFilterWhere(['like', 'w_value', $this->w_value]);

        return $dataProvider;
    }
}
