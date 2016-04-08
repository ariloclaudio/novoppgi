<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Aluno;

/**
 * AlunoSearch represents the model behind the search form about `app\models\Aluno`.
 */
class AlunoSearch extends Aluno
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area', 'curso', 'nacionalidade', 'regime', 'status', 'numDefesa', 'egressograd', 'idUser', 'orientador'], 'integer'],
            [['nome', 'email', 'senha', 'matricula', 'endereco', 'bairro', 'cidade', 'uf', 'cep', 'datanascimento', 'sexo', 'estadocivil', 'cpf', 'rg', 'orgaoexpeditor', 'dataexpedicao', 'telresidencial', 'telcomercial', 'telcelular', 'nomepai', 'nomemae', 'bolsista', 'agencia', 'pais', 'dataingresso', 'idiomaExameProf', 'conceitoExameProf', 'dataExameProf', 'tituloQual2', 'dataQual2', 'conceitoQual2', 'tituloTese', 'dataTese', 'conceitoTese', 'horarioQual2', 'localQual2', 'resumoQual2', 'horarioTese', 'localTese', 'resumoTese', 'tituloQual1', 'dataQual1', 'examinadorQual1', 'conceitoQual1', 'cursograd', 'instituicaograd', 'crgrad', 'dataformaturagrad', 'anoconclusao', 'sede'], 'safe'],
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
        $query = Aluno::find();

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
            'area' => $this->area,
            'curso' => $this->curso,
            'nacionalidade' => $this->nacionalidade,
            'regime' => $this->regime,
            'status' => $this->status,
            'numDefesa' => $this->numDefesa,
            'egressograd' => $this->egressograd,
            'idUser' => $this->idUser,
            'orientador' => $this->orientador,
            'anoconclusao' => $this->anoconclusao,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'senha', $this->senha])
            ->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'endereco', $this->endereco])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'cidade', $this->cidade])
            ->andFilterWhere(['like', 'uf', $this->uf])
            ->andFilterWhere(['like', 'cep', $this->cep])
            ->andFilterWhere(['like', 'datanascimento', $this->datanascimento])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'estadocivil', $this->estadocivil])
            ->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'orgaoexpeditor', $this->orgaoexpeditor])
            ->andFilterWhere(['like', 'dataexpedicao', $this->dataexpedicao])
            ->andFilterWhere(['like', 'telresidencial', $this->telresidencial])
            ->andFilterWhere(['like', 'telcomercial', $this->telcomercial])
            ->andFilterWhere(['like', 'telcelular', $this->telcelular])
            ->andFilterWhere(['like', 'nomepai', $this->nomepai])
            ->andFilterWhere(['like', 'nomemae', $this->nomemae])
            ->andFilterWhere(['like', 'bolsista', $this->bolsista])
            ->andFilterWhere(['like', 'agencia', $this->agencia])
            ->andFilterWhere(['like', 'pais', $this->pais])
            ->andFilterWhere(['like', 'dataingresso', $this->dataingresso])
            ->andFilterWhere(['like', 'idiomaExameProf', $this->idiomaExameProf])
            ->andFilterWhere(['like', 'conceitoExameProf', $this->conceitoExameProf])
            ->andFilterWhere(['like', 'dataExameProf', $this->dataExameProf])
            ->andFilterWhere(['like', 'tituloQual2', $this->tituloQual2])
            ->andFilterWhere(['like', 'dataQual2', $this->dataQual2])
            ->andFilterWhere(['like', 'conceitoQual2', $this->conceitoQual2])
            ->andFilterWhere(['like', 'tituloTese', $this->tituloTese])
            ->andFilterWhere(['like', 'dataTese', $this->dataTese])
            ->andFilterWhere(['like', 'conceitoTese', $this->conceitoTese])
            ->andFilterWhere(['like', 'horarioQual2', $this->horarioQual2])
            ->andFilterWhere(['like', 'localQual2', $this->localQual2])
            ->andFilterWhere(['like', 'resumoQual2', $this->resumoQual2])
            ->andFilterWhere(['like', 'horarioTese', $this->horarioTese])
            ->andFilterWhere(['like', 'localTese', $this->localTese])
            ->andFilterWhere(['like', 'resumoTese', $this->resumoTese])
            ->andFilterWhere(['like', 'tituloQual1', $this->tituloQual1])
            ->andFilterWhere(['like', 'dataQual1', $this->dataQual1])
            ->andFilterWhere(['like', 'examinadorQual1', $this->examinadorQual1])
            ->andFilterWhere(['like', 'conceitoQual1', $this->conceitoQual1])
            ->andFilterWhere(['like', 'cursograd', $this->cursograd])
            ->andFilterWhere(['like', 'instituicaograd', $this->instituicaograd])
            ->andFilterWhere(['like', 'crgrad', $this->crgrad])
            ->andFilterWhere(['like', 'dataformaturagrad', $this->dataformaturagrad])
            ->andFilterWhere(['like', 'sede', $this->sede]);

        return $dataProvider;
    }
}
