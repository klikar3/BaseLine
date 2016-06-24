<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PerfCounterDefault;

/**
 * PerfCounterDefaultSearch represents the model behind the search form about `app\models\PerfCounterDefault`.
 */
class PerfCounterDefaultSearch extends PerfCounterDefault
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_perfmon'], 'integer'],
            [['counter_name', 'direction', 'belongsto', 'Description'], 'safe'],
            [['AvgValue', 'StdDefValue', 'WarnValue', 'AlertValue'], 'number'],
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
        $query = PerfCounterDefault::find();

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
            'AvgValue' => $this->AvgValue,
            'StdDefValue' => $this->StdDefValue,
            'WarnValue' => $this->WarnValue,
            'AlertValue' => $this->AlertValue,
            'is_perfmon' => $this->is_perfmon,
        ]);

        $query->andFilterWhere(['like', 'counter_name', $this->counter_name])
            ->andFilterWhere(['like', 'direction', $this->direction])
            ->andFilterWhere(['like', 'belongsto', $this->belongsto]);

        return $dataProvider;
    }
}
