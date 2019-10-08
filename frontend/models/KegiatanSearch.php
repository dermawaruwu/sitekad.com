<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Kegiatan;

/**
 * KegiatanSearch represents the model behind the search form of `frontend\models\Kegiatan`.
 */
class KegiatanSearch extends Kegiatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'periode'], 'integer'],
            [['nama', "periode", "seksi", "kode"], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Kegiatan::find();

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

        $query->joinWith('kegiatanPeriode')
            ->joinWith('kegiatanSeksi');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'kegiatan.nama', $this->nama])
        ->andFilterWhere(['like', 'kegiatan.kode', $this->kode])
        ->andFilterWhere(['like', 'seksi.nama', $this->seksi])
        ->andFilterWhere(['like', 'periode.periode', $this->periode])
        ->andFilterWhere(['kegiatan.isDeleted' => false]);


        return $dataProvider;
    }
}
