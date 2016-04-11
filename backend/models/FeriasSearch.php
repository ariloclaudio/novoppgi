<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ferias;

/**
 * FeriasSearch represents the model behind the search form about `app\models\Ferias`.
 */
class FeriasSearch extends Ferias
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idusuario', 'tipo'], 'integer'],
            [['nomeusuario', 'emailusuario', 'dataSaida', 'dataRetorno', 'dataPedido'], 'safe'],
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
    public function searchMinhasFerias($params, $idUser)
    {


        $query = Ferias::find()->where("idusuario = '".$idUser."'");

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
            'idusuario' => $this->idusuario,
            'tipo' => $this->tipo,
            'dataSaida' => $this->dataSaida,
            'dataRetorno' => $this->dataRetorno,
            'dataPedido' => $this->dataPedido,
        ]);

        $query->andFilterWhere(['like', 'nomeusuario', $this->nomeusuario])
            ->andFilterWhere(['like', 'emailusuario', $this->emailusuario]);


        return $dataProvider;
    }
}
