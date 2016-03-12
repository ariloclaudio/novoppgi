<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Candidato;

/**
 * CandidatosSearch represents the model behind the search form about `app\models\Candidato`.
 */
class CandidatosSearch extends Candidato
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'passoatual', 'nacionalidade', 'cursodesejado', 'regime', 'anoposcomp', 'linhapesquisa', 'egressograd', 'tipopos', 'egressopos', 'periodicosinternacionais', 'periodicosnacionais', 'conferenciasinternacionais', 'conferenciasnacionais', 'resultado'], 'integer'],
            [['senha', 'inicio', 'fim', 'nome', 'endereco', 'bairro', 'cidade', 'uf', 'cep', 'email', 'datanascimento', 'pais', 'passaporte', 'cpf', 'sexo', 'telresidencial', 'telcelular', 'inscricaoposcomp', 'notaposcomp', 'solicitabolsa', 'tituloproposta', 'diploma', 'historico', 'motivos', 'proposta', 'curriculum', 'comprovantepagamento', 'cursograd', 'instituicaograd',  'dataformaturagrad', 'cursopos', 'instituicaopos', 'dataformaturapos', 'periodo'], 'safe'],
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
        $idEdital = $params['id'];
        $query = Candidato::find()->where('idEdital ="'.$idEdital.'"');

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
            'inicio' => $this->inicio,
            'fim' => $this->fim,
            'passoatual' => $this->passoatual,
            'nacionalidade' => $this->nacionalidade,
            'cursodesejado' => $this->cursodesejado,
            'regime' => $this->regime,
            'anoposcomp' => $this->anoposcomp,
            'linhapesquisa' => $this->linhapesquisa,
            'egressograd' => $this->egressograd,
            'tipopos' => $this->tipopos,
            'egressopos' => $this->egressopos,
            'periodicosinternacionais' => $this->periodicosinternacionais,
            'periodicosnacionais' => $this->periodicosnacionais,
            'conferenciasinternacionais' => $this->conferenciasinternacionais,
            'conferenciasnacionais' => $this->conferenciasnacionais,
            'resultado' => $this->resultado,
        ]);

        $query->andFilterWhere(['like', 'senha', $this->senha])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'endereco', $this->endereco])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'cidade', $this->cidade])
            ->andFilterWhere(['like', 'uf', $this->uf])
            ->andFilterWhere(['like', 'cep', $this->cep])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'datanascimento', $this->datanascimento])
            ->andFilterWhere(['like', 'pais', $this->pais])
            ->andFilterWhere(['like', 'passaporte', $this->passaporte])
            ->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'telresidencial', $this->telresidencial])
            ->andFilterWhere(['like', 'telcelular', $this->telcelular])
            ->andFilterWhere(['like', 'inscricaoposcomp', $this->inscricaoposcomp])
            ->andFilterWhere(['like', 'notaposcomp', $this->notaposcomp])
            ->andFilterWhere(['like', 'solicitabolsa', $this->solicitabolsa])
            ->andFilterWhere(['like', 'tituloproposta', $this->tituloproposta])
            ->andFilterWhere(['like', 'diploma', $this->diploma])
            ->andFilterWhere(['like', 'historico', $this->historico])
            ->andFilterWhere(['like', 'motivos', $this->motivos])
            ->andFilterWhere(['like', 'proposta', $this->proposta])
            ->andFilterWhere(['like', 'curriculum', $this->curriculum])
            ->andFilterWhere(['like', 'comprovantepagamento', $this->comprovantepagamento])
            ->andFilterWhere(['like', 'cursograd', $this->cursograd])
            ->andFilterWhere(['like', 'instituicaograd', $this->instituicaograd])
            ->andFilterWhere(['like', 'dataformaturagrad', $this->dataformaturagrad])
            ->andFilterWhere(['like', 'cursopos', $this->cursopos])
            ->andFilterWhere(['like', 'instituicaopos', $this->instituicaopos])
            ->andFilterWhere(['like', 'dataformaturapos', $this->dataformaturapos])
            ->andFilterWhere(['like', 'periodo', $this->periodo]);

            //

        return $dataProvider;
    }
}
