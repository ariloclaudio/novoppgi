<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Edital;
use app\models\Candidato;


/**
 * SearchEdital represents the model behind the search form about `app\models\Edital`.
 */
class SearchEdital extends Edital
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero'], 'integer'],
            [['cartarecomendacao', 'datainicio', 'datafim', 'documento'], 'safe'],
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
        $query = Edital::find()->select(['numero','vagas_doutorado','vagas_mestrado','cartarecomendacao','datainicio','datafim','documento','j17_edital.cotas','COUNT(idEdital) as quantidadeinscritos'])->leftJoin("j17_candidatos","idEdital = numero")->groupBy('numero');


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

                $dataProvider->sort->attributes['quantidadeinscritos'] = [
        'asc' => ['quantidadeinscritos' => SORT_ASC],
        'desc' => ['quantidadeinscritos' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'numero' => $this->numero,
            'datainicio' => $this->datainicio,
            'datafim' => $this->datafim,
        ]);

        $query->andFilterWhere(['like', 'cartarecomendacao', $this->cartarecomendacao])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
    }
}
