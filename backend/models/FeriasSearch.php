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
     
    public function criarDataProvider($dataProvider,$query){
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['diferencaData'] = [
        'asc' => ['diferencaData' => SORT_ASC],
        'desc' => ['diferencaData' => SORT_DESC],
        ];

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
    
    public function search($params,$ano){
        
        $query = Ferias::find()->select("j17_ferias.*, YEAR(dataSaida) as anoSaida")
        ->rightJoin("j17_professores as prof","prof.id = j17_ferias.idusuario")
        ->where("(YEAR (dataSaida)) = ".$ano)
        ->groupBy("j17_ferias.idusuario");
        
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider = $this->criarDataProvider($dataProvider,$query);
        
        return $dataProvider;
        
    }
     
     
    public function searchMinhasFerias($params, $idUser ,$ano)
    {

            $query = Ferias::find()->select("j17_ferias.*, DATEDIFF((dataRetorno),(dataSaida)) as diferencaData")->where("idusuario = '".$idUser."' 
            AND YEAR(dataSaida) = ".$ano);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider = $this->criarDataProvider($dataProvider,$query);

        return $dataProvider;
    }

}
