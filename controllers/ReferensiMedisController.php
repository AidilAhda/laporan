<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\pendaftaran\Layanan;
use app\models\medis\ItemPemeriksaanPenunjang;
use app\models\medis\Icd10cm;
use app\models\medis\Icd9cm;
use app\models\MedisMIcd10cm;
use app\models\farmasi\Barang;
// use app\models\farmasi\Dosis;
// use app\models\farmasi\Petunjuk;
// use app\models\farmasi\Takaran;
// use app\models\farmasi\WaktuPenggunaan;
use app\models\medis\MasalahKeperawatan;
use app\models\medis\IntervensiKeperawatan;
use app\models\medis\ProblemGizi;
use app\models\medis\EtiologiGizi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\components\HelperGeneral;
use app\components\HelperSpesial;
use app\components\MakeResponse;
class ReferensiMedisController extends Controller
{
    public function actionItemPemeriksaanPenunjang($unit=null,$search=null){
        $items=ItemPemeriksaanPenunjang::getData($unit);
        if($items){
            $items = ArrayHelper::getColumn($items, function ($val) {
                if($val['ipp_id']==0){
                    return ['id'=>$val['ipp_id'],'parent'=>((empty($val['ipp_parent_id']))?'#':$val['ipp_parent_id']),'text'=>$val['ipp_deskripsi'],'state'=>['opened'=>true,'selected'=>false,'disabled'=>false]];
    
                }else{
                    return ['id'=>$val['ipp_id'],'parent'=>((empty($val['ipp_parent_id']))?'#':$val['ipp_parent_id']),'text'=>$val['ipp_deskripsi'],'state'=>['opened'=>true,'selected'=>false,'disabled'=>false]];
                }
            });
            return MakeResponse::create(true, 'Data Item Pemeriksaan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Item Pemeriksaan Tidak Ditemukan');
    }
    //OLD & gk dipake
    // public function actionRekonItemPemeriksaanPenunjang($items=array()){
    //     $list_items=ItemPemeriksaanPenunjang::getDataQuery();
    //     if($list_items){
    //         //konversi dari string(hilangkan []) ke array string => ex : ["12","11"]
    //         $size_items=strlen($items);
    //         $array_items=[];
    //         if($size_items>2){
    //             $array_items=explode(',',substr($items,1,($size_items-2)));
    //         }
    //         //konversi object array dari string(hilangkan kutip) ke number => ex : "12" => 12
    //         $array_items2=[];
    //         foreach($array_items as $v){
    //             $size_items=strlen($v);
    //             array_push($array_items2,intval(substr($v,1,($size_items-2))));
    //         }
    //         $list_items2=array();
    //         foreach($list_items as $val){
    //             if(in_array(intval($val['ipp_id']),$array_items2)){
    //                 array_push($list_items2,$val);
    //             }
    //         }   
    //         // echo'<pre/>';print_r($list_items2);die();
    //         return MakeResponse::create(true, 'Data Item Pemeriksaan Tersedia',$list_items2);
    //     }
    //     return MakeResponse::create(false, 'Data Item Pemeriksaan Tidak Ditemukan');
    // }
    public function actionRekonItemPemeriksaanPenunjang($items){
        $array_items2=HelperSpesial::PenunjangKonversiStringKeArray($items);
        if($array_items2){
            $list_items=HelperSpesial::RekonItemPemeriksaanPenunjang($array_items2);
            if($list_items){
                return MakeResponse::create(true, 'Data Item Pemeriksaan Order Penunjang Tersedia',$list_items);
            }
        }   
        return MakeResponse::create(false, 'Data Item Pemeriksaan Order Penunjang Kosong');
    }
    public function actionItemPemeriksaanRad($po_id){
        $array_items2=HelperSpesial::PenunjangKonversiStringKeArray($po_id);
        if($array_items2){
            $list_items=HelperSpesial::RekonItemPemeriksaanPenunjang($array_items2);
            if($list_items){
                return MakeResponse::create(true, 'Data Item Pemeriksaan Order Penunjang Tersedia',$list_items);
            }
        }   
        return MakeResponse::create(false, 'Data Item Pemeriksaan Order Penunjang Kosong');
    }
    public function actionItemPemeriksaanLab($po_id){
        $array_items2=HelperSpesial::PenunjangKonversiStringKeArray($po_id);
        if($array_items2){
            $list_items=HelperSpesial::RekonItemPemeriksaanPenunjang($array_items2);
            if($list_items){
                return MakeResponse::create(true, 'Data Item Pemeriksaan Order Penunjang Tersedia',$list_items);
            }
        }   
        return MakeResponse::create(false, 'Data Item Pemeriksaan Order Penunjang Kosong');
    }
    public function actionItemPemeriksaanLabPa($po_id){
        $array_items2=HelperSpesial::PenunjangKonversiStringKeArray($po_id);
        if($array_items2){
            $list_items=HelperSpesial::RekonItemPemeriksaanPenunjang($array_items2);
            if($list_items){
                return MakeResponse::create(true, 'Data Item Pemeriksaan Order Penunjang Tersedia',$list_items);
            }
        }   
        return MakeResponse::create(false, 'Data Item Pemeriksaan Order Penunjang Kosong');
    }
    public function actionIcd10($search=null){
        $items=Icd10cm::getDataQuery($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'text');
            return MakeResponse::create(true, 'Data Item Pemeriksaan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Item Pemeriksaan Tidak Ditemukan');
    }
    public function actionIcd9($search=null){
        $items=MedisMIcd10cm::getDataQuery($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'text');
            return MakeResponse::create(true, 'Data Item Pemeriksaan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Item Pemeriksaan Tidak Ditemukan');
    }
    public function actionIcd10Select2($search=null,$limit=100){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax) {
            $icd10 = ArrayHelper::getColumn(MedisMIcd10cm::getDataQuery($search), function ($data) {
                return [
                    'status'=>true,
                    'id' => $data['icd10_kode'],
                    'text' => $data['icd10_deskripsi'],
                    'text_full' => $data['text'],
                    'kode'=>$data['icd10_kode'],
                    'deskripsi'=>$data['icd10_deskripsi']
                ];
            });
            return ['results' => $icd10];
        }
        return ['results' => [['status'=>false,'text'=>'Data Tidak Tersedia']]];
    }
    public function actionIcd9Select2($search=null,$limit=100){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax) {
            $icd10 = ArrayHelper::getColumn(Icd9cm::getDataQuery($search), function ($data) {
                return [
                    'status'=>true,
                    'id' => $data['icd9_kode'],
                    'text' => $data['icd9_deskripsi'],
                    'text_full' => $data['text'],
                    'kode'=>$data['icd9_kode'],
                    'deskripsi'=>$data['icd9_deskripsi']
                ];
            });
            return ['results' => $icd10];
        }
        return ['results' => [['status'=>false,'text'=>'Data Tidak Tersedia']]];
    }
    public function actionObat($search=null){
        $items=Barang::getData($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'text');
            return MakeResponse::create(true, 'Data Obat Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Obat Tidak Ditemukan');
    }
    public function actionObatSelect2($search,$depo_id=null,$limit=100){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax) {
            $show_stok=Yii::$app->params['setting']['show_stock_obat_depo'];
            if($depo_id){
                $barang = ArrayHelper::getColumn(Barang::getDataSearchObatDepo($search), function ($data) use($depo_id,$show_stok) {
                    //arraymap kan
                    $stok_obat_depo=ArrayHelper::map($data['stokDepo'], 'spo_depo_id', 'spo_jumlah');
                    $stok=0;
                    // if(array_key_exists($depo_id,$stok_obat_depo)){
                    if(isset($stok_obat_depo[$depo_id])){
                        $stok=intval($stok_obat_depo[$depo_id]);
                    }
                    return [
                        'status'=>true,
                        'id' => $data['bar_id'],
                        'text' => $data['bar_nama'],
                        'stok'=>$stok,
                        'text_full' => '<b>Nama</b> : '.$data['bar_nama']
                        // 'text_full' => '<b>Nama</b> : '.$data['bar_nama'].'
                        // <br><b>Satuan</b> : ' . $data['satuan']['sat_nama']
                        // 'text_full' => '<b>Nama</b> : '.$data['bar_nama'].'
                        // <br><b>Satuan</b> : ' . $data['satuan']['sat_nama'] . '
                        // // <br><b>Kelompok</b> : ' . $data['kelompok']['kel_nama']
                    ];
                });
                return ['results' => $barang];
            }else{
                return ['results' => [['status'=>false,'text'=>'Silahkan Pilih Depo Dahulu']]];
            }
        }
        return ['results' => [['status'=>false,'text'=>'Data Tidak Tersedia']]];
    }
    public function actionLayananIgdRjRiSelect2($search,$limit=100){
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax) {
            $layanan=ArrayHelper::getColumn(Layanan::getDataSearchIgdRjRi($search), function ($data) {
                return [
                    'status'=>true,
                    'id' => $data['pl_id'],
                    'text' => '<b>No.RM</b> : '.$data['registrasi']['reg_pasien_kode']
                    .' <b>Nama</b> : ' . $data['registrasi']['pasien']['ps_nama']
                    .' <b>Ruangan</b> : ' . $data['unit']['unt_nama']
                    .' <b>Tgl.Masuk</b> : ' . date('d-m-Y H:i',strtotime($data['pl_tgl_masuk']))
                ];
            });
            // echo'<pre/>';print_r($layanan);die();
            return ['results' => $layanan];
        }
        return ['results' => [['status'=>false,'text'=>'Data Tidak Tersedia']]];
    }
    // public function actionDosis($search=null) {
    //     if(\Yii::$app->request->isAjax) {
    //         \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    //             return ArrayHelper::getColumn(Dosis::getData($search), 'dos_nama');
    //         }
    //     return []; 
    // }
    // public function actionPetunjuk($search=null) {
    //     if(\Yii::$app->request->isAjax) {
    //         \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    //         return ArrayHelper::getColumn(Petunjuk::getData($search), 'pet_nama');
    //     }
    //     return []; 
    // }
    // public function actionTakaran($search=null) {
    //     if(\Yii::$app->request->isAjax) {
    //         \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    //         return ArrayHelper::getColumn(Takaran::getData($search), 'tak_nama');
    //     }
    //     return []; 
    // }
    // public function actionWaktuPenggunaan($search=null) {
    //     if(\Yii::$app->request->isAjax) {
    //         \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    //         return ArrayHelper::getColumn(WaktuPenggunaan::getData($search), 'wak_nama');
    //     }
    //     return []; 
    // }
    public function actionMasalahKeperawatan($search=null){
        $items=MasalahKeperawatan::getDataQuery($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'text');
            return MakeResponse::create(true, 'Data Masalah Keperawatan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Masalah Keperawatan Tidak Ditemukan');
    }
    public function actionIntervensiKeperawatan($search=null){
        $items=IntervensiKeperawatan::getDataQuery($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'text');
            return MakeResponse::create(true, 'Data Masalah Keperawatan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Masalah Keperawatan Tidak Ditemukan');
    }
    public function actionProblemGizi($search=null){
        $items=ProblemGizi::getData($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'text');
            return MakeResponse::create(true, 'Data Masalah Keperawatan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Masalah Keperawatan Tidak Ditemukan');
    }
    public function actionEtiologiGizi($search=null){
        $items=EtiologiGizi::getData($search);
        if($items){
            $items = ArrayHelper::getColumn($items, 'etg_nama');
            return MakeResponse::create(true, 'Data Masalah Keperawatan Tersedia',$items);
        }
        return MakeResponse::create(false, 'Data Masalah Keperawatan Tidak Ditemukan');
    }
    // public function actionGetItemRacikan(){
    //     if(\Yii::$app->request->isAjax) {
    //         \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
    //         return ArrayHelper::getColumn(Barang::find()->searchItem(strtolower(Yii::$app->request->get('keys')))->all(), 'nama_barang');
    //     }
    //     return false;    
    // }
}