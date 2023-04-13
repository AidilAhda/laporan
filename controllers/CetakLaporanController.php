<?php

namespace app\controllers;

use Yii;

//models
use app\models\PendaftaranLayanan;
use app\models\SdmMUnit;
use app\models\PjpRi;
use app\models\Pjp;
use app\models\JenisLaporan;
use app\models\JenisLaporanSearch;
use app\models\PelaporanForm;
use app\models\SdmMPegawai;
use app\models\MedisMIcd10cm;

use app\models\MedisResumeMedisRj;
use app\models\MedisRingkasanKeluar;
use app\models\PendaftaranRegistrasi;
use app\models\PendaftaranPasien;
use app\models\penjualan;
use app\models\FarmasiPenjualan;

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

    public function actionLaporanFarmasi()
    {
        return $this->render('laporan-farmasi');
    }
    
    public function actionKunjunganPasien()
    {
        return $this->render('kunjungan-pasien');
    }
    public function actionDebitur()
    {
        return $this->render('debitur');
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
        $jenisLayanan = Yii::$app->request->post('layanan');

        // var_dump($jenisLayanan);
        // die();

        //jika EXCEL
        if (Yii::$app->request->post('excel')) {
            //jika filter ruangan tidak kosong,pilih berdasarkan ruangan ruangan
            if ($jenisLayanan != null) {
                //jika rawat jalan
                if ($jenisLayanan == "1" || $jenisLayanan == "2") {
                    
                    $model = PendaftaranLayanan::find()->joinWith(['unit', 'dpjpRj'=>function($q){
                        $q->joinWith('pegawai');
                    },'registrasi' => function($q){
                    $q->joinWith(['pasien']);
                    }])->where(['pl_jenis_layanan'=>$jenisLayanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->asArray()->all();
                
                    // echo"<pre>";
                    // print_r($model);
                    // die();
                    
                    $filename='LAPORAN KUNJUNGAN PASIEN '.date('d-m-Y H:i:s').'.xlsx';
                        header("Content-Disposition: attachment; filename=\"$filename\"");
                    \moonland\phpexcel\Excel::widget([
                        'models' => $model,
                        'mode' => 'export', //default value as 'export'
                        'columns' => [
                        
                        [
                            'attribute'=>'reg_no_sep',
                            'header'=>'No SEP',
                            'value'=>function($model){
                                return (isset($model['registrasi']))?$model['registrasi']['reg_no_sep'] :'-';

                            }
                        ],      
                        [
                            'attribute'=>'reg_pasien_kode',
                            'header'=>'NO RM',
                            'value'=>function ($model){
                                return (isset($model['registrasi']))?$model['registrasi']['reg_pasien_kode']:'-';
                            }
                        ],
                        [
                            'attribute'=>'ps_nama',
                            'header'=>'NAMA PASIEN',
                            'value'=>function ($model){
                                return (isset($model['registrasi'])?(isset($model['registrasi']['pasien'])?$model['registrasi']['pasien']['ps_nama'].'('.$model['registrasi']['pasien']['ps_no_identitas'].')':'-'):'');
                            }

                        ],
                        [
                            'attribute'=>'unt_nama',
                            'header'=>'RUANGAN',
                            'value'=>function ($model){
                                return (isset($model['pl_unit_kode']))?$model['unit']['unt_nama']:'-';
                            }

                        ],
                        [
                            'attribute'=>'pgw_nama',
                            'header'=>'NAMA DPJP',
                            'value'=>function ($model){

                                return (isset($model['dpjpRj'])?(isset($model['dpjpRj']['pegawai'])?$model['dpjpRj']['pegawai']['pgw_gelar_depan'].' '.$model['dpjpRj']['pegawai']['pgw_nama'] .' '. $model['dpjpRj']['pegawai']['pgw_gelar_belakang'] :'-'):'-');
                            }
                        ],
                        
                       // 'pl_tgl_masuk',
                        [
                            'attribute'=>'pl_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['pl_tgl_masuk']))?date('d-M-Y H:i:s', strtotime($model['pl_tgl_masuk'])) : '-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_keluar',
                            'header'=>'TANGGAL KELUAR',
                            'value'=>function ($model){
                                return (isset($model['registrasi']))?($model['registrasi']['reg_tgl_keluar'] ? date('d-M-Y H:i:s', strtotime($model['registrasi']['reg_tgl_keluar'])) : '-'):'-';
                            }
                        ],
    
                        ], //without header working, because the header will be get label from attribute label. 
                        
                        ]);
                //jika rawat inap
                }else{
                    $model = PendaftaranLayanan::find()->joinWith(['unit', 'dpjpRi'=>function($q){
                        $q->joinWith('pegawai');
                    },'registrasi' => function($q){
                    $q->joinWith(['pasien']);
                    }])->where(['pl_jenis_layanan'=>$jenisLayanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->asArray()->all();
                    
                    
                    // echo"<pre>";
                    // print_r($model);
                    // die();
                    $filename='LAPORAN KUNJUNGAN PASIEN '.date('d-m-Y H:i:s').'.xlsx';
                        header("Content-Disposition: attachment; filename=\"$filename\"");
                    \moonland\phpexcel\Excel::widget([
                        'models' => $model,
                        'mode' => 'export', //default value as 'export'
                        'columns' => [
                        
                        [
                            'attribute'=>'reg_no_sep',
                            'header'=>'No SEP',
                            'value'=>function($model){
                                return (isset($model['registrasi']))?$model['registrasi']['reg_no_sep'] :'-';

                            }
                        ],      
                        [
                            'attribute'=>'reg_pasien_kode',
                            'header'=>'NO RM',
                            'value'=>function ($model){
                                return (isset($model['registrasi']))?$model['registrasi']['reg_pasien_kode']:'-';
                            }
                        ],
                        [
                            'attribute'=>'ps_nama',
                            'header'=>'NAMA PASIEN',
                            'value'=>function ($model){
                                return (isset($model['registrasi'])?(isset($model['registrasi']['pasien'])?$model['registrasi']['pasien']['ps_nama'].'('.$model['registrasi']['pasien']['ps_no_identitas'].')':'-'):'');
                            }
                        ],
                        [
                            'attribute'=>'unt_nama',
                            'header'=>'RUANGAN',
                            'value'=>function ($model){
                                return (isset($model['pl_unit_kode']))?$model['unit']['unt_nama']:'-';
                            }

                        ],
                        [
                            'attribute'=>'pgw_nama',
                            'header'=>'NAMA DPJP',
                            'value'=>function ($model){
                                    return (isset($model['dpjpRi'])?(isset($model['dpjpRi']['pegawai'])?$model['dpjpRi']['pegawai']['pgw_gelar_depan'].' '.$model['dpjpRi']['pegawai']['pgw_nama'] .' '. $model['dpjpRi']['pegawai']['pgw_gelar_belakang'] :'-'):'-');
                            }
                        ],
                        
                       // 'pl_tgl_masuk',
                        [
                            'attribute'=>'pl_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['pl_tgl_masuk']))?date('d-M-Y H:i:s', strtotime($model['pl_tgl_masuk'])) : '-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_keluar',
                            'header'=>'TANGGAL KELUAR',
                            'value'=>function ($model){
                                return (isset($model['registrasi']))?($model['registrasi']['reg_tgl_keluar'] ? date('d-M-Y H:i:s', strtotime($model['registrasi']['reg_tgl_keluar'])) : '-'):'-';
                            }
                        ],
    
                        ], //without header working, because the header will be get label from attribute label. 
                        'headers' => ['pl_tgl_masuk'=>'TANGGAL MASUK'], 
                        ]);

                }
                //jika instalasi kosong saat memilih excel
            }else{
                    $model = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                        $q->joinWith(['pasien']);
                    }])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->asArray()->all();
                    
                // echo"<pre>";
                //     print_r($model);
                //     die();
                $filename='LAPORAN KUNJUNGAN PASIEN '.date('d-m-Y H:i:s').'.xlsx';
                        header("Content-Disposition: attachment; filename=\"$filename\"");
                    \moonland\phpexcel\Excel::widget([
                        'models' => $model,
                        'mode' => 'export', //default value as 'export'
                        'columns' => [
                        
                        [
                            'attribute'=>'reg_no_sep',
                            'header'=>'No SEP',
                            'value'=>function($model){
                                return (isset($model['registrasi']))?$model['registrasi']['reg_no_sep'] :'-';

                            }
                        ],      
                        [
                            'attribute'=>'reg_pasien_kode',
                            'header'=>'NO RM',
                            'value'=>function ($model){
                                return (isset($model['registrasi']))?$model['registrasi']['reg_pasien_kode']:'-';
                            }
                        ],
                        [
                            'attribute'=>'ps_nama',
                            'header'=>'NAMA PASIEN',
                            'value'=>function ($model){
                                return (isset($model['registrasi'])?(isset($model['registrasi']['pasien'])?$model['registrasi']['pasien']['ps_nama'].'('.$model['registrasi']['pasien']['ps_no_identitas'].')':'-'):'');
                            }
                        ],
                        [
                            'attribute'=>'unt_nama',
                            'header'=>'RUANGAN',
                            'value'=>function ($model){
                                return (isset($model['pl_unit_kode']))?$model['unit']['unt_nama']:'-';
                            }

                        ],
                        [
                            'attribute'=>'pgw_nama',
                            'header'=>'NAMA DPJP',
                            'value'=>function ($model){
                                
                                if($model['pl_jenis_layanan']==3){
                                    $dpjp = \app\models\PjpRi::find()->joinWith(['pegawai'])->where(['pjpri_reg_kode' => $model['pl_reg_kode'], 'pjpri_status' => 1])->andWhere('pjpri_deleted_at is null')->one();  
                                }else{
                                    $dpjp = \app\models\Pjp::find()->joinWith(['pegawai'])->where(['pjp_pl_id' => $model['pl_id'], 'pjp_status' => 1])->andWhere('pjp_deleted_at is null')->one();

                                }

                                    return (isset($dpjp)?(isset($dpjp->pegawai)?$dpjp->pegawai->pgw_gelar_depan.' '.$dpjp->pegawai->pgw_nama .' '. $dpjp->pegawai->pgw_gelar_belakang :'-'):'');
                            }
                        ],
                        
                       // 'pl_tgl_masuk',
                        [
                            'attribute'=>'pl_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['pl_tgl_masuk']))?date('d-M-Y H:i:s', strtotime($model['pl_tgl_masuk'])) : '-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_keluar',
                            'header'=>'TANGGAL KELUAR',
                            'value'=>function ($model){
                                return (isset($model['registrasi']))?($model['registrasi']['reg_tgl_keluar'] ? date('d-M-Y H:i:s', strtotime($model['registrasi']['reg_tgl_keluar'])) : '-'):'-';
                            }
                        ],
    
                        ], //without header working, because the header will be get label from attribute label. 
                        'headers' => ['pl_tgl_masuk'=>'TANGGAL MASUK'], 
                        ]);

                }
        
            
                
        //jika tidak EXCEL
        }else{
            //jika filter ruangan kosong,pilih semua ruangan
            if ($jenisLayanan != null) {
                $model = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                    $q->joinWith(['pasien']);
                }])->where(['pl_jenis_layanan'=>$jenisLayanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->asArray()->all();
    
                $total = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                    $q->joinWith(['pasien']);
                }])->where(['pl_jenis_layanan'=>$jenisLayanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->count();
                
            }else{
                //jika layanan tidak dipilih
                $model = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                    $q->joinWith(['pasien']);
                }])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->asArray()->all();
                $total = PendaftaranLayanan::find()->joinWith(['unit', 'registrasi' => function($q){
                    $q->joinWith(['pasien']);
                }])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('pl_deleted_at is null')->count();
            
            }
        
        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-kunjungan',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai ,'total'=>$total,'jenisLayanan'=>$jenisLayanan]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_RUANGAN_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
        }
        
        
    }

    //DIAGNOSA
    public function actionCetakLaporanDiagnosa()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');
        $state = Yii::$app->request->post('diagnosa1');
        $layanan = Yii::$app->request->post('ruangan');
        
        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));

        $diagnosa=array();
        foreach($state as $s){
            $diagnosa[] = $s;

        }
        // var_dump($state);
        $model =MedisResumeMedisRj::find()->joinWith(['layanan'])->where(['or',
            ['rmrj_diagnosis_utama_kode' =>$diagnosa],['rmrj_diagnosis_tambahan1_kode' =>$diagnosa],['rmrj_diagnosis_tambahan2_kode' =>$diagnosa],['rmrj_diagnosis_tambahan3_kode' =>$diagnosa],['rmrj_diagnosis_tambahan4_kode' =>$diagnosa],['rmrj_diagnosis_tambahan5_kode' =>$diagnosa],['rmrj_diagnosis_tambahan6_kode' =>$diagnosa],['rmrj_diagnosis_tambahan7_kode' =>$diagnosa],['rmrj_diagnosis_tambahan8_kode' =>$diagnosa],['rmrj_diagnosis_tambahan9_kode' =>$diagnosa]]
        )->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andFilterWhere(['pl_jenis_layanan'=> $layanan])->andWhere('rmrj_deleted_at is null')->asArray()->all();
        // echo"<pre>";
        // print_r($model);die();

        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-diagnosa',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'diagnosa'=>$diagnosa,'layanan'=>$layanan]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_DIAGNOSA_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
        
        
    }

    //FARMASI DEPO
    public function actionCetakLaporanFarmasiDepo()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');

        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));
        $unit = Yii::$app->request->post('farmasi_depo');
        $ruangan = SdmMUnit::find()->where(['unt_id' => $unit])->one();

        //print_r($unit);
        if ($unit != null) {
            $model = FarmasiPenjualan::find()->select(['unt_nama', 'bar_nama', 'pnj_tanggal_resep',  'pens_jumlah', 'pens_satuan', 'pens_harga_jual', 'pens_biaya_layanan','pens_subtotal','pnj_depo_id','pnj_id', 'pnj_unit_id', 'SUM(pens_jumlah) as jumlah', 'SUM(pens_subtotal) as total', 'SUM(pens_biaya_layanan) as biaya_layanan'])->joinWith(['poli','depo','detail' => function($q){
                $q->joinWith(['subdetail' => function($q){
                    $q->joinWith(['barang']);
                }]);
            }])->where(['pnj_depo_id' =>$unit])->andFilterWhere(['between', 'DATE(pnj_tanggal_resep)', $tanggal_mulai, $tanggal_selesai])->groupBy(['bar_id', 'DATE(pnj_tanggal_resep)'])->asArray()->all();
        }else{
            $model = FarmasiPenjualan::find()->joinWith(['depo','detail','poli'])->andFilterWhere(['between', 'DATE(pnj_tanggal_resep)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();
        }
        // echo"<pre>";
        // print_r($model);die();
        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-farmasi-depo',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'ruangan'=>$ruangan ]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_FARMASI_DEPO_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }

    //FARMASI DOKTER
    public function actionCetakLaporanFarmasiDokter()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');

        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));
        $unit = Yii::$app->request->post('farmasi_dokter');
        $dokterf = SdmMPegawai::find()->where(['pgw_id' => $unit ])->one();

        //   echo"<pre>";
        // print_r($dokterf);die();
        if ($unit != null) {
            $model = FarmasiPenjualan::find()->where(['pnj_dokter_id'=>$unit])->joinWith(['dokter','detail','poli'])->andFilterWhere(['between', 'DATE(pnj_tanggal_resep)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();
            
        }else{
            $model = FarmasiPenjualan::find()->joinWith(['dokter','detail','poli'])->andFilterWhere(['between', 'DATE(pnj_tanggal_resep)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();
        
        }
        // echo"<pre>";
        // print_r($model);die();
        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-farmasi-dokter',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'dokterf'=>$dokterf ]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_FARMASI_DOKTER_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }

    //FARMASI PASIEN
    public function actionCetakLaporanFarmasiPasien()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');

        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));
        $pasien = Yii::$app->request->post('FarmasiPasien');


        //print_r($unit);
            $model = FarmasiPenjualan::find()->where(['like', 'pnj_no_rm', $pasien])->orWhere(['like', 'pnj_nama_pasien', $pasien])->joinWith(['detail','poli'])->orWhere(['like', 'pnj_no_daftar', $pasien])->joinWith(['detail','poli'])->andFilterWhere(['between', 'DATE(pnj_tanggal_resep)', $tanggal_mulai, $tanggal_selesai])->asArray()->all();
        // echo"<pre>";
        // print_r($pasienf);die();
        $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

        $pdf->showImageErrors = true;
        $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-farmasi-pasien',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'pasienf'=>$pasien ]);
        $pdf->AddPageByArray([
            'orientation' => 'L',
            'margin-bottom'=>0,
        ]);
        $pdf->WriteHTML($page);
        $pdf->Output('LAPORAN_FARMASI_PASIEN_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }
    
    //RUANGAN
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

    //DEBITUR
    public function actionCetakLaporanDebitur()
    {
        $tgl_m = Yii::$app->request->post('tanggal_mulai');
        $tgl_s = Yii::$app->request->post('tanggal_selesai');
        $debitur = Yii::$app->request->post('debitur');
        $layanan = Yii::$app->request->post('ruangan');
        $tanggal_mulai = date('Y-m-d', strtotime($tgl_m));
        $tanggal_selesai = date('Y-m-d', strtotime($tgl_s));
        
        $model = "";
        // JIKA EXCEL
        if (Yii::$app->request->post('excel')) {
            //jika filter ruangan tidak kosong,pilih berdasarkan ruangan ruangan
            if ($layanan != null) {
                //jika rawat jalan
                if ($layanan == "1" || $layanan == "2") {
                    $model = PendaftaranRegistrasi::find()->joinWith(['debiturdetail','layananhasone'=>function($q){
                        $q->joinWith(['dpjpRj'=>function($w){
                            $w->joinWith(['pegawai']);
                        },'unit','diagnosa']);
                        
                    },'pasien'])->where(['reg_pmdd_kode'=>$debitur,'pl_jenis_layanan'=>$layanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('reg_deleted_by is null')->asArray()->all();
                    
                
                    // echo"<pre>";
                    // print_r($model);
                    // die();
                    
                    $filename='LAPORAN DEBITUR '.date('d-m-Y H:i:s').'.xlsx';
                        header("Content-Disposition: attachment; filename=\"$filename\"");
                    \moonland\phpexcel\Excel::widget([
                        'models' => $model,
                        'mode' => 'export', //default value as 'export'
                        'columns' => [
                        
                        [
                            'attribute'=>'reg_pasien_kode',
                            'header'=>'No RM',
                            'value'=>function($model){
                                return (isset($model['reg_pasien_kode']))?$model['reg_pasien_kode'] :'-';

                            }
                        ],      
                        [
                            'attribute'=>'pasien',
                            'header'=>'NAMA PASIEN',
                            'value'=>function ($model){
                                return (isset($model['pasien']))?$model['pasien']['ps_nama'].' ('.$model['pasien']['ps_no_identitas'].')':'-';
                            }
                        ],
                        [
                            'attribute'=>'pmdd_nama',
                            'header'=>'NAMA DEBITUR',
                            'value'=>function ($model){
                                return (isset($model['debiturdetail']))?$model['debiturdetail']['pmdd_nama']:'-';
                            }
                        ],
                        [
                            'attribute'=>'unt_nama',
                            'header'=>'RUANGAN',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['unit'])?$model['layananhasone']['unit']['unt_nama']:'-'):'-');
                            }
                        ],
                        [
                            'attribute'=>'pgw_nama',
                            'header'=>'NAMA DPJP',
                            'value'=>function ($model){

                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['dpjpRj'])?(isset($model['layananhasone']['dpjpRj']['pegawai'])?$model['layananhasone']['dpjpRj']['pegawai']['pgw_gelar_depan'].' '.$model['layananhasone']['dpjpRj']['pegawai']['pgw_nama'].' ' . $model['layananhasone']['dpjpRj']['pegawai']['pgw_gelar_belakang']:'-'):'-'):'-');
                            }
                        ],     
                        [
                            'attribute'=>'rmrj_diagnosis_utama_deskripsi',
                            'header'=>'DIAGNOSA',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['diagnosa'])?($model['layananhasone']['diagnosa']['rmrj_diagnosis_utama_deskripsi']):'-'):'-');
                            }

                        ],
                        [
                            'attribute'=>'rmrj_keluhan',
                            'header'=>'KELUHAN',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['diagnosa'])?($model['layananhasone']['diagnosa']['rmrj_keluhan']):'-'):'-');
                            }

                        ],
                        [
                            'attribute'=>'rmrj_terapi',
                            'header'=>'TERAPI',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['diagnosa'])?($model['layananhasone']['diagnosa']['rmrj_terapi']):'-'):'-');
                            }

                        ],
                        [
                            'attribute'=>'pmdd_nama',
                            'header'=>'NAMA DEBITUR',
                            'value'=>function ($model){
                                return (isset($model['debiturdetail']))?$model['debiturdetail']['pmdd_nama']:'-';
                            }
                        ],
                        
                        
                    
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_masuk']))?$model['reg_tgl_masuk']:'-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_masuk']))?$model['reg_tgl_masuk']:'-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL KELUAR',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_keluar']))?$model['reg_tgl_keluar']:'-';
                            }
                        ],
    
                        ], //without header working, because the header will be get label from attribute label. 
                        'headers' => ['pl_tgl_masuk'=>'TANGGAL MASUK'], 
                        ]);
            
                //jika rawat inap
                }else{
                    $model = PendaftaranRegistrasi::find()->joinWith(['debiturdetail','layananhasone'=>function($q){
                        $q->joinWith(['dpjpRi'=>function($w){
                            $w->joinWith(['pegawai']);
                        },'unit','diagnosa']);
                        
                    },'pasien'])->where(['reg_pmdd_kode'=>$debitur,'pl_jenis_layanan'=>$layanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('reg_deleted_by is null')->asArray()->all();
                    
                    
                    // echo"<pre>";
                    // print_r($model);
                    // die();
                    $filename='LAPORAN DEBITUR '.date('d-m-Y H:i:s').'.xlsx';
                        header("Content-Disposition: attachment; filename=\"$filename\"");
                    \moonland\phpexcel\Excel::widget([
                        'models' => $model,
                        'mode' => 'export', //default value as 'export'
                        'columns' => [
                        
                        [
                            'attribute'=>'reg_pasien_kode',
                            'header'=>'No RM',
                            'value'=>function($model){
                                return (isset($model['reg_pasien_kode']))?$model['reg_pasien_kode'] :'-';

                            }
                        ],      
                        [
                            'attribute'=>'pasien',
                            'header'=>'NAMA PASIEN',
                            'value'=>function ($model){
                                return (isset($model['pasien']))?$model['pasien']['ps_nama'].' ('.$model['pasien']['ps_no_identitas'].')':'-';
                            }
                        ],
                        [
                            'attribute'=>'pmdd_nama',
                            'header'=>'NAMA DEBITUR',
                            'value'=>function ($model){
                                return (isset($model['debiturdetail']))?$model['debiturdetail']['pmdd_nama']:'-';
                            }
                        ],
                        [
                            'attribute'=>'unt_nama',
                            'header'=>'RUANGAN',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['unit'])?$model['layananhasone']['unit']['unt_nama']:'-'):'-');
                            }
                        ],
                        [
                            'attribute'=>'pgw_nama',
                            'header'=>'NAMA DPJP',
                            'value'=>function ($model){

                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['dpjpRi'])?(isset($model['layananhasone']['dpjpRi']['pegawai'])?$model['layananhasone']['dpjpRi']['pegawai']['pgw_gelar_depan'].' '.$model['layananhasone']['dpjpRi']['pegawai']['pgw_nama'].' ' . $model['layananhasone']['dpjpRi']['pegawai']['pgw_gelar_belakang']:'-'):'-'):'-');
                            }
                        ],     
                        [
                            'attribute'=>'rmrj_diagnosis_utama_deskripsi',
                            'header'=>'DIAGNOSA',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['diagnosa'])?($model['layananhasone']['diagnosa']['rmrj_diagnosis_utama_deskripsi']):'-'):'-');
                            }

                        ],
                        [
                            'attribute'=>'rmrj_keluhan',
                            'header'=>'KELUHAN',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['diagnosa'])?($model['layananhasone']['diagnosa']['rmrj_keluhan']):'-'):'-');
                            }

                        ],
                        [
                            'attribute'=>'rmrj_terapi',
                            'header'=>'TERAPI',
                            'value'=>function ($model){
                                return (isset($model['layananhasone'])?(isset($model['layananhasone']['diagnosa'])?($model['layananhasone']['diagnosa']['rmrj_terapi']):'-'):'-');
                            }

                        ],
                        [
                            'attribute'=>'pmdd_nama',
                            'header'=>'NAMA DEBITUR',
                            'value'=>function ($model){
                                return (isset($model['debiturdetail']))?$model['debiturdetail']['pmdd_nama']:'-';
                            }
                        ],
                        
                        
                    
                        [
                            'attribute'=>'pl_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['layananhasone']))?$model['layananhasone']['pl_tgl_masuk']:'-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_masuk']))?$model['reg_tgl_masuk']:'-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL KELUAR',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_keluar']))?$model['reg_tgl_keluar']:'-';
                            }
                        ],
    
                        ], //without header working, because the header will be get label from attribute label. 
                        'headers' => ['pl_tgl_masuk'=>'TANGGAL MASUK'], 
                        ]);

                }
                //jika instalasi kosong saat memilih excel
            }else{
                    $model = PendaftaranRegistrasi::find()->joinWith(['debiturdetail','layananhasone','pasien'])->where(['reg_pmdd_kode'=>$debitur])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('reg_deleted_by is null')->asArray()->all();
                    
                // echo"<pre>";
                //     print_r($model);
                //     die();
                $filename='LAPORAN KUNJUNGAN PASIEN '.date('d-m-Y H:i:s').'.xlsx';
                        header("Content-Disposition: attachment; filename=\"$filename\"");
                    \moonland\phpexcel\Excel::widget([
                        'models' => $model,
                        'mode' => 'export', //default value as 'export'
                         'columns' => [
                        
                        [
                            'attribute'=>'reg_pasien_kode',
                            'header'=>'No RM',
                            'value'=>function($model){
                                return (isset($model['reg_pasien_kode']))?$model['reg_pasien_kode'] :'-';

                            }
                        ],      
                        [
                            'attribute'=>'pasien',
                            'header'=>'NAMA PASIEN',
                            'value'=>function ($model){
                                return (isset($model['pasien']))?$model['pasien']['ps_nama'].' ('.$model['pasien']['ps_no_identitas'].')':'-';
                            }
                        ],
                        [
                            'attribute'=>'pmdd_nama',
                            'header'=>'NAMA DEBITUR',
                            'value'=>function ($model){
                                return (isset($model['debiturdetail']))?$model['debiturdetail']['pmdd_nama']:'-';
                            }
                        ],
                        [
                            'attribute'=>'unt_nama',
                            'header'=>'RUANGAN',
                            'value'=>function ($model){
                            $unit = SdmMUnit::find()->where(['unt_id' =>$model['layananhasone']['pl_unit_kode'] ])->one();
                                return (isset($unit)?$unit->unt_nama:'-');
                                
                            }
                        ],
                        [
                            'attribute'=>'pgw_nama',
                            'header'=>'NAMA DPJP',
                            'value'=>function ($model){
                                
                                if ($model['layananhasone']['pl_jenis_layanan']==1||$model['layananhasone']['pl_jenis_layanan']==2) {
                                    $dpjp = \app\models\Pjp::find()->joinWith(['pegawai'])->where(['pjp_pl_id' => $model['layananhasone']['pl_id'], 'pjp_status' => 1])->andWhere('pjp_deleted_at is null')->one();
                                } else {
                                    $dpjp = \app\models\PjpRi::find()->joinWith(['pegawai'])->where(['pjpri_reg_kode' => $model['layananhasone']['pl_reg_kode'], 'pjpri_status' => 1])->andWhere('pjpri_deleted_at is null')->one(); 
                                }
                                

                                return (isset($dpjp)?(isset($dpjp->pegawai)?$dpjp->pegawai->pgw_gelar_depan.' '. $dpjp->pegawai->pgw_nama.' '.$dpjp->pegawai->pgw_gelar_belakang:'-'):'-');
                            }
                        ],     
                        [
                            'attribute'=>'rmrj_diagnosis_utama_deskripsi',
                            'header'=>'DIAGNOSA',
                            'value'=>function ($model){
                                if ($model['layananhasone']['pl_jenis_layanan']==1||$model['layananhasone']['pl_jenis_layanan']==2) {
                                $diagnosa = MedisResumeMedisRj::find()->where(['rmrj_pl_id'=>$model['layananhasone']['pl_id']])->one();
                            }
                             return (isset($diagnosa)?$diagnosa->rmrj_diagnosis_utama_deskripsi:'-');
                            }

                        ],
                        [
                            'attribute'=>'rmrj_keluhan',
                            'header'=>'KELUHAN',
                            'value'=>function ($model){
                                if ($model['layananhasone']['pl_jenis_layanan']==1||$model['layananhasone']['pl_jenis_layanan']==2) {
                                $diagnosa = MedisResumeMedisRj::find()->where(['rmrj_pl_id'=>$model['layananhasone']['pl_id']])->one();
                            }
                             return (isset($diagnosa)?$diagnosa->rmrj_keluhan:'-');
                            }

                        ],
                        [
                            'attribute'=>'rmrj_terapi',
                            'header'=>'TERAPI',
                            'value'=>function ($model){
                                if ($model['layananhasone']['pl_jenis_layanan']==1||$model['layananhasone']['pl_jenis_layanan']==2) {
                                $diagnosa = MedisResumeMedisRj::find()->where(['rmrj_pl_id'=>$model['layananhasone']['pl_id']])->one();
                            }
                             return (isset($diagnosa)?$diagnosa->rmrj_terapi:'-');
                            }

                        ],
                       
                    
                        [
                            'attribute'=>'pmdd_nama',
                            'header'=>'NAMA DEBITUR',
                            'value'=>function ($model){
                                return (isset($model['debiturdetail']))?$model['debiturdetail']['pmdd_nama']:'-';
                            }
                        ],
                        
                        
                    
                        [
                            'attribute'=>'pl_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['layananhasone']))?$model['layananhasone']['pl_tgl_masuk']:'-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL MASUK',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_masuk']))?$model['reg_tgl_masuk']:'-';
                            }
                        ],
                        [
                            'attribute'=>'reg_tgl_masuk',
                            'header'=>'TANGGAL KELUAR',
                            'value'=>function ($model){
                                return (isset($model['reg_tgl_keluar']))?$model['reg_tgl_keluar']:'-';
                            }
                        ],
    
                        ], //without header working, because the header will be get label from attribute label. 
                        'headers' => ['pl_tgl_masuk'=>'TANGGAL MASUK'], 
                        ]);

                }
        
            
                
        //jika tidak EXCEL
        } else {
            if($layanan){
            $model = PendaftaranRegistrasi::find()->joinWith(['debiturdetail','layananhasone','pasien'])->where(['reg_pmdd_kode'=>$debitur,'pl_jenis_layanan'=>$layanan])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('reg_deleted_by is null')->asArray()->all();
            //  echo"<pre>";
            // print_r($model);die();
            }else{
                $model = PendaftaranRegistrasi::find()->joinWith(['debiturdetail','layananhasone','pasien'])->where(['reg_pmdd_kode'=>$debitur])->andFilterWhere(['between', 'DATE(pl_tgl_masuk)', $tanggal_mulai, $tanggal_selesai])->andWhere('reg_deleted_by is null')->asArray()->all();

            }
                //     echo"<pre>";
                // print_r($model);die();
                $pdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp','format'=>'Legal']);

                $pdf->showImageErrors = true;
                $page=$this->renderPartial('/cetak-laporan/hasil-cetak-laporan-debitur',['model'=>$model, 'mulai' => $tanggal_mulai, 'selesai' => $tanggal_selesai,'debitur'=>$debitur]);
                $pdf->AddPageByArray([
                    'orientation' => 'L',
                    'margin-bottom'=>0,
                ]);
                $pdf->WriteHTML($page);
                $pdf->Output('LAPORAN_DEBITUR_'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
                exit;
            
        }
        
        
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