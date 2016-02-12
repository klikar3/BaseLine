<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PerfCounterPerServer;

/**
 * PerfCounterPerServerSearch represents the model behind the search form about `app\models\PerfCounterPerServer`.
 */
class PerfCounterPerServerSearch extends PerfCounterPerServer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'counter_id', 'is_perfmon'], 'integer'],
            [['Server', 'counter_name', 'instance', 'direction', 'belongsto', 'status'], 'safe'],
            [['AvgValue', 'StdDevValue', 'WarnValue', 'AlertValue'], 'number'],
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
        $query = PerfCounterPerServer::find();

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
            'counter_id' => $this->counter_id,
            'AvgValue' => $this->AvgValue,
            'StdDevValue' => $this->StdDevValue,
            'WarnValue' => $this->WarnValue,
            'AlertValue' => $this->AlertValue,
            'is_perfmon' => $this->is_perfmon,
        ]);

        $query->andFilterWhere(['like', 'Server', $this->Server])
            ->andFilterWhere(['like', 'counter_name', $this->counter_name])
            ->andFilterWhere(['like', 'instance', $this->instance])
            ->andFilterWhere(['like', 'direction', $this->direction])
            ->andFilterWhere(['like', 'belongsto', $this->belongsto])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
