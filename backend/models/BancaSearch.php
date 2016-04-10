<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banca;

/**
 * BancaSearch represents the model behind the search form about `app\models\Banca`.
 */
class BancaSearch extends Banca
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idAluno', 'idMembro'], 'integer'],
            [['nomeMembro', 'instituicaoMembro', 'funcao', 'tipoDefesa'], 'safe'],
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
        $query = Banca::find();

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
            'idAluno' => $this->idAluno,
            'idMembro' => $this->idMembro,
        ]);

        $query->andFilterWhere(['like', 'nomeMembro', $this->nomeMembro])
            ->andFilterWhere(['like', 'instituicaoMembro', $this->instituicaoMembro])
            ->andFilterWhere(['like', 'funcao', $this->funcao])
            ->andFilterWhere(['like', 'tipoDefesa', $this->tipoDefesa]);

        return $dataProvider;
    }
}
