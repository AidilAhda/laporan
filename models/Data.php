<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\PendaftaranPasien;
use app\models\PendaftaranLayanan;
use app\models\PendaftaranBiayaRawatjalan;
use app\models\MedisMTarifTindakanUnit;
use app\models\EbsMMenu;
use app\models\EbsBiayaAmbulance;
use app\models\SdmMPegawai;

use app\models\EbsNaikKelas;
use app\widgets\AuthUser;
use app\models\MedisMTarifKamar;

class Data extends Model
{
    //Dashboard
 	public function getLabel7Days()
    {
    	$date = date('Y-m-d');
    	$Data = [
    		date('d/m/Y', strtotime($date. '-6 day')),
    		date('d/m/Y', strtotime($date. '-5 day')),
    		date('d/m/Y', strtotime($date. '-4 day')),
    		date('d/m/Y', strtotime($date. '-3 day')),
    		date('d/m/Y', strtotime($date. '-2 day')),
    		date('d/m/Y', strtotime($date. '-1 day')),
    		date('d/m/Y', strtotime($date)),
    	];
        return $Data;
    }

    public static function getNamaUser($IdUser)
    {

        $User = SdmMPegawai::find()
            ->select(['*'])
            ->andWhere(['pgw_id'=>$IdUser])
            ->asArray()
            ->one();

        if($User != Null) {
            return $User['pgw_gelar_depan'].' '.$User['pgw_nama'].' '.$User['pgw_gelar_belakang'];
        } else {
            return '-';
        }
    }

	public function getDataPasien ()
	{
		
		$Data = PendaftaranPasien::find()
		->select(['ps_jkel', 'count(*) as Jumlah'])
		->groupBy(['ps_jkel'])
		->asArray()
		->all();

		return array(
			'Total' => $Data[0]['Jumlah'] + $Data[1]['Jumlah'],
			'L' => $Data[0]['Jumlah'],
			'P' => $Data[1]['Jumlah']
		);
	}

    public function getDataDashboard()
    {
        $begin = date('Y-m-d').' 00:00:01';
        $end = date('Y-m-d').' 23:59:59';

        $DataPembayaran = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['between','byr_tanggal', $begin, $end])
        ->andWhere('byr_deleted_at is null')->asArray()->limit(6)->all();

