<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Afastamentos;

/**
 * AfastamentosSearch represents the model behind the search form about `app\models\Afastamentos`.
 */
class AfastamentosSearch extends Afastamentos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idusuario', 'tipo'], 'integer'],
            [['datasaida', 'dataretorno', 'dataenvio', 'nomeusuario', 'local', 'justificativa', 'reposicao'], 'safe'],
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
    public function search()
    {
        $idUsuario = Yii::$app->user->identity->id;
		
        if(Yii::$app->user->identity->checarAcesso('secretaria')){
			$query = Afastamentos::find()->select("id, dataenvio, datasaida, dataretorno, idusuario, nomeusuario, tipo, local, justificativa");
					}
		else if (Yii::$app->user->identity->checarAcesso('professor')){
			$query = Afastamentos::find()->select("id, dataenvio, datasaida, dataretorno, idusuario, nomeusuario, tipo, local, justificativa")
			->where('idusuario = '.$idUsuario);
		}
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'datasaida' => $this->datasaida,
            'dataretorno' => $this->dataretorno,
            'dataenvio' => $this->dataenvio,
            'tipo' => $this->tipo,
            'local' => $this->local,

        ]);

         return $dataProvider;
    }

}
