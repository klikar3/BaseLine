<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ServerData;

/**
 * ServerDataSearch represents the model behind the search form about `app\models\ServerData`.
 */
class ServerDataSearch extends ServerData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['Server', 'usertyp', 'user', 'password', 'snmp_pw', 'typ', 'stat_event', 'stat_wait', 'stat_queries', 'stat_cpu', 
                'stat_mem', 'stat_disk', 'stat_sess', 'stat_net', 'User_Encrypted', 'Password_Encrypted', 'Description', 'lastEventlogSearch'], 'safe'],
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
        $query = ServerData::find();

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
           'paused' => $this->paused, 
		    'lastEventlogSearch' => $this->lastEventlogSearch, 
	        ]);

        $query->andFilterWhere(['like', 'Server', $this->Server])
            ->andFilterWhere(['like', 'usertyp', $this->usertyp])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'snmp_pw', $this->snmp_pw])
            ->andFilterWhere(['like', 'typ', $this->typ])
            ->andFilterWhere(['like', 'stat_wait', $this->stat_wait])
            ->andFilterWhere(['like', 'stat_queries', $this->stat_queries])
            ->andFilterWhere(['like', 'stat_cpu', $this->stat_cpu])
            ->andFilterWhere(['like', 'stat_mem', $this->stat_mem])
            ->andFilterWhere(['like', 'stat_disk', $this->stat_disk])
            ->andFilterWhere(['like', 'stat_sess', $this->stat_sess])
           ->andFilterWhere(['like', 'stat_sess', $this->stat_sess])
           ->andFilterWhere(['like', 'stat_net', $this->stat_net])
           ->andFilterWhere(['like', 'User_Encrypted', $this->User_Encrypted])
           ->andFilterWhere(['like', 'Password_Encrypted', $this->Password_Encrypted])
           ->andFilterWhere(['like', 'Description', $this->Description]);
	
        return $dataProvider;
    }
}
