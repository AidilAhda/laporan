<?php
namespace app\controllers;

use app\models\DistribusiLangsung;
use app\models\DistribusiLansungDetail;
use app\models\Pemesanan;
use app\models\Penerimaan;
use app\models\PenerimaanDetail;
use yii\db\Expression;
use app\models\Pengaturan;
use Yii;
use app\models\Pemeseanan;
use app\models\Penjualan;
use app\models\PenjualanSubDetail;
use app\models\ReturRuangan;
use app\models\Resep;
use app\models\StockDepo;
use app\models\TransaksiBarang;
use app\widgets\AuthUser;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Mpdf\Mpdf;
use yii\web\NotFoundHttpException;
class LaporanController extends Controller
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
                ]
            ]
        ];
    }
    
    
    public function actionIndex()
    {
       
        return $this->render('index');
    }

    public function actionLaporanPersediaan(){
        $laporan = \Yii::$app->request->post('persediaan',false);

        $start=date('Y-m-d H:i:s',strtotime($laporan['date-start'].' 00:00:01'));
        $end=date('Y-m-d H:i:s',strtotime($laporan['date-end'].' 23:59:59'));
        $model=TransaksiBarang::find()
                ->joinWith(['barang'=>function($q){
                    $q->joinWith(['satuan','sumberdana']);
                }])
                ->andWhere(['tra_asal'=>AuthUser::user()->depo_id])
                ->andWhere(['between','tra_created_at',$start,$end])
                ->groupBy('tra_bar_id')
                ->select([
                    'stok_awal'=>TransaksiBarang::find()
                    ->andWhere(['tra_asal'=>AuthUser::user()->depo_id])
                    ->andWhere('farmasi_transaksi_barang.tra_bar_id=a.tra_bar_id')
                    ->andWhere(['between','tra_created_at',$start,$end])->orderBy(['tra_created_at'=>SORT_ASC])->limit(1)->select(['tra_stok_depo']),
                    'stok_akhir'=>TransaksiBarang::find()
                    ->andWhere(['tra_asal'=>AuthUser::user()->depo_id])
                    ->andWhere('farmasi_transaksi_barang.tra_bar_id=a.tra_bar_id')
                    ->andWhere(['between','tra_created_at',$start,$end])->orderBy(['tra_created_at'=>SORT_DESC])->limit(1)->select(['tra_stok_akhir']),
                    'penerimaan_depo'=>TransaksiBarang::find()
                    ->andWhere(['tra_jenis_transaksi'=>'distribusi keluar'])
                    ->andWhere(['not',['tra_asal'=>Pengaturan::find()->where(['pgtr_id'=>'1'])->select(['pgtr_gudang_id'])]])
                    ->andWhere('farmasi_transaksi_barang.tra_transaksi_id=a.tra_transaksi_id')
                    ->select([ new Expression('SUM(tra_keluar)')]),
                    'pengeluaran_depo'=>TransaksiBarang::find()
                    ->andWhere(['tra_jenis_transaksi'=>'distribusi keluar'])
                    ->andWhere(['tra_asal'=>AuthUser::user()->depo_id])
                    ->andWhere('farmasi_transaksi_barang.tra_bar_id=a.tra_bar_id')
                    
                    ->select([new Expression('SUM(tra_keluar)')]),
                    'pengeluaran_pasien'=>TransaksiBarang::find()
                    ->andWhere(['tra_jenis_transaksi'=>'penjualan'])
                    ->andWhere('farmasi_transaksi_barang.tra_bar_id=a.tra_bar_id')
                    ->andWhere(['tra_asal'=>AuthUser::user()->depo_id])
                    
                    ->select([new Expression('SUM(tra_keluar)')]),
                    'penerimaan_gudang'=>TransaksiBarang::find()
                    ->andWhere(['tra_jenis_transaksi'=>'distribusi keluar'])
                    ->andWhere(['tra_asal'=>Pengaturan::find()->where(['pgtr_id'=>'1'])->select(['pgtr_gudang_id'])])
                    ->andWhere('farmasi_transaksi_barang.tra_transaksi_id=a.tra_transaksi_id')
                    ->select([new Expression('SUM(tra_keluar)')]),
                    new Expression('SUM(tra_masuk) as total_masuk'),new Expression('SUM(tra_keluar) as total_keluar'),'bar_sud_id','bar_sat_id','tra_bar_id','bar_nama'])
                    ->alias('a')
                    ->asArray()
                    ->all();
      

        $filename='persediaan.xlsx';
        header("Content-Disposition: attachment; filename=\"$filename\"");
       \moonland\phpexcel\Excel::widget([
        'models' => $model,
        'mode' => 'export', //default value as 'export'
        'columns' => [
        
        [
            'attribute'=>'barang',
            'header'=>'Nama Barang',
            'value'=>function($model){
                return $model['barang']['bar_nama'];

            }
        ],      
        [
            'attribute'=>'satuan',
            'header'=>'Satuan',
            'value'=>function ($model){
                return $model['barang']['satuan']['sat_nama'];
            }

        ],
        [
            'attribute'=>'asal',
            'header'=>'Asal Barang',
            'value'=>function ($model){
                return $model['barang']['sumberdana']['sud_nama'];

            }

        ],
       
        [
            'attribute'=>'stok_awal',
            'header'=>'Stok Awal',
            'value'=>function ($model){
                return $model['stok_awal'];

            }

        ],
        [
            'attribute'=>'penerimaan_depo',
            'header'=>'Penerimaan dari Depo',
            'value'=>function ($model){
                return $model['penerimaan_depo'];

            }

        ],
        [
            'attribute'=>'penerimaan_gudang',
            'header'=>'Penerimaan dari Gudang',
            'value'=>function ($model){
                return $model['penerimaan_gudang'];

            }

        ],

        [
            'attribute'=>'pengeluaran_depo',
            'header'=>'Pengeluaran ke Depo',
            'value'=>function ($model){
                return $model['pengeluaran_depo'];

            }

        ],

        [
            'attribute'=>'pengeluaran_pasien',
            'header'=>'Pengeluaran ke Pasien',
            'value'=>function ($model){
                return $model['pengeluaran_pasien'];

            }

        ],
        [
            'attribute'=>'stok_akhir',
            'header'=>'Stok Akhir',
            'value'=>function ($model){
                return $model['stok_akhir'];

            }

        ],
        [
            'attribute'=>'total_masuk',
            'header'=>'Total Masuk',
            'value'=>function ($model){
                return $model['total_masuk'];

            }

        ],
        [
            'attribute'=>'total_keluar',
            'header'=>'Total Keluar',
            'value'=>function ($model){
                return $model['total_keluar'];

            }

        ],
        
       
    
      

       
       
    ], //without header working, because the header will be get label from attribute label. 
       
    ]);
    
   }
    

   public function actionLaporanpenjualan(){

    $laporan = \Yii::$app->request->post('penjualan',false);

    $start=date('Y-m-d H:i:s',strtotime($laporan['date-start'].' 00:00:01'));
    $end=date('Y-m-d H:i:s',strtotime($laporan['date-end'].' 23:59:59'));
    $model= PenjualanSubDetail::find()->joinWith(['penjualandetail', 'penjualandetail.penjualan', 'barang'])->where(['between','pnj_created_at',$start,$end])->andWhere(['pnj_status' => 'diserahkan'])->andWhere('pnj_deleted_at is null')->andwhere(['pnj_depo_id'=>AuthUser::user()->depo_id])->orderBy(['bar_nama' => SORT_ASC])->all();
   
    $filename='penjualan.xlsx';
        header("Content-Disposition: attachment; filename=\"$filename\"");
       \moonland\phpexcel\Excel::widget([
        'models' => $model,
        'mode' => 'export', //default value as 'export'
        'columns' => [
        
        [
            'attribute'=>'barang',
            'header'=>'Nama Barang',
            'value'=>function($model){
                return $model->barang->bar_nama;

            }
        ],      
        [
            'attribute'=>'satuan',
            'header'=>'Satuan',
            'value'=>function ($model){
                return $model->barang->satuan->sat_nama;
            }

        ],
        [
            'attribute'=>'asal',
            'header'=>'Asal Barang',
            'value'=>function ($model){
                return $model->barang->sumberdana->sud_nama;
            }

        ],
        [
            'attribute'=>'kelompok',
            'header'=>'Kelompok Barang',
            'value'=>function ($model){
                return (isset($model->barang->kelompok))?$model->barang->kelompok->kel_nama:'-';
            }

        ],
        [
            'attribute'=>'Golongan',
            'header'=>'Golongan Barang',
            'value'=>function ($model){
                return (isset($model->barang->golongan))?$model->barang->golongan->gol_nama:'-';
            }
        ],
//        [
//            'attribute'=>'Nama_Pasien',
//            'header'=>'Nama Pasien',
//            'value'=>function ($model){
//                return $model->penjualandetail->penjualan->pjd_nama_pasien ? $model->penjualandetail->penjualan->pjd_nama_pasien  : '';
//            }
//        ],

        'pens_jumlah',
        'pens_biaya_layanan',
        'pens_harga_jual',
        'pens_harga_satuan',
        'pens_subtotal',

       
       
    ], //without header working, because the header will be get label from attribute label. 
        'headers' => ['pens_jumlah' => 'Jumlah', 'pens_harga_satuan' => 'Harga Satuan','pens_subtotal'=>'Subtotal','pens_harga_jual'=>'Harga Jual','pens_biaya_layanan'=>'Biaya Layanan'], 
    ]);
    
   }


   public function actionLaporanpenerimaan(){

    $penerimaan = \Yii::$app->request->post('penerimaan',false);
 
    $start=date('Y-m-d H:i:s',strtotime($penerimaan['date-start'].' 00:00:01'));
    $end=date('Y-m-d H:i:s',strtotime($penerimaan['date-end'].' 23:59:59'));
    $model= PenerimaanDetail::find()->where(['between','pend_created_at',$start,$end])->andWhere([])->all();   
   
    $filename='penerimaan.xlsx';
        header("Content-Disposition: attachment; filename=\"$filename\"");
       \moonland\phpexcel\Excel::widget([
        'models' => $model,
        'mode' => 'export', //default value as 'export'
        'columns' => [
        'pend_created_at',
        [
            'attribute'=>'distributor',
            'header'=>'Distributor',
            'value'=>function($model){
                return (isset($model->penerimaan))?$model->penerimaan->supplier->sup_nama :'-';
            }
        ], 
        
        [
            'attribute'=>'penerimaan',
            'header'=>'Nomor Faktur ',
            'value'=>function($model){
                return (isset($model->penerimaan))?$model->penerimaan->pen_no_faktur :'-';
            }
        ], 
        [
            'attribute'=>'barang',
            'header'=>'Nama Barang',
            'value'=>function($model){
                return $model->barang->bar_nama;

            }
        ],      
        [
            'attribute'=>'satuan',
            'header'=>'Satuan',
            'value'=>function ($model){
                return $model->barang->satuan->sat_nama;
            }

        ],
        [
            'attribute'=>'asal',
            'header'=>'Sumber Dana',
            'value'=>function ($model){
                return $model->barang->sumberdana->sud_nama;
            }

        ],
        [
            'attribute'=>'kelompok',
            'header'=>'Kelompok Barang',
            'value'=>function ($model){
                return (isset($model->barang->kelompok))?$model->barang->kelompok->kel_nama:'-';
            }

        ],
        [
            'attribute'=>'Golongan',
            'header'=>'Golongan Barang',
            'value'=>function ($model){
                return (isset($model->barang->golongan))?$model->barang->golongan->gol_nama:'-';
            }

        ],
        'pend_jumlah',
        'pend_harga_satuan',
        'pend_diskon',
        'pend_subtotal',

       
       
    ], //without header working, because the header will be get label from attribute label. 
        'headers' => ['pend_created_at'=>'Tanggal','pend_jumlah' => 'Jumlah', 'pend_harga_satuan' => 'Harga Satuan','pend_subtotal'=>'Subtotal','pend_diskon'=>'Diskon'], 
    ]);
    
   }



   public function actionLaporanpenerimaandepo(){
    $laporan = \Yii::$app->request->post('laporan',false);
    $start=date('Y-m-d H:i:s',strtotime($laporan['date-start'].' 00:00:01'));
    $end=date('Y-m-d H:i:s',strtotime($laporan['date-end'].' 23:59:59'));
    $subQuery = ArrayHelper::getColumn(DistribusiLangsung::find()->select(['dis_id'])->where(['between','dis_created_at',$start,$end])->andWhere(['dis_gud_tujuan_id'=>AuthUser::user()->depo_id])->asArray()->all(),'dis_id');  
    $model= DistribusiLansungDetail::find()->where(['IN','dld_dis_id',$subQuery])->all();
    $filename='penerimaandepo'.$laporan['date-start'].'-'.$laporan['date-end'].'.xlsx';
        header("Content-Disposition: attachment; filename=\"$filename\"");
       \moonland\phpexcel\Excel::widget([
        'models' => $model,
        'mode' => 'export', //default value as 'export'
        'columns' => [  
            [
                'attribute'=>'tujuan',
                'header'=>'Depo Pengirim',
                'value'=>function ($model){
                    return $model->distribusi->tujuan->unt_nama;
                }
    
            ],      
        [
            'attribute'=>'barang',
            'header'=>'Nama Barang',
            'value'=>function($model){
                return $model->barang->bar_nama;
            }
        ],      
        [
            'attribute'=>'satuan',
            'header'=>'Satuan',
            'value'=>function ($model){
                return $model->barang->satuan->sat_nama;
            }

        ],
        [
            'attribute'=>'asal',
            'header'=>'Asal Barang',
            'value'=>function ($model){
                return $model->barang->sumberdana->sud_nama;
            }

        ],
        [
            'attribute'=>'kelompok',
            'header'=>'Kelompok Barang',
            'value'=>function ($model){
                return (isset($model->barang->kelompok))?$model->barang->kelompok->kel_nama:'-';
            }

        ],
        [
            'attribute'=>'Golongan',
            'header'=>'Golongan Barang',
            'value'=>function ($model){
                return (isset($model->barang->golongan))?$model->barang->golongan->gol_nama:'-';
            }

        ],
        'dld_jumlah_diberi',
        'dld_harga_satuan',
        'pens_subtotal',       
    ], //without header working, because the header will be get label from attribute label. 
        'headers' => ['dld_jumlah_diberi' => 'Jumlah Pengiriman', 'dld_harga_satuan' => 'Harga Satuan','dld_subtotal'=>'Subtotal'], 
    ]);
    
   }


   public function actionLaporanpengirimandepo(){
    $pengiriman = \Yii::$app->request->post('pengiriman',false);
    $start=date('Y-m-d H:i:s',strtotime($pengiriman['date-start'].' 00:00:01'));
    $end=date('Y-m-d H:i:s',strtotime($pengiriman['date-end'].' 23:59:59'));
    $subQuery = ArrayHelper::getColumn(DistribusiLangsung::find()->select(['dis_id'])->where(['between','dis_created_at',$start,$end])->andWhere(['dis_gud_asal_id'=>AuthUser::user()->depo_id])->asArray()->all(),'dis_id');  
    $model= DistribusiLansungDetail::find()->where(['IN','dld_dis_id',$subQuery])->all();
    $filename='pengiriman'.$pengiriman['date-start'].'-'.$pengiriman['date-end'].'.xlsx';
        header("Content-Disposition: attachment; filename=\"$filename\"");
       \moonland\phpexcel\Excel::widget([
        'models' => $model,
        'mode' => 'export', //default value as 'export'
        'columns' => [  
            [
                'attribute'=>'tujuan',
                'header'=>'Unit Penerima',
                'value'=>function ($model){
                    return $model->distribusi->tujuan->unt_nama;
                }
    
            ],      
        [
            'attribute'=>'barang',
            'header'=>'Nama Barang',
            'value'=>function($model){
                return $model->barang->bar_nama;
            }
        ],      
        [
            'attribute'=>'satuan',
            'header'=>'Satuan',
            'value'=>function ($model){
                return $model->barang->satuan->sat_nama;
            }

        ],
        [
            'attribute'=>'asal',
            'header'=>'Asal Barang',
            'value'=>function ($model){
                return $model->barang->sumberdana->sud_nama;
            }

        ],
        [
            'attribute'=>'kelompok',
            'header'=>'Kelompok Barang',
            'value'=>function ($model){
                return (isset($model->barang->kelompok))?$model->barang->kelompok->kel_nama:'-';
            }

        ],
        [
            'attribute'=>'Golongan',
            'header'=>'Golongan Barang',
            'value'=>function ($model){
                return (isset($model->barang->golongan))?$model->barang->golongan->gol_nama:'-';
            }

        ],
        'dld_jumlah_diberi',
        'dld_harga_satuan',
        'dld_subtotal',

       
       
    ], //without header working, because the header will be get label from attribute label. 
        'headers' => ['dld_jumlah_diberi' => 'Jumlah Pengiriman', 'dld_harga_satuan' => 'Harga Satuan','dld_subtotal'=>'Subtotal'], 
    ]);
    
   }

   
}