        $DataPlafon = EbsPembayaranPlafon::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['between','byp_tanggal', $begin, $end])
        ->andWhere('byp_deleted_at is null')->asArray()->limit(6)->all();

        return array(
            'DataPembayaran' => $DataPembayaran,
            'DataPlafon' => $DataPlafon
        );
    }

    // End Dashboard

    public function getDataKamar($NoDaftar, $intesif)
    {
        $Query = PendaftaranLayanan::find()
        ->joinWith([
            'kelas',
            'kamar'=>function($q) {
                $q->joinWith(['tarifkamar'], true);
            },
            'unit'
        ],true)
        ->andWhere(['pl_reg_kode'=>$NoDaftar,'pl_jenis_layanan'=>3]);
        
        
        if ($intesif) {
            $Query->andWhere(['LIKE','kr_nama','INTENSIF' ]);
        }else{
            $Query->andWhere(['NOT LIKE','kr_nama','INTENSIF' ]);            
        }

        $Query->andWhere('pl_deleted_at is null');


        $Query->asArray();
        $Data = $Query->all();        

        return $Data;
    }

    // Monitoring
    public function getDataMonitoring($tgl_mulai, $tgl_selesai, $Debitur, $Layanan, $unit)
    {
        if(!empty($tgl_mulai) && !empty($tgl_selesai)) {
            $tgl_selesai = $tgl_selesai;
            $tgl_mulai = $tgl_mulai;
        } else {
            $tgl_selesai = date("Y-m-d ");
            $tgl_mulai = date("Y-m-d ");
        }
        $begin = date('Y-m-d', strtotime($tgl_mulai)).' 00:00:01';
        $end = date('Y-m-d', strtotime($tgl_selesai)).' 23:59:59';

        $Query = PendaftaranLayanan::find()
        ->joinWith([
            'kelas',
            'kamar',
            'unit'
        ],true)
        ->andWhere(['between','pl_tgl_masuk', $begin, $end]);

        if($Debitur == 'S') {
            $Query->joinWith([
                'registrasi'=>function($q){
                    $q->joinWith(['pasien', 'pasienluar', 'kirimandetail','debiturdetail'],true);
                },
            ],true); 
        } else {
            $Query->joinWith([
                'registrasi'=>function($q) use($Debitur){
                    $q->joinWith(['pasien', 'pasienluar', 'kirimandetail','debiturdetail'])->where(['reg_pmdd_kode'=>$Debitur]);
                }
            ],true);    
        }
        if($unit != 0){
            $Query->andWhere(['pl_unit_kode' => $unit]);
        }

        if($Layanan != 0) {
            $Query->andWhere(['pl_jenis_layanan'=>$Layanan]);   
        } 
              
        $Query->asArray();
        $Data = $Query->all();

        return $Data;
    }
    // End Monitoring

    public function getBiodataPasien($NoPasien)
    {
        $Cek = substr($NoPasien, 0, 1);

        if($Cek == 'L') {
            $model = new PendaftaranPasienLuar();
            $Biodata = $model->biodataPasienLuar($NoPasien);
        } else {
            $model = new PendaftaranPasien();
            $Biodata = $model->biodataPasien($NoPasien);
        }

        return $Biodata;
    }

    public function getSesiLoket()
    {
        $idLoket = \Yii::$app->session->get(
            Yii::$app->id.DIRECTORY_SEPARATOR.EbsAksesLoket::PARAM_LOKET);
        
        $Data = EbsMLoketPembayaran::find()
        ->andWhere(['lob_id'=>$idLoket])
        ->asArray()
        ->one();

        return $Data;
    }

    public function getSesiShift()
    {
        $idShift = Yii::$app->session->get(
            "SHIFT".Yii::$app->id.DIRECTORY_SEPARATOR.EbsAksesLoket::PARAM_LOKET
        );
        
        $Data = EbsMShift::find()
        ->andWhere(['shf_id'=>$idShift])
        ->asArray()
        ->one();

        return $Data;
    }


    public static function getTerbilang($Nominal)
    {
        return self::rupiah($Nominal);
    
    }

    // Setting Menu index_menu
    public function getMenuDefault()
    {
        $menu = new EbsMMenu();
        $Menu = $menu->getMainMenu();

        $MenuDefault = '';
        if($Menu != Null) {
            foreach ($Menu as $m) {
                if($m['mnu_aktif'] == 1) {
                    $MenuDefault .= '<li class="active btn-menu-aktif" id="menu-'.$m['mnu_variabel'] .'"><a href=""><i class="'.$m['mnu_icon'].'"></i> '. $m['mnu_nama'] .'</a></li>';
                } else {
                    $MenuDefault .= '<li class="btn-menu-nonaktif"><a href="#"><i class="'.$m['mnu_icon'].'"></i>'.$m['mnu_nama'].'
                </a></li>';
                }
            }
        } else {
            $MenuDefault .= '<li class="btn-menu-nonaktif"><a href="#">Menu Tidak Tersedia</a></li>';
        }

        return $MenuDefault;
    }

    public function getNonActiveAllMenu()
    {
        $menu = new EbsMMenu();
        $Menu = $menu->getMainMenu();

        $MenuNonActive = '';
        if($Menu != Null) {
            foreach ($Menu as $m) {
                $MenuNonActive .= '<li class="btn-menu-nonaktif"><a href="#"><i class="'.$m['mnu_icon'].'"></i>'.$m['mnu_nama'].'
                </a></li>';
            }
        } else {
            $MenuNonActive .= '<li class="btn-menu-nonaktif"><a href="#">Menu Tidak Tersedia</a></li>';
        }

        return $MenuNonActive;
    }

    // End Setting Menu index_menu

	public function dataRegistrasi($NoPasien, $NoDaftar)
	{
		
		$Data = PendaftaranRegistrasi::find()
        ->joinWith(['debiturdetail','kirimandetail'])
		->andWhere(['reg_pasien_kode'=> $NoPasien, 'reg_kode'=>$NoDaftar])
		->asArray()
		->one();

		return $Data;
	}

    public function getDataLayanan($NoPasien, $NoDaftar)
    {
        // Rawat Inap

        $RawatInap=PendaftaranLayanan::find()->joinWith([
            'unit',
            'registrasi'=>function($q) use($NoPasien, $NoDaftar){
                $q->joinWith(['pasien','kirimandetail','debiturdetail'])->where(['reg_pasien_kode'=>$NoPasien, 'reg_kode'=>$NoDaftar]);
            },
            'kamar',
            'kelas'
        ])
        ->andWhere(['pl_jenis_layanan'=>3])->notDeleted(PendaftaranLayanan::$prefix)->orderBy(['pl_tgl_masuk'=>SORT_DESC])->asArray()->all();
		

        // Rawat Jalan

          $RawatJalan=PendaftaranLayanan::find()->joinWith([
            'unit',
            'registrasi'=>function($q) use($NoPasien, $NoDaftar){
                $q->joinWith(['pasien','kirimandetail','debiturdetail'])->where(['reg_pasien_kode'=>$NoPasien, 'reg_kode'=>$NoDaftar]);
            },
            'kamar',
            'kelas'
        ])
        ->andWhere(['pl_jenis_layanan'=>['or', 1, 2]])->notDeleted(PendaftaranLayanan::$prefix)->orderBy(['pl_tgl_masuk'=>SORT_DESC])->asArray()->all();

        return Array('RawatInap' =>$RawatInap, 'RawatJalan'=>$RawatJalan);
    }

    public function dataTindakanPasien($NoDaftar)
    {
        
        // $data = PendaftaranLayanan::find()
        // ->joinWith([
        //     'unit',
        //     'kelas',
        //     'tindakan'=>function($q) {
        //         $q->joinWith([
        //             'tarifTindakan',
        //             'user'
        //         ])->andWhere('tdp_deleted_at is null');
        //     }
        // ])
        // ->andWhere(['pl_reg_kode'=>$NoDaftar])
        // ->andWhere('pl_deleted_at is null')
        // ->orderBy(['pl_tgl_masuk'=>SORT_DESC])
        // ->asArray()->all();

        $data = MedisTindakanPasien::find()
        ->joinWith([
            'layanan'=>function($q) use($NoDaftar){
                $q->joinWith(['unit','kelas'])->andwhere(['pl_reg_kode'=>$NoDaftar])
                ->andWhere('pl_deleted_at is null');
            },
            'user',
            'tarifTindakan'=>function($q) {
                $q->joinWith(['tindakan']);
            },
        ])
        ->andWhere('tdp_deleted_at is null')
        ->asArray()->all();

        return $data;
    }
	
	public function dataKelompokTindakanPasien($NoDaftar)
    {
        
        // $data = PendaftaranLayanan::find()
        // ->joinWith([
        //     'unit',
        //     'kelas',
        //     'tindakan'=>function($q) {
        //         $q->joinWith([
        //             'tarifTindakan',
        //             'user'
        //         ])->andWhere('tdp_deleted_at is null');
        //     }
        // ])
        // ->andWhere(['pl_reg_kode'=>$NoDaftar])
        // ->andWhere('pl_deleted_at is null')
        // ->orderBy(['pl_tgl_masuk'=>SORT_DESC])
        // ->asArray()->all();

        $data = MedisTindakanPasien::find()
		->select(['medis_tindakan_pasien.*', 'medis_m_tindakan.tdk_deskripsi as namaTindakan','medis_m_tindakan.tdk_parent_id as parentTindakan', 'sum(medis_tindakan_pasien.tdp_subtotal) as jumlah'])
		// ->select(['medis_tindakan_pasien.*', 'medis_m_tindakan.tdk_deskripsi as namaTindakan', 'medis_m_tindakan.tdk_parent_id as parentTindakan', 'sdm_m_unit.unt_nama as namaUnit','sdm_m_pegawai.pgw_nama as namaPengguna'])
        ->joinWith([
            'layanan'=>function($q) use($NoDaftar){
                $q->joinWith(['unit','kelas'])->andwhere(['pl_reg_kode'=>$NoDaftar])
                ->andWhere('pl_deleted_at is null');
            },
            'user',
            'tarifTindakan'=>function($q) {
                $q->joinWith([
					'tindakan'
				]); 
            },
        ], false)
		->groupBy(['parentTindakan'])
        ->andWhere('tdp_deleted_at is null')
        ->asArray()->all();

        return $data;
    }

    public function getDataBiayaRawatInap($NoDaftar)
    {
        // Cek Data Biaya Rawat Inap
        // Kode Jenis Layanan Rawat Inap = 3

        $tanggal_masuk = Null;
        $tanggal_keluar= Null;
        $total_biaya = 0;
        $selisih = Null;
		$biayaPerHari = 0;

        $cekRawatInap = PendaftaranLayanan::find()
        ->joinWith(['unit','kelas','kamar'])
        ->andWhere(['pl_reg_kode'=>$NoDaftar, 'pl_jenis_layanan'=> 3])
        ->andWhere('pl_deleted_at is null')
        ->asArray()->all();
		
        if($cekRawatInap != Null) {
			
			foreach($cekRawatInap as $d) {
				
				$biayaKamar = MedisMTarifKamar::find()
				->andWhere(['tkr_kmr_id'=>$d['pl_kamar_id']])
				->andwhere('tkr_deleted_at is null')
				->asArray()->one();
				
				if($biayaKamar != null) {
					$biayaPerHari = $biayaKamar['tkr_biaya'];
				}
				
				if($d['pl_tgl_keluar'] != Null) {
                // Status sudah cekout
                $status = 2;
                $ket = "Sudah Cekout";
                $tanggal_masuk = date('d-m-Y H:i', strtotime($d['pl_tgl_masuk']));
                $tanggal_keluar= date('d-m-Y H:i', strtotime($d['pl_tgl_keluar']));

                $selisih = date_diff(date_create($d['pl_tgl_keluar']), date_create($d['pl_tgl_masuk']));
				$jumlah_hari = $selisih->d;
				
				$totalbiaya = $jumlah_hari*$biayaPerHari;
				

				} else {
					// Status belum cekout
					$status = 1;
					$ket = "Belum Cekout Rawat Inap";
					$tanggal_masuk = date('d-m-Y H:i', strtotime($d['pl_tgl_masuk']));
					$tanggal_keluar= Null;
					$tanggal_hari_ini= date('d-m-Y H:i');
					
					$selisih = date_diff(date_create($tanggal_hari_ini), date_create($d['pl_tgl_masuk']));
					$jumlah_hari = $selisih->d;
					
					$totalbiaya = $jumlah_hari*$biayaPerHari;
						
				}
				$total_biaya += $totalbiaya;
			}
			
        } else {
            // Status bukan rawat inap
            $status = 0;
            $ket = "Bukan Rawat Inap";
        }

         return [
            'status_rawatinap'=>$status,
            'keterangan_status'=>$ket,
			'biaya_perhari'=>$biayaPerHari,
            'total_biaya'=>$total_biaya,
            'tanggal_masuk' => $tanggal_masuk,
            'tanggal_keluar'=>$tanggal_keluar,
            'selisih' => $selisih,
            'data_rawatinap'=>$cekRawatInap
        ];

    }
	
	public function getDataBiayaAmbulance($NoDaftar)
    {
        // Cek Data Biaya Ambulance 
        // Table ebs_biaya_ambulance

        $cekAmbulance = EbsBiayaAmbulance::find()
        ->andWhere(['bynce_reg_kode'=>$NoDaftar])
        ->andWhere('bynce_deleted_at is null')
        ->asArray()->all();

        $total_biaya = 0;
        if($cekAmbulance != null) {
            foreach ($cekAmbulance as $data) {
                $total_biaya += $data['bynce_biaya'];
            }
        }

         return [
            'total_biaya'=>$total_biaya,
            'data_ambulance'=>$cekAmbulance
        ];

    }

    public function getDataKamarVedika($NoDaftar)
    {
        $data = null;
        $total = 0;

        $data = PendaftaranLayanan::find()->where(['pl_reg_kode'=>$NoDaftar, 'pl_jenis_layanan' => 3])->asArray()->all();

        return[
            'data'=>$data,
            'total' => $total
        ];
    }
    public function getDataVedika($NoDaftar, $IdTdkVdk)
    {
        $total = 0;
        $data = Null;

        $data = MedisTindakanPasien::find()
        ->joinWith([
            'layanan'=>function($q) use($NoDaftar){
                $q->joinWith(['unit','kelas'])->andwhere(['pl_reg_kode'=>$NoDaftar])
                ->andWhere('pl_deleted_at is null');
            },
            'user',
            'tarifTindakan'=>function($q) use($IdTdkVdk) {
                $q->joinWith(['tindakan'])->andWhere(['tdk_tdvdk_id'=> $IdTdkVdk]);
            },
        ])        
        //  ->andWhere(['NOT', ['tdp_tft_id'=>$id_tindregis]])
        ->andWhere('tdp_deleted_at is null')
        ->orderBy('tdk_deskripsi')
        ->asArray()->all();
        if($data != Null) {
            foreach ($data as $t) {
                $total += $t['tdp_subtotal'];
            }
        }

        return [
            'total' => $total,
            'data' =>$data
        ];
    }    

    public function getDataBiayaTindakan($NoDaftar)
    {
        // Pemisahan antara biaya registrasi dengan biaya tindakan pasien
        // Biaya Pendaftaran di cek dari tabel pendaftaranbiayarawatjalan
        $total_registrasi = 0;
        $data_registrasi = Null;
        $total_tindakan = 0;
        $data_tindakan = Null;

        //$biaya_rawatjalan = PendaftaranBiayaRawatjalan::find()
        //->select(['pbr_tft_id'])
        //->andWhere('pbr_deleted_at is null')
        //->distinct()->asArray()->all();
		
		$biaya_rawatjalan = MedisMTarifTindakanUnit::find()
		->select(['ttu_tarif_tindakan_id'])
		->andWhere(['ttu_jenis_tindakan'=>1])
		->andWhere('ttu_deleted_at is null')
		->distinct()->asArray()->all();
		

        if($biaya_rawatjalan != Null) {
            $id_tindregis = '';
            foreach($biaya_rawatjalan as $d) {
                $id_tindregis .= $d['ttu_tarif_tindakan_id'].',';
            }

            $data_registrasi = MedisTindakanPasien::find()
            ->joinWith([
                'layanan'=>function($q) use($NoDaftar){
                    $q->joinWith(['unit','kelas'])->andwhere(['pl_reg_kode'=>$NoDaftar])
                    ->andWhere('pl_deleted_at is null');
                },
                'user',
                'tarifTindakan'=>function($q) {
                    $q->joinWith(['tindakan']);
                },
            ])
			->where('tdp_tft_id IN (SELECT ttu_tarif_tindakan_id from medis_m_tarif_tindakan_unit where ttu_jenis_tindakan=1 and ttu_deleted_at is null)')
           // ->andWhere(['IN', 'tdp_tft_id', $id_tindregis])
            ->andWhere('tdp_deleted_at is null')
            ->asArray()->all();


            if($data_registrasi != Null) {
                foreach ($data_registrasi as $b) {
                    $total_registrasi += $b['tdp_subtotal'];
                }
            }

            $data_tindakan = MedisTindakanPasien::find()
            ->joinWith([
                'layanan'=>function($q) use($NoDaftar){
                    $q->joinWith(['unit','kelas'])->andwhere(['pl_reg_kode'=>$NoDaftar])
                    ->andWhere('pl_deleted_at is null');
                },
                'user',
                'tarifTindakan'=>function($q) {
                    $q->joinWith(['tindakan']);
                },
            ])
			->where('tdp_tft_id NOT IN (SELECT ttu_tarif_tindakan_id from medis_m_tarif_tindakan_unit where ttu_jenis_tindakan=1 and ttu_deleted_at is null)')
           //  ->andWhere(['NOT', ['tdp_tft_id'=>$id_tindregis]])
            ->andWhere('tdp_deleted_at is null')
            ->asArray()->all();

            if($data_tindakan != Null) {
                foreach ($data_tindakan as $t) {
                    $total_tindakan += $t['tdp_subtotal'];
                }
            }
        }
        return [
            'total_registrasi'=>$total_registrasi,
            'data_registrasi'=>$data_registrasi,
            'total_tindakan' => $total_tindakan,
            'data_tindakan' =>$data_tindakan
        ];
    }


	public function cekPembayaranObat($notran)
    {

        $kode = 3;  // Kode Menu Pembayaran Obat byr_kob_id = 3
        
        $Data = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['byr_no_transaksi' => $notran])
        ->andWhere(['byr_kob_id'=>$kode])
        ->andWhere('byr_deleted_at is null')->asArray()->one();

        return $Data;
    }

    public function dataPenjualanObat($date)
    {
        $api = new Status();

        $url_farmasi = "http://farmasi.rsudbangkinang.kamparkab.go.id/web/api/penjualanbydate?date=".$date;
        $dataPenjualan = $api->getApi($url_farmasi);

        if($dataPenjualan['code'] == 200) {
            return $dataPenjualan['result'];
        } else {
            return Null;
        }
    }

    public function dataObatById($id)
    {
        $api = new Status();

        $url_farmasi = "http://192.168.4.10/farmasi/web/api/penjualanbyid/".$id;
        // $url_farmasi = "http://192.168.1.163/rst-farmasi/web/api/penjualan/2110000387";
        $dataObat = $api->getApi($url_farmasi);

        if($dataObat['code'] == 200) {
            return $dataObat;
        } else {
            return Null;
        }
    }

    //  public function dataObatPasien($NoDaftar)
    // {
    //     $api = new Status();

    //     // $url_farmasi = "localhost:4444/farmasi/web/api/penjualanbynodaftar/".$NoDaftar;
    //     $url_farmasi = "http://192.168.4.10/farmasi/web/api/penjualanbyid/".$NoDaftar;   
    //     $dataObat = $api->getApi($url_farmasi);

    //     if($dataObat['code'] == 200) {
    //         return $dataObat;
    //     } else {
    //         return Null;
    //     }
    // }

     public function dataObatPasien($NoDaftar)
    {
        $api = new Status();

		$url_farmasi = "http://farmasi.rsudbangkinang.kamparkab.go.id/web/api/penjualanbynoreg/".$NoDaftar;
        // $url_farmasi = "http://192.168.4.10/farmasi/web/api/penjualanbynodaftar/".$NoDaftar;
        // $url_farmasi = "http://192.168.1.163/rst-farmasi/web/api/penjualan/2110000387";
        $dataObat = $api->getApi($url_farmasi);

        if($dataObat['code'] == 200) {
            return $dataObat;
        } else {
            return Null;
        }
    }    


    public function getTindakanLain($NoDaftar)
    {

        $total = 0;
        $data = Null;

        $registered_tdk_tdvdk_id = [3, 4, 5, 18,  19, 20, 21,23, 24,25];

        $data = MedisTindakanPasien::find()
        ->joinWith([
            'layanan'=>function($q) use($NoDaftar){
                $q->joinWith(['unit','kelas'])->andwhere(['pl_reg_kode'=>$NoDaftar])
                ->andWhere('pl_deleted_at is null');
            },
            'user',
            'tarifTindakan'=>function($q) use($registered_tdk_tdvdk_id) {
                $q->joinWith(['tindakan'])->andWhere(['NOT',['tdk_tdvdk_id'=> $registered_tdk_tdvdk_id]]);
            },
        ])
        ->where('tdp_tft_id NOT IN (SELECT ttu_tarif_tindakan_id from medis_m_tarif_tindakan_unit where ttu_jenis_tindakan=1 and ttu_deleted_at is null)')
        //  ->andWhere(['NOT', ['tdp_tft_id'=>$id_tindregis]])
        ->andWhere('tdp_deleted_at is null')
        ->orderBy('tdk_deskripsi')
        ->asArray()->all();

        if($data != Null) {
            foreach ($data as $t) {
                $total += $t['tdp_subtotal'];
            }
        }

        return [
            'total' => $total,
            'data' =>$data
        ];        

    }


    // public function getDataBiayaObat($NoDaftar)
    // {
	// 	$dataObatPasien = $this->dataObatPasien($NoDaftar);

    //     //$dataObatPasien = null;

    //     $total = 0;
    //     $dataPasien = Null;
    //     $dataDetailObat = Null;
    //     if($dataObatPasien != Null) {

    //         $dataPasien = $dataObatPasien['result']['0'];
    //         $dataDetailObat = $dataObatPasien['result']['1']['detail'];
    //         if($dataDetailObat != Null) {
    //             $total = 0;
    //             foreach ($dataDetailObat as $d) {
    //                 $total += $d['jumlah']*$d['harga'];
    //             }
    //         }
    //     }

    //     return [
    //         'total'=>$total,
    //         'dataPasien' => $dataPasien,
    //         'dataObat' => $dataDetailObat
    //     ];
    // }

    public function getDataBiayaObat($NoDaftar)
    {
		$dataObatPasien = $this->dataObatPasien($NoDaftar);

        $total = 0;
        $dataDetailObat = Null;
        if($dataObatPasien != Null) {
			
			if($dataObatPasien['result']['0'] != null) {
				$dataDetailObat = $dataObatPasien['result']['0'];
				foreach($dataObatPasien['result']['0'] as $r) {
					if($r['penjualan'] != null) {
						foreach($r['penjualan'] as $p) {
							if($p['detail'] != null) {
								$total = 0;
								foreach($p['detail'] as $d) {
									$total += $d['jumlah']*$d['harga'];
								}
							};
						}
					}
				}
			}

            // if($dataDetailObat != Null) {
                // $total = 0;
                // foreach ($dataDetailObat as $d) {
                    // $total += $d['jumlah']*$d['harga'];
                // }
            // }
        }

        return [
            'total'=>$total,
            'dataObat' => $dataDetailObat
        ];
    }

    public function getDataDebitur($NoPasien, $NoDaftar)
    {
        // Ambil Data Debitur Pasien dari Data Registrasi
        $Data = PendaftaranRegistrasi::find()
        ->joinWith([ 'debiturdetail'],true)
        ->andWhere(['reg_kode'=>$NoDaftar, 'reg_pasien_kode' =>$NoPasien])
        ->andWhere('reg_deleted_at is null')
        ->asArray()
        ->all();

        return $Data;
    }

     public function getDataDebiturLain($NoPasien, $NoDaftar)
    {
        // Ambil Data Debitur Pasien dari Data Registrasi
        $Data = EbsDebiturLainnya::find()
        ->joinWith([ 'debiturdetail'],true)
        ->andWhere(['dbl_registrasi_kode'=>$NoDaftar, 'dbl_pasien_kode' =>$NoPasien])
        ->andWhere('dbl_deleted_at is null')
        ->asArray()
        ->all();

        return $Data;
    }
    public function getDataNotif($NoPasien, $NoDaftar)
    {
		$JumlahKunjungan = PendaftaranRegistrasi::find()
        ->joinWith(['debiturdetail'], true)
        ->andWhere(['reg_pasien_kode' =>$NoPasien])
        ->andwhere('reg_deleted_at is null')
        ->orderBy(['reg_tgl_masuk'=>SORT_DESC])
        ->count();
		
        $JumlahPembayaran = EbsPembayaranPasien::find()
        ->andWhere(['byr_pasien_kode'=>$NoPasien, 'byr_reg_kode'=>$NoDaftar])
        ->andWhere('byr_deleted_at is null') ->count();

         $JumlahPlafon = EbsPembayaranPlafon::find()
        ->andWhere(['byp_pasien_kode'=>$NoPasien, 'byp_reg_kode'=>$NoDaftar])
        ->andWhere('byp_deleted_at is null') ->count();
		
		$JumlahAmbulance = EbsBiayaAmbulance::find()
        ->andWhere(['bynce_pasien_kode'=>$NoPasien, 'bynce_reg_kode'=>$NoDaftar])
        ->andWhere('bynce_deleted_at is null') ->count();
		
		$JumlahSuratPernyataan = EbsSuratPernyataan::find()
        ->andWhere(['snyt_pasien_kode'=>$NoPasien, 'snyt_reg_kode'=>$NoDaftar])
        ->andWhere('snyt_deleted_at is null') ->count();

        $data = array('JumlahKunjungan'=>$JumlahKunjungan, 'JumlahPembayaran'=>$JumlahPembayaran, 'JumlahPlafon'=>$JumlahPlafon,'JumlahCekout'=>'0',
    'JumlahAmbulance' => $JumlahAmbulance, 'JumlahSuratPernyataan'=>$JumlahSuratPernyataan);

        return $data;

    }


    // Begin Total Biaya

    public function getTotalBiaya($NoPasien, $NoDaftar)
    {
        $modelPembayaran = new EbsPembayaranPasien();
        $modelPlafon = new EbsPembayaranPlafon();

        $dataBiayaTindakan = $this->getDataBiayaTindakan($NoDaftar);

        //Cek Nilai Registrasi
        // Kode Pembayaran Registrasi = 1
        $BiayaRegistrasi = $dataBiayaTindakan['total_registrasi'];

        $PlafonRegistrasi = 0;
        $dataPlafonRegistrasi = $modelPlafon->getDataPembayaranPlafon($NoPasien, $NoDaftar, 1);
        if ($dataPlafonRegistrasi != Null) {
            foreach ($dataPlafonRegistrasi as $dPR) {
                $PlafonRegistrasi += $dPR['byp_jumlah'];
            }
        }

        $PembayaranRegistrasi = 0;
        $dataPembayaranRegistrasi = $modelPembayaran->getDataPembayaran($NoPasien, $NoDaftar, 1);
        if ($dataPembayaranRegistrasi != Null) {
            foreach ($dataPembayaranRegistrasi as $dP) {
                $PembayaranRegistrasi += $dP['byr_jumlah'];
            }
        }

        // Selisih Registrasi = $BiayaRegistrasi - ($PlafonRegistrasi + $PembayaranRegistrasi);
        $SelisihRegistrasi = $BiayaRegistrasi - ($PlafonRegistrasi+$PembayaranRegistrasi);
        //End Nilai Registrasi


        //Cek Nilai Perawatan
        // Kode Pembayaran Perawatan = 2
        $BiayaPerawatan = $dataBiayaTindakan['total_tindakan']; 

        $PlafonPerawatan = 0;
        $dataPlafonPerawatan = $modelPlafon->getDataPembayaranPlafon($NoPasien, $NoDaftar, 2);
        if ($dataPlafonPerawatan != Null) {
            foreach ($dataPlafonPerawatan as $dPer) {
                $PlafonPerawatan += $dPer['byp_jumlah'];
            }
        }
        $PembayaranPerawatan = 0;
        $dataPembayaranPerawatan = $modelPembayaran->getDataPembayaran($NoPasien, $NoDaftar, 2);
        if ($dataPembayaranPerawatan != Null) {
            foreach ($dataPembayaranPerawatan as $dPP) {
                $PembayaranPerawatan += $dPP['byr_jumlah'];
            }
        }
        // Selisih Perawatan = $BiayaPerawatan - ($PlafonPerawatan + $PembayaranPerawatan);
        $SelisihPerawatan = $BiayaPerawatan - ($PlafonPerawatan + $PembayaranPerawatan);
        //End Nilai Perawatan


        //Cek Nilai Obat
        // Kode Pembayaran Obat = 3
        $dataBiayaObat = $this->getDataBiayaObat($NoDaftar);
        $BiayaObat = $dataBiayaObat['total']; 
        
        $PlafonObat = 0;
        $dataPlafonObat = $modelPlafon->getDataPembayaranPlafon($NoPasien, $NoDaftar, 3);
        if ($dataPlafonObat != Null) {
            foreach ($dataPlafonObat as $dPO) {
                $PlafonObat += $dPO['byp_jumlah'];
            }
        }
        $PembayaranObat = 0;
        $dataPembayaranObat = $modelPembayaran->getDataPembayaran($NoPasien, $NoDaftar, 3);
        if ($dataPembayaranObat != Null) {
            foreach ($dataPembayaranObat as $dPPo) {
                $PembayaranObat += $dPPo['byr_jumlah'];
            }
        }
        // Selisih Obat = $BiayaObat - ($PlafonObat + $PembayaranObat);
        $SelisihObat = $BiayaObat - ($PlafonObat + $PembayaranObat);
        //End Nilai Obat

        //Cek Nilai Rawat Inap
        // Kode Pembayaran Rawat Inap = 4
        $dataBiayaRawatInap = $this->getDataBiayaRawatInap($NoDaftar);
        $BiayaRawatInap = $dataBiayaRawatInap['total_biaya'];  

        $PlafonRawatInap = 0;
        $dataPlafonRawatInap = $modelPlafon->getDataPembayaranPlafon($NoPasien, $NoDaftar, 4);
        if ($dataPlafonRawatInap != Null) {
            foreach ($dataPlafonRawatInap as $dPRI) {
                $PlafonRawatInap += $dPRI['byp_jumlah'];
            }
        }
        $PembayaranRawatInap = 0;
        $dataPembayaranRawatInap = $modelPembayaran->getDataPembayaran($NoPasien, $NoDaftar, 4);
        if ($dataPembayaranRawatInap != Null) {
            foreach ($dataPembayaranRawatInap as $dPri) {
                $PembayaranRawatInap += $dPri['byr_jumlah'];
            }
        }
        // Selisih Rawat Inap = $BiayaRawatInap - ($PlafonRawatInap + $PembayaranRawatInap);
        $SelisihRawatInap = $BiayaRawatInap - ($PlafonRawatInap + $PembayaranRawatInap);
        //End Nilai Rawat Inap

        //Cek Nilai Ambulance
        // Kode Pembayaran Ambulance = 12
        $dataBiayaAmbulance = $this->getDataBiayaAmbulance($NoDaftar);
        $BiayaAmbulance = $dataBiayaAmbulance['total_biaya'];  

        $PlafonAmbulance = 0;
        $dataPlafonAmbulance = $modelPlafon->getDataPembayaranPlafon($NoPasien, $NoDaftar, 12);
        if ($dataPlafonAmbulance != Null) {
            foreach ($dataPlafonAmbulance as $dPCE) {
                $PlafonAmbulance += $dPCE['byp_jumlah'];
            }
        }
        $PembayaranAmbulance = 0;
        $dataPembayaranAmbulance = $modelPembayaran->getDataPembayaran($NoPasien, $NoDaftar, 12);
        if ($dataPembayaranAmbulance != Null) {
            foreach ($dataPembayaranAmbulance as $dPce) {
                $PembayaranAmbulance += $dPce['byr_jumlah'];
            }
        }
        // Selisih Ambulance = $BiayaAmbulance - ($PlafonAmbulance + $PembayaranAmbulance);
        $SelisihAmbulance = $BiayaAmbulance - ($PlafonAmbulance + $PembayaranAmbulance);
        //End Nilai Ambulance


        //Cek Total 
            // Biaya Total = $BiayaRegistrasi + $BiayaPerawatan + $BiayaObat + $BiayaRawatInap + $BiayaAmbulance;
        $BiayaTotal = $BiayaRegistrasi + $BiayaPerawatan + $BiayaObat + $BiayaRawatInap + $BiayaAmbulance;
            // Plafon Total = $PlafonRegistrasi + $PlafonPerawatan + $PlafonObat + $PlafonRawatInap + $PlafonAmbulance;
        $PlafonTotal = $PlafonRegistrasi + $PlafonPerawatan + $PlafonObat + $PlafonRawatInap + $PlafonAmbulance;
            // Pembayaran Total = $PembayaranRegistrasi + $PembayaranPerawatan + $PembayaranObat + $PembayaranRawatInap + $PembayaranAmbulance;
        $PembayaranTotal = $PembayaranRegistrasi + $PembayaranPerawatan + $PembayaranObat + $PembayaranRawatInap + $PembayaranAmbulance;
            // Selisih Total = $SelisihRegistrasi + $SelisihPerawatan + $SelisihObat + $SelisihRawatInap + $SelisihAmbulance;
        $SelisihTotal = $SelisihRegistrasi + $SelisihPerawatan + $SelisihObat + $SelisihRawatInap + $SelisihAmbulance;
        //End Total

        // Cek Pembayaran Lain
        // Pembayaran Lain untuk Plafon adalah Kode Pembayaran Pengalihan Debitur(5)
        $TotalPembayaranLainPlafon = 0;
        $dataPlafonPembayaranLain = $modelPlafon->getDataPembayaranPlafon($NoPasien, $NoDaftar, 5);
            if ($dataPlafonPembayaranLain != Null) {
                foreach ($dataPlafonPembayaranLain as $dPPL) {
                    $TotalPembayaranLainPlafon += $dPPL['byp_jumlah'];
                }
            }

            // Kode Pembayaran Lain adalah Kode selain kode PembayaranRegistrasi(1), PembayaranPerawatan(2), PembayaranObat(3), PembayaranRawatInap(4), PembayaranPengalihan(5), PembayaranAmbulance(12)
            $TotalPembayaranLain = 0;
            $KodeLain = ['1','2','3','4','5','12'];
            $dataPembayaranLain = $modelPembayaran->getDataPembayaranLain($NoPasien, $NoDaftar, $KodeLain);
            if ($dataPembayaranLain != Null) {
                foreach ($dataPembayaranLain as $dPemLain) {
                    $TotalPembayaranLain += $dPemLain['byr_jumlah'];
                }
            }         

        // End Pembayaran Lain

        // Sisa
            // Sisa = $SelisihTotal - ($TotalPembayaranLainPlafon - $TotalPembayaranLain)
        $Sisa = $SelisihTotal - ($TotalPembayaranLainPlafon + $TotalPembayaranLain);

        // End Sisa
		
		// Naik Kelas
        $modelNaikKelas = new EbsNaikKelas();
        $dataNaikKelas = $modelNaikKelas->getDataNaikKelas($NoPasien, $NoDaftar);
        // End Naik Kelas
        $Terbilang = self::getTerbilang($Sisa);

        return ([
            'Registrasi'=>[
                'BiayaRegistrasi' =>$BiayaRegistrasi,
                'PlafonRegistrasi'=>$PlafonRegistrasi,
                'PembayaranRegistrasi'=>$PembayaranRegistrasi,
                'SelisihRegistrasi'=>$SelisihRegistrasi,
            ],
            'Perawatan' =>[
                'BiayaPerawatan' =>$BiayaPerawatan,
                'PlafonPerawatan'=>$PlafonPerawatan,
                'PembayaranPerawatan'=>$PembayaranPerawatan,
                'SelisihPerawatan'=>$SelisihPerawatan,
            ],
            'Obat' =>[
                'BiayaObat' =>$BiayaObat,
                'PlafonObat'=>$PlafonObat,
                'PembayaranObat'=>$PembayaranObat,
                'SelisihObat'=>$SelisihObat,
            ],
            'RawatInap'=>[
                'BiayaRawatInap' =>$BiayaRawatInap,
                'PlafonRawatInap'=>$PlafonRawatInap,
                'PembayaranRawatInap'=>$PembayaranRawatInap,
                'SelisihRawatInap'=>$SelisihRawatInap,
            ],
			'Ambulance'=>[
                'BiayaAmbulance' =>$BiayaAmbulance,
                'PlafonAmbulance'=>$PlafonAmbulance,
                'PembayaranAmbulance'=>$PembayaranAmbulance,
                'SelisihAmbulance'=>$SelisihAmbulance,
            ],
            'Total'=>[
                'BiayaTotal' =>$BiayaTotal,
                'PlafonTotal'=>$PlafonTotal,
                'PembayaranTotal'=>$PembayaranTotal,
                'SelisihTotal'=>$SelisihTotal,
            ],
            'PembayaranLain'=>[
                'TotalPembayaranLainPlafon'=>$TotalPembayaranLainPlafon,
                'TotalPembayaranLain'=>$TotalPembayaranLain,
            ],
            'NaikKelas'=>[
                'DataNaikKelas'=>$dataNaikKelas
            ],
            'Sisa'=> $Sisa,
            'Terbilang'=> $Terbilang,
        ]);
    }
    // End Total Biaya


    // Cek Biaya Tindakan

    static public function getCekBiayaTindakan()
    {
        $Data = MedisMTarifTindakanUnit::find()->joinWith([
            'tarifTindakan'=>function($q){
                $q->joinWith([
                    'tindakan'
                ]);
            },
            'unit'
        ])->andWhere('ttu_deleted_at is null')->asArray()->all();

        return $Data;
    }

	/**
     * Memformat suatu angka menjadi format yang umum digunakan dalam penulisan nominal rupiah
     * 
     * @param 	float 	nilai rupiah
     * @return 	string
     */
    public function format($nominal, $sign = 'Rp. ', $end = ',-', $presisi = 0) {
        return $sign . number_format($nominal, $presisi, ',', '.') . $end;
    }

    public function format_no_sign($nominal, $end = ',-', $presisi = 0) {
        return number_format($nominal, $presisi, ',', '.') . $end;
    }

    public static function rupiah($nominal) {
        if (strpos($nominal, '.') > 0) {
            $nilai = static::konversi(strstr($nominal, '.', true));
            $koma = static::tkoma(strstr($nominal, '.'));
        } else {
            $nilai = static::konversi($nominal);
            $koma = "";
        }
        return $nilai . " " . $koma;
    }

    public static function konversi($number) {
        $number = str_replace('.', '', $number);
        if (!is_numeric($number))
            throw new NotNumbersException;
        $base = array('Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
        $numeric = array('1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1);
        $unit = array('Kuadriliun', 'Triliun', 'Biliun', 'Milyar', 'Juta', 'Ribu', 'Ratus', 'Puluh', '');
        $str = null;
        $i = 0;
        if ($number == 0) {
            $str = 'nol';
        } else {
            while ($number != 0) {
                $count = (int) ($number / $numeric[$i]);
                if ($count >= 10) {
                    $str .= static::konversi($count) . ' ' . $unit[$i] . ' ';
                } elseif ($count > 0 && $count < 10) {
                    $str .= $base[$count] . ' ' . $unit[$i] . ' ';
                }
                $number -= $numeric[$i] * $count;
                $i++;
            }
            $str = preg_replace('/Satu Puluh (\w+)/i', '\1 Belas', $str);
            $str = preg_replace('/Satu Ribu/', 'Seribu\1', $str);
            $str = preg_replace('/Satu Ratus/', 'Seratus\1', $str);
            $str = preg_replace('/Satu Puluh/', 'Sepuluh\1', $str);
            $str = preg_replace('/Satu Belas/', 'Sebelas\1', $str);
            $str = preg_replace('/\s{2,}/', ' ', trim($str));
        }
        return $str;
    }

    public function tkoma($nominal) {
        $base = array('Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');

        $temp = "Koma";
        $pjg = strlen($nominal);
        $pos = 1;
        while ($pos < $pjg) {
            $x = substr($nominal, $pos, 1);
            $pos++;
            $temp .= " " . $base[$x];
        }
        return $temp;
    }

    // Library

    public static function date2Ind($str, $spasi = true)
    {
        $bulan = array(1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        );

        $tgl = explode('-', $str);

        if (!empty($str) && isset($tgl[1])) {
            $index = (int) $tgl[1];
            if (isset($bulan[$index])) {
                $date = $tgl[2] . ' ' . $bulan[(int) $tgl[1]] . ' ' . $tgl[0];
                if ($spasi == true) {
                    return $date . "&nbsp;";
                } else {
                    return $date;
                }

            } else {
                return '';
            }
        } else {
            return '';
        }

        // setlocale(LC_TIME, 'id_ID');
        // $date = strftime("%d %B %Y", strtotime($str));
        // if ($str == "0000-00-00" || $str == "00-00-0000" || empty($str)) {
        //     return '';
        // } else {
        //     if ($spasi == true) {
        //         return $date . "&nbsp;";
        //     } else {
        //         return $date;
        //     }

        // }
    }

    public static function dateInd($ex,$day=true){
        if($ex=="0000-00-00" or empty($ex)){
            return null;
        } else {
            $pecah = explode(" ", $ex);
            $nameofDay = '';
            if ($day == true) {
                $nameofDay = Data::getNamaHari($pecah[0]) . ', ';
            } else {
                $nameofDay = '';
            }
            if (!empty($pecah[1])) {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = Data::getBulan(substr($tgl, 5, 2));
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $pecah[1] . ' WIB';
            } else {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = Data::getBulan(substr($tgl, 5, 2));
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . ' ' . $bulan . ' ' . $tahun;
            }
        }
    }

    public static function dateIndLaporan($ex,$day=true){
        $pecah=explode(" ",$ex);
        $nameofDay='';
        if($day==true){
            $nameofDay=Data::getNamaHari($pecah[0]).'';
        }else{
            $nameofDay='';
        }
        if(!empty($pecah[1])){
            $tgl=$pecah[0];
            $tanggal = substr($tgl,8,2);
            $bulan = Data::getBulan(substr($tgl,5,2));
            $tahun = substr($tgl,0,4);
            return $nameofDay."/".$tanggal.' '.$bulan.' '.$tahun;
        }else{
            $tgl=$pecah[0];
            $tanggal = substr($tgl,8,2);
            $bulan = Data::getBulan(substr($tgl,5,2));
            $tahun = substr($tgl,0,4);
            return $nameofDay."/".$tanggal.' '.$bulan.' '.$tahun;
        }
    }

    public static function dateInd1($ex,$day=true){
        if($ex=="0000-00-00" or empty($ex)){
            return null;
        } else {
            $pecah = explode(" ", $ex);
            $nameofDay = '';
            if ($day == true) {
                $nameofDay = Data::getNamaHari($pecah[0]) . ', ';
            } else {
                $nameofDay = '';
            }
            if (!empty($pecah[1])) {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = substr($tgl, 5, 2);
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . '/' . $bulan . '/' . $tahun . '<br>(' . $pecah[1] . ' WIB)';
            } else {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = substr($tgl, 5, 2);
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . '-' . $bulan . '-' . $tahun;
            }
        }
    }

    public static function cut_text($x,$n)
    {
        $kata=strtok(strip_tags($x)," ");
        $new="";
        for ($i=1; $i<=$n; $i++){    //membatasi berapa kata yang akan ditampilkan di halaman utama
            $new.=$kata;        //tulis isi agenda
            $new.=" ";
            $kata=strtok(" ");
        }
        return $new;
    }


    public static function cek_img_tag($text,$original)
    {
        //membuat auto thumbnails
        @preg_match("/src=\"(.+)\"/",$text,$cocok);
        @$patern= explode("\"",$cocok[1]);
        $img = str_replace("\"/>","",$patern[0]);
        $img = str_replace("../","",$img);
        $img = str_replace("/>","",$img);
        if($img=="")
        {
            $img=$original;
        }
        else
        {
            $img=str_replace("\&quot;","",$img);

        }

        return $img;
    }

    public static function simbolRemoving($title)
    {
        $linkbaru=strtolower($title);
        $tanda=array("|",",","\"","'",".","(",")","-","_",":",";","?","!","@","#","\$","%","^","&","*","+","/","\\",">","<","\r","\t","\n");
        $rep=stripslashes(str_replace($tanda,"",$linkbaru));
        $rep=stripslashes(str_replace('  ',"-",$rep));
        $rep=stripslashes(str_replace(' ',"-",$rep));
        return $rep;
    }

    public static function getNamaHari($date){
        $namahari = date('D', strtotime($date));
        //Function date(String1, strtotime(String2)); adalah fungsi untuk mendapatkan nama hari
        return Data::getHari($namahari);
    }

    public static function getHari($hari){
        switch ($hari){
            case 'Mon':
                return "Senin";
                break;
            case 'Tue':
                return "Selasa";
                break;
            case 'Wed':
                return "Rabu";
                break;
            case 'Thu':
                return "Kamis";
                break;
            case 'Fri':
                return "Jumat";
                break;
            case 'Sat':
                return "Sabtu";
                break;
            case 'Sun':
                return "Minggu";
                break;
        }
    }
    public static function getBulan($bln){
        switch ($bln){
            case 1:
                return "Januari";
                break;
            case '01':
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case '02':
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case '03':
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case '04':
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case '05':
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case '06':
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case '07':
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case '08':
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case '09':
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    public static function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        $IP = $_SERVER['REMOTE_ADDR'];

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'IP' => $IP,
        );
    }

    public static function selisih2tanggal($tgl1,$tgl2){
        $pecah1 = explode("-", $tgl1);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];

        // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
        // dari tanggal kedua

        $pecah2 = explode("-", $tgl2);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];

        // menghitung JDN dari masing-masing tanggal

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);

        // hitung selisih hari kedua tanggal

        $selisih = $jd2 - $jd1;

        return $selisih;
    }

    public static function anti_injection($d)
    {
        $f=(stripslashes(strip_tags(htmlspecialchars($d, ENT_QUOTES))));
        return $f;
    }

    public static function monthly()
    {
        return ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    }

}