<?php

namespace app\controllers;

use app\models\MedisTindakanPasien;
use app\models\PjpRi;
use app\models\Pjp;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\Data;
use app\models\PelaporanDataKlaim;
use app\models\EbsAksesLoket;
use app\models\EbsMShift;
use app\models\EbsPembayaranPasien;
use app\models\EbsPembayaranPlafon;
use app\widgets\AuthUser;
use app\models\PendaftaranLayanan;


use Mpdf\Mpdf;

class MonitoringController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
                'denyCallback' => function ($rule, $action)
                {
                    $url=Yii::$app->urlManager->createUrl('auth/login');
                    return $this->redirect($url);
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'=>['get'],
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionError()
    {
        return $this->render('error');
    }

    public function actionIndex($tgl_mulai=Null, $tgl_selesai=Null, $Debitur=Null, $Layanan=Null, $unit=Null)
    {

        $data = new Data();
    
        if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
            $tgl_mulai = date('Y-m-d', strtotime($tgl_mulai));
            $tgl_selesai = date('Y-m-d', strtotime($tgl_selesai));
        } else {
            $tgl_mulai = date('Y-m-d');
            $tgl_selesai = date('Y-m-d');
        }

        if (!empty($Debitur)) {
            $Debitur = $Debitur;
        } else {
            $Debitur = 'S';
        }

        if (!empty($Layanan)) {
            $Layanan = $Layanan;
        } else {
            $Layanan = 0;
        }
        if (!empty($unit)) {
            $unit = $unit;
        } else {
            $unit = 0;
        }

    
        $dataMonitoring = $data->getDataMonitoring($tgl_mulai, $tgl_selesai, $Debitur, $Layanan, $unit);

        if (\Yii::$app->request->isAjax){
            return $this->renderAjax('index',[
                'data' =>$dataMonitoring,
                'tgl_mulai' =>$tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'Debitur'=>$Debitur,
                'layanan'=>$Layanan,
                'unit' => $unit
            ]);
        }else {
            return $this->render('index',[
                 'data' =>$dataMonitoring,
                 'Debitur'=>$Debitur,
                'tgl_mulai' =>$tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'layanan'=>$Layanan,
                'unit' => $unit
            ]);
        }
    }

    function actionInputDataKlaim()
    {
        $req=Yii::$app->request;

        if($req->isAjax){

            $model = new PelaporanDataKlaim();
            $rm=$req->post('rm');
            $noreg=$req->post('noreg'); 
            $tgldftr=$req->post('tgldftr'); 
            $nmpasien=$req->post('nmpasien'); 

            return $this->renderAjax('input_data_klaim',
            [
                'kodePasien' => $rm,
                'kodeRegistrasi' => $noreg,
                'tglDaftar' => $tgldftr,
                'namaPasien' => $nmpasien,                
                'model' => $model,

            ]);
        }

    }

    // cetak-rincian-klaim
    function actionCetakRincianKlaim($NoPasien, $NoDaftar, $p=null, $l=null)
    {

         if(!isset($NoPasien) || !isset($NoDaftar) ){
            throw new NotFoundHttpException();
        }
		if(!isset($p)) {
            $p = 241.3;
        }
        if(!isset($l)) {
            $l = 279.4;
        }
        $data = new Data();
        $cekjenisLayanan = PendaftaranLayanan::find()->where(['pl_reg_kode' => $NoDaftar])->andWhere('pl_jenis_layanan <= 4 and pl_deleted_at is null')->andWhere('pl_unit_kode != 59 and pl_unit_kode != 61 and pl_unit_kode != 62 and pl_unit_kode != 63')->orderBy(['pl_id' => SORT_DESC])->one();
        if($cekjenisLayanan->pl_jenis_layanan == 3){
            $layanan = PendaftaranLayanan::find()->where(['pl_reg_kode' => $NoDaftar])->andWhere('pl_jenis_layanan = 3 and pl_deleted_at is null')->orderBy(['pl_id' => SORT_DESC])->one();
        }else{
            $layanan = PendaftaranLayanan::find()->where(['pl_reg_kode' => $NoDaftar])->andWhere('pl_jenis_layanan <= 4 and pl_deleted_at is null')->andWhere('pl_unit_kode != 59 and pl_unit_kode != 61 and pl_unit_kode != 62 and pl_unit_kode != 63')->orderBy(['pl_id' => SORT_DESC])->one();
        }

        $nama_dpjp = "";
        if($layanan->pl_jenis_layanan == 3){
            $dpjp_ri = PjpRi::find()->where(['pjpri_reg_kode' => $layanan->pl_reg_kode, 'pjpri_status' => 1])->andWhere('pjpri_deleted_at is null')->one();
            if(isset($dpjp_ri)){
                $nama_dpjp = $dpjp_ri->pegawai;
            }else{
                $nama_dpjp = null;
            }
        }else{
            $dpjp = Pjp::find()->where(['pjp_pl_id' => $layanan->pl_id, 'pjp_status' => 1])->andWhere('pjp_deleted_at is null')->one();
            if(isset($dpjp)){
                $nama_dpjp = $dpjp->pegawai;
            }else{
                $nama_dpjp = null;
            }

        }

        $ruangan_terakhir = PendaftaranLayanan::find()->joinWith(['registrasi'])->where(['pl_reg_kode' => $NoDaftar])->andWhere('pl_jenis_layanan <= 4 and pl_deleted_at is null')->andWhere('pl_unit_kode != 61 and pl_unit_kode != 62 and pl_unit_kode != 63 and pl_unit_kode != 59 and pl_unit_kode != 84')->orderBy(['reg_tgl_keluar' => SORT_DESC, 'pl_tgl_keluar' => SORT_DESC])->one();


        $registrasi = $data->dataRegistrasi($NoPasien, $NoDaftar);         
        if($registrasi!=NULL){

            $biodata = $data->getBiodataPasien($NoPasien);
            $konsultasi = $data->getDataVedika($NoDaftar,4);

            $prosedurNonBedah = $data->getDataVedika($NoDaftar, 20);
            $prosedurBedah = $data->getDataVedika($NoDaftar, 19);
            $tenagaAhli = $data->getDataVedika($NoDaftar,25);
            $keperawatan = $data->getDataVedika($NoDaftar,3);
            $penunjang = $data->getDataVedika($NoDaftar,18);
            $radiologi = $data->getDataVedika($NoDaftar,21);
            $laboratorium = $data->getDataVedika($NoDaftar,5);
            $rehabilitasi = $data->getDataVedika($NoDaftar,23);
            $alatMedis = $data->getDataVedika($NoDaftar,24);            
            $biayaObat = $data->getDataBiayaObat($NoDaftar);
            // param ke 2 sbg status pencarian data kamar intensif atau tidak
            $akomodasi = $data->getDataKamar($NoDaftar,false);//kamar non-intensif            
            $ruangIntensif = $data->getDataKamar($NoDaftar,true);//kamar intensif
            $tindakanLain = $data->getTindakanLain($NoDaftar);
            
            $id = AuthUser::user()->id;
            $username = $data->getNamaUser($id);

            $connection = \Yii::$app->getDb();
            $command = $connection
                        ->createCommand("SELECT * FROM pendaftaran_registrasi
                                                                            LEFT JOIN bpjskes_sep ON bpjskes_sep.sep_no_sep = pendaftaran_registrasi.reg_no_sep   
                                                                            WHERE pendaftaran_registrasi.reg_pasien_kode= '".$NoPasien."' AND  pendaftaran_registrasi.reg_kode = '".$NoDaftar."'");
            $data_sep= $command->queryOne();

            $cetak=$this->renderPartial('rincian_bpjs',[
                'registrasi'=>$registrasi, 
                    'dataSep' => $data_sep,
                'ruangan_akhir' => $ruangan_terakhir,
                'biodata' => $biodata,
                'layanan' => $layanan,
                'nama_dpjp' => $nama_dpjp,
                'prosedurNonBedah'=>$prosedurNonBedah,
                'prosedurBedah'=>$prosedurBedah,
                'konsultasi'=>$konsultasi,
				'tenagaAhli' => $tenagaAhli,
                'keperawatan'=> $keperawatan,
                'penunjang'=> $penunjang,
                'radiologi' => $radiologi,
                'laboratorium' => $laboratorium,
                'rehabilitasi' => $rehabilitasi,
                'biayaObat'=>$biayaObat,
                'akomodasi' => $akomodasi,
                'ruangIntensif' => $ruangIntensif,
                'alatMedis' => $alatMedis,
                'tindakanLain' => $tindakanLain,
                'username'=>$username
            ]);
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'default_font'=>'Arial',
				'orientation' => 'P',
				'format' => [$p,$l]
            ]);
            // $pdf->simpleTables=true;
            // $pdf->packTableData=true;
            // $pdf->useSubstitutions = false;
		    $pdf->SetDisplayMode('fullpage');
            $pdf->autoPageBreak = true;
            $pdf->shrink_tables_to_fit = 1;
            $pdf->AddPageByArray([
                'orientation'=>'P',
               // 'sheet-size'=>[200,250],
			   // 'sheet-size'=>[$p,$l],
                'margin-top'=>2,
                'margin-right'=>2,
                'margin-left'=>2,
                'margin-bottom'=>5,
            ]);
            $pdf->WriteHTML($cetak);
            $pdf->Output('Rincian_BPJS'.date('d-m-Y H:i:s').'.pdf', \Mpdf\Output\Destination::INLINE);
            exit;
        }
        throw new NotFoundHttpException('Halaman tidak ditemukan');
    }    


    public function actionDetailPembayaran()
    {
        if (\Yii::$app->request->isAjax) {

            $id = $_POST['id'];

            if(!empty($id)) {
                $d =  explode("_",$id);
                $NoPasien = $d[0];
                $NoDaftar = $d[1];

            } else {
                $hasil=[
                    "code"=>"500",
                    "msg"=>"ID Tidak Ada"
                ];
                echo json_encode($hasil);
                die();
            }

            $modelPembayaran = new EbsPembayaranPasien();
            $modelPlafon = new EbsPembayaranPlafon();
            // Data Pembayaran
            $dataPembayaran = $modelPembayaran->getDataRiwayatPembayaran($NoPasien, $NoDaftar);
            $dataPlafon = $modelPlafon->getDataRiwayatPlafon($NoPasien, $NoDaftar);

            $data_pembayaran ='';
            if(count($dataPembayaran) > 0) {
                $no = 1;
                foreach ($dataPembayaran as $data){
                    $data_pembayaran .=   '
                    <tr id="'.$data['byr_kode'].'" style="cursor: pointer">
                        <td><center>'.$no++.'</center></td>
                        <td><center>'.date('d-m-Y H:i', strtotime($data['byr_tanggal'])).'</center></td>
                        <td><center>'.$data['kodebayar']['kob_nama'].'</center></td>
                        <td align="right"><center>'.number_format($data['byr_jumlah'],0,",",".").'</center></td>
                    </tr>';

                }

            } else {

                 $data_pembayaran .=   '
                    <tr style="cursor: pointer">
                        <td colspan="4"><center> Data Pembayaran Tidak Ada </center></td>
                    </tr>';
                    
            }

            $data_plafon ='';
            if(count($dataPlafon) > 0) {
                $no = 1;
                foreach ($dataPlafon as $dataPL){
                    $data_plafon .=   '
                    <tr id="'.$dataPL['byp_kode'].'" style="cursor: pointer">
                        <td><center>'.$no++.'</center></td>
                        <td><center>'.date('d-m-Y H:i', strtotime($dataPL['byp_tanggal'])).'</center></td>
                        <td><center>'.$dataPL['kodebayar']['kob_nama'].'</center></td>
                        <td align="right"><center>'.number_format($dataPL['byp_jumlah'],0,",",".").'</center></td>
                    </tr>';

                }
             
            } else {

                  $data_plafon .=   '
                    <tr style="cursor: pointer">
                        <td colspan="4"><center> Data Pembayaran Plafon Tidak Ada </center></td>
                    </tr>';
            
            }


            $hasil=[
                "code"=>"200",
                "msg"=>"Menampilkan Data Pembayaran",
                "DataPembayaran"=>$data_pembayaran,
                "DataPlafon"=>$data_plafon,
            ];
            echo json_encode($hasil);
            die();

        }
    }

}
