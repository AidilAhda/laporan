<?php

namespace app\controllers;

use Yii;

//models
use app\models\PendaftaranLayanan;
use app\models\SdmMUnit;
use app\models\PjpRi;
use app\models\JenisLaporan;
use app\models\JenisLaporanSearch;
use app\models\PelaporanForm;
use app\models\SdmMPegawai;
use app\models\MedisMIcd10cm;

use app\models\MedisResumeMedisRj;
use app\models\MedisRingkasanKeluar;
use app\models\PendaftaranRegistrasi;
use app\models\PendaftaranPasien;

use app\widgets\AuthUser;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * SdmMProvinsiController implements the CRUD actions for SdmMProvinsi model.
 */
class CetakLaporanController extends Controller
{
    protected $cetak = null;
    /**
     * @inheritdoc
     */
 

    /**
     * Lists all SdmMProvinsi models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDiagnosa()
    {
        return $this->render('diagnosa',[
            'model'=>MedisMIcd10cm::find()->limit(2000)->all(),
        ]);
    }
    public function actionKunjunganPasien()
    {
        return $this->render('kunjungan-pasien');
    }

    public function actionDiagnosaSelect2()
    {
        $diagnosa = MedisMIcd10cm::find()->all();
        return $this->render('diagnosa',['modelDetail'=>$diagnosa]);
    }
    //JUMLAH KUNJUNGAN
    public function actionCetakLaporanKunjungan()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');

        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));
        $unit = Yii::$app->request->post('ruangan');
        $ruangan = SdmMUnit::find()->where(['unt_id' => $unit])->one();

        
        if ($unit != null) {
            $model = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                $q->joinWith(['pasien']);
            }])->where(['like',  SdmMUnit::tableName().'.unt_parent_id', $unit])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();

            $total = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                $q->joinWith(['pasien']);
            }])->where(['like',  SdmMUnit::tableName().'.unt_parent_id', $unit])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->count();
            
        }else{
            $model = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                $q->joinWith(['pasien']);
            }])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();
            $total = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                $q->joinWith(['pasien']);
            }])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->count();
        
        }
        
        // echo"<pre>";
        // print_r($model);die();
        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-kunjungan',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'ruangan' => $ruangan ,'total'=>$total]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_RUANGAN_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }

    //DIAGNOSA
    public function actionCetakLaporanDiagnosa()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');
        $diagnosa = Yii::$app->request->post('diagnosa1');
        $unit = Yii::$app->request->post('ruangan');
       
        
        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));

        // echo"<pre>";
        // print_r(Yii::$app->request->post());die();
        
        // $diagnosa=array();
        // foreach($state as $s){
        //     $diagnosa[] = $s;

        // }
        // var_dump($state);
        $model =MedisResumeMedisRj::find()->joinWith(['layanan','dokter'])->where([
            'rmrj_diagnosis_utama_kode' =>$diagnosa]
        )->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andFilterWhere(['pl_unit_kode'=> $unit])->asArray()->all();
        $total =MedisResumeMedisRj::find()->joinWith(['layanan','dokter'])->where([
            'rmrj_diagnosis_utama_kode' =>$diagnosa]
        )->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andFilterWhere(['pl_unit_kode'=> $unit])->count();
        
        // echo"<pre>";
        // print_r($model);die();

        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-diagnosa',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'diagnosa'=>$diagnosa,'total'=>$total]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_RUANGAN_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
        
        
    }
    
    public function actionCetakLaporanRuangan()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');

        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));
        $unit = Yii::$app->request->post('ruangan');

        $ruangan = SdmMUnit::find()->where(['unt_id' => $unit])->one();

        $model = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
            $q->joinWith(['pasien']);
        }])->where(['like',  SdmMUnit::tableName().'.unt_parent_id', $unit])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();
       echo"<pre>";
        print_r($model);die();
        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-ruangan',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai, 'ruangan' => $ruangan]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_RUANGAN_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }


    public function actionIndex1()
    {

        $model = new PelaporanForm();

        if ($model->load(Yii::$app->request->post())) {




            $id_lap = Yii::$app->request->post('PelaporanForm')['jenis_laporan'];
            $thn_lap = Yii::$app->request->post('PelaporanForm')['tahun_laporan'];

            switch ($id_lap) {
                case '1':
                    $this->formRL1_1($thn_lap);
                    break;
                case '2':
                    $this->formRL1_2($thn_lap);
                    break;
                case '3':
                    // $this->formRL1_2($thn_lap);
                    break;
                case '4':
                    $this->formRL2($thn_lap);
                    break;
            }
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'default_font'=>'Arial',
                'orientation' => 'P',
                'format' => 'LEGAL', [200,250]
            ]);
            $pdf->SetDisplayMode('fullpage');
            $pdf->autoPageBreak = true;
            $pdf->shrink_tables_to_fit = 1;
            $pdf->AddPageByArray([
                'orientation'=>'P',
                'margin-top'=>3,
                'margin-right'=>1,
                'margin-left'=>3,
                'margin-bottom'=>0,
            ]);
            $pdf->WriteHTML($this->cetak);
            $pdf->Output('Kwitansi_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
            exit;

        }else{

            $jenis_laporan = JenisLaporan::find()->orderBy(['jl_id'=>SORT_ASC])->all();

            return $this->render('index',[
                'jenis_laporan' => $jenis_laporan,
                'model' => $model
            ]);

        }
    }
    private function formRL1_1($tahun_laporan)
    {

        $this->cetak=$this->renderPartial('format_laporan/form_rl_1',[
            'tahun_laporan'=>$tahun_laporan,
        ]);
    }

    // RL 2 Ketenagaan
    private function formRL2($tahun_laporan)
    {

        $this->cetak=$this->renderPartial('format_laporan/form_rl_2',[
            'tahun_laporan'=>$tahun_laporan,

        ]);
    }

    private function getDokter($gelar_depan, $gelar_belakang){

        $data = SdmMPegawai::find()->select(['COUNT(*) AS jumlah_pegawai'])
            ->andWhere(['=','pgw_gelar_depan',$gelar_depan])
            ->andWhere(['=','pgw_gelar_belakang', $gelar_belakang])
            ->groupBy('pgw_jenis_kelamin')
            ->all();
        if (!isset($data[1])) {
            $data[1]=0;
        }

        return $data;

    }

    private function formRL1_2($tahun_laporan)
    {
        $this->cetak=$this->renderPartial('format_laporan/form_rl_1_2',[
            'tahun_laporan'=>$tahun_laporan,
        ]);
    }

    
}