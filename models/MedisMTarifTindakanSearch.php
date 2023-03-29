<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MedisMTarifTindakan;

/**
 * MedisMTarifTindakanSearch represents the model behind the search form of `app\models\MedisMTarifTindakan`.
 */
class MedisMTarifTindakanSearch extends MedisMTarifTindakan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tft_id', 'tft_js_adm', 'tft_js_sarana', 'tft_js_bhp', 'tft_js_dokter_operator', 'tft_js_dokter_lainya', 'tft_js_dokter_anastesi', 'tft_js_penata_anastesi', 'tft_js_paramedis', 'tft_js_lainya', 'tft_js_adm_cto', 'tft_js_sarana_cto', 'tft_js_bhp_cto', 'tft_js_dokter_operator_cto', 'tft_js_dokter_lainya_cto', 'tft_js_dokter_anastesi_cto', 'tft_js_penata_anastesi_cto', 'tft_js_paramedis_cto', 'tft_js_lainya_cto', 'tft_created_by', 'tft_updated_by', 'tft_deleted_by'], 'integer'],
            [['tft_tindakan_id', 'tft_kelas_rawat_kode', 'tft_sk_tarif_id', 'tft_created_at', 'tft_updated_at', 'tft_deleted_at'], 'safe'],
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
        $query = MedisMTarifTindakan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tft_id' => $this->tft_id,
            'tft_js_adm' => $this->tft_js_adm,
            'tft_js_sarana' => $this->tft_js_sarana,
            'tft_js_bhp' => $this->tft_js_bhp,
            'tft_js_dokter_operator' => $this->tft_js_dokter_operator,
            'tft_js_dokter_lainya' => $this->tft_js_dokter_lainya,
            'tft_js_dokter_anastesi' => $this->tft_js_dokter_anastesi,
            'tft_js_penata_anastesi' => $this->tft_js_penata_anastesi,
            'tft_js_paramedis' => $this->tft_js_paramedis,
            'tft_js_lainya' => $this->tft_js_lainya,
            'tft_js_adm_cto' => $this->tft_js_adm_cto,
            'tft_js_sarana_cto' => $this->tft_js_sarana_cto,
            'tft_js_bhp_cto' => $this->tft_js_bhp_cto,
            'tft_js_dokter_operator_cto' => $this->tft_js_dokter_operator_cto,
            'tft_js_dokter_lainya_cto' => $this->tft_js_dokter_lainya_cto,
            'tft_js_dokter_anastesi_cto' => $this->tft_js_dokter_anastesi_cto,
            'tft_js_penata_anastesi_cto' => $this->tft_js_penata_anastesi_cto,
            'tft_js_paramedis_cto' => $this->tft_js_paramedis_cto,
            'tft_js_lainya_cto' => $this->tft_js_lainya_cto,
            'tft_created_at' => $this->tft_created_at,
            'tft_created_by' => $this->tft_created_by,
            'tft_updated_at' => $this->tft_updated_at,
            'tft_updated_by' => $this->tft_updated_by,
            'tft_deleted_at' => $this->tft_deleted_at,
            'tft_deleted_by' => $this->tft_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'tft_tindakan_id', $this->tft_tindakan_id])
            ->andFilterWhere(['like', 'tft_kelas_rawat_kode', $this->tft_kelas_rawat_kode])
            ->andFilterWhere(['like', 'tft_sk_tarif_id', $this->tft_sk_tarif_id]);

        return $dataProvider;
    }
}
