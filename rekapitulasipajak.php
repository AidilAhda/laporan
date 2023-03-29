<?php

global $app;



if (!$app) {

	exit();

}



class RekapitulasiPajakController extends Controller {

	/**

     * @var RekapitulasiPajakModel

     */

	public $model;



	/**

     * @var RekapitulasiPajakView

     */

	public $view;



	public function __construct() {

		$this->setType(self::TYPE_SINGLE);

		$this->setTitle('Rekapitulasi Pajak');

		$this->setIcon('print');



		$this->allowAccess('Administrator');

		$this->allowAccess('Penerimaan');

		$this->allowAccess('Pelaporan');

		$this->allowAccess('Pejabat');

		$this->allowAccess('Pimpinan');



		//Create model and view

		$this->prepare();

	}



	public function index() {

		$this->view->index();

	}



	public function export() {

		global $app;



		$btnExport = $app->getRequestStr('btnExport');



		$actionResult = $this->model->export();

		debux($actionResult);

        switch ($actionResult->value['obyek']->obyID) {

            case 1:

                //Pajak Hotel
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfRestHibHot($actionResult);
                }
                break;

            case 2:

                //Pajak Restoran
                if
                 ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfRestHibHot($actionResult);
                }
                break;


            case 3:

                //Pajak Hiburan
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfRestHibHot($actionResult);
                }
                break;

            case 4:

                //Pajak Reklame
                if ($btnExport == 'Excel') {
                    $this->view->excelReklame($actionResult);
                } else {
                    //PDF
                    $this->view->pdfReklame($actionResult);
                }
                break;

            case 5:

                //Pajak Penerangan Jalan
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfPeneranganJalan($actionResult);
                }
                break;

            case 6:
                //Pajak Parki
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfParkir($actionResult);
                }
                break;

            case 7:
                //Pajak Air Tanah
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfAirTanah($actionResult);
                }
                break;

            case 8:
                //Pajak Walet
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfWalet($actionResult);
                }
                break;

            case 9:
                //Pajak Mineral
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfMineral($actionResult);
                }
                break;

            case 11:
                //Pajak Mineral
                if ($btnExport == 'Excel') {
                    $this->view->excelRekap($actionResult);
                } else {
                    //PDF
                    $this->view->pdfBphtb($actionResult);
                }
                break;
        }
	}
}



class RekapitulasiPajakModel extends Model {

	public function export() {

		global $app;



		$actionResult = new ActionResult();



		$obyek = $app->getRequestInt('obyek');

		$bulan = $app->getRequestInt('bulan');

		$tahun = $app->getRequestInt('tahun');



		$orientasi = $app->getRequestStr('orientasi', 'P');

		$lebar = $app->getRequestInt('lebar', 215);

		$tinggi = $app->getRequestInt('tinggi', 330);

		$fontsize = $app->getRequestInt('fontsize', 10);



		$sql = "SELECT *

				FROM obyek

				WHERE obyID='".$obyek."'";

		$objObyek = $app->queryObject($sql);

		if (!$objObyek) {

			die('Obyek dengan ID '.$obyek.' tidak ditemukan');

		}



		//TODO:

		if ($obyek == 11) {

			//BPHTB

            //, bphNama AS nama, CONCAT(bphAlamat,' ',bphBlokKavNo) AS alamat

            if ($bulan > 0) {

                $periode = "MONTH(ssTglSetor)='".$bulan."' AND YEAR(ssTglSetor)='".$tahun."'";

            } else {

                $periode = "YEAR(ssTglSetor)='".$tahun."'";

            }



			$sql = "SELECT *, ssNo AS no

					FROM suratsetoran

					WHERE ".$periode." AND ssStatusSetor='Sudah Setor' AND (ssBphID > 0 OR ssBpkID > 0)

					ORDER BY ssNo";

			$actionResult->value['data'] = $app->queryArrayOfObjects($sql);

			$bphIDs = array();

			$bpkIDs = array();

			foreach ($actionResult->value['data'] as $k=>$v) {

				if ($v->ssBphID > 0) {

					$bphIDs[] = $v->ssBphID;

				}

				if ($v->ssBpkID > 0) {

					$bpkIDs[] = $v->ssBpkID;

				}

			}



			$actionResult->value['bphtb'] = array();

			$actionResult->value['bphtbkolektif'] = array();



			if (count($bphIDs) > 0) {

				$sql = "SELECT bphID AS id, bphNama AS nama, bphNoLengkap, CONCAT(bphAlamat,' ',bphBlokKavNo) AS alamat

						FROM bphtb

						WHERE bphID IN (".implode(", ", $bphIDs).")";

				$actionResult->value['bphtb'] = $app->queryArrayOfObjects($sql);

			}



			if (count($bpkIDs) > 0) {

				$sql = "SELECT bpkID AS id, bpkNama AS nama, bpkNoLengkap, bpkAlamat AS alamat

						FROM bphtbkolektif

						WHERE bpkID IN (".implode(", ", $bpkIDs).")";

				$actionResult->value['bphtbkolektif'] = $app->queryArrayOfObjects($sql);

			}

		} else {

            if ($bulan > 0) {

                $periode = "MONTH(ssTglSetor)='".$bulan."' AND YEAR(ssTglSetor)='".$tahun."'";

            } else {

                $periode = "YEAR(ssTglSetor)='".$tahun."'";

            }



			$sql = "SELECT *, wpNama AS nama, wpAlamat AS alamat, ssNo AS no

					FROM suratsetoran, skpd, sptpd, rincianobyek, pelayanan, wajibpajak

					WHERE ".$periode." AND ssStatusSetor='Sudah Setor' AND ssSkpID=skpID AND skpSptID=sptID AND sptRobID=robID AND robObyID='".$obyek."' AND sptLyID=lyID AND lyWpID=wpID

                    ORDER BY ssNo";

            $actionResult->value['data'] = $app->queryArrayOfObjects($sql);

            

            $actionResult->value['detailsptpd'] = array();

            

            switch ($obyek) {

                case 4:

                    //Reklame

                    $sql = "SELECT *, dsptID AS id, dsptSptID AS parentId

                            FROM detailsptpdreklame, nilaijualreklame

                            WHERE dsptRekID=rekID";

                    $actionResult->value['detailsptpd'] = $app->queryArrayOfObjects($sql);

                    break;

            }

        }

        

        $actionResult->value['obyek'] = $objObyek;

		$actionResult->value['bulan'] = $bulan;

		$actionResult->value['tahun'] = $tahun;



		$actionResult->value['orientasi'] = $orientasi;

		$actionResult->value['lebar'] = $lebar;

		$actionResult->value['tinggi'] = $tinggi;

		$actionResult->value['fontsize'] = $fontsize;



		return $actionResult;

	}

}



class RekapitulasiPajakView extends View {


	public function excelRekap($actionResult) {

		global $app;



		$data = $actionResult->value['data'];
        $detailsptpd = $actionResult->value['detailsptpd'];
		$bphtb = $actionResult->value['bphtb'];
		$bphtbkolektif = $actionResult->value['bphtbkolektif'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];


		require_once $app->serverPath.'/libraries/PHPExcel/IOFactory.php';
		if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }

        

        //Persiapkan Excel-nya

		$base = $app->serverPath.'/libraries/rekapitulasi_pajak.xls';

		$fileName = 'Rekapitulasi '.$objObyek->obyNama.' '.$periode;

		$worksheetName = $periode;

		$objReader = PHPExcel_IOFactory::createReader('Excel5');

		$objPHPExcel = $objReader->load($base);

		$worksheet = $objPHPExcel->getActiveSheet();

		

		$initRow = 6; //posisi header

		$currentRow = $initRow;

		$no = 1;



		$worksheet->setCellValue("B3", "REKAPITULASI PAJAK ".strtoupper($objObyek->obyNama));

		$worksheet->setCellValue("B4", strtoupper($periode));



		if (count($actionResult->value['data']) > 0) {

			$totalPokok = 0;

            $totalDenda = 0;

            

			foreach ($actionResult->value['data'] as $v) {

				++$currentRow;

			
				$totalPokok += $v->ssJumlahSetorPokok;
               
				if ($v->ssBphID > 0) {

					$nama = $bphtb[$v->ssBphID]->nama;

				} else if ($v->ssBpkID > 0) {

					$nama = $bphtbkolektif[$v->ssBpkID]->nama;

				} else {

					$nama = $v->nama;

				}



				if ($v->ssBphID > 0) {

					$alamat = $bphtb[$v->ssBphID]->alamat;

				} else if ($v->ssBpkID > 0) {

					$alamat = $bphtbkolektif[$v->ssBpkID]->alamat;

				} else {

					$alamat = $v->alamat;

                }


				if ($v->ssBphID > 0) {

					$skpNoLengkap = $bphtb[$v->ssBphID]->bphNoLengkap;

				} else if ($v->ssBpkID > 0) {

					$skpNoLengkap = $bphtbkolektif[$v->ssBpkID]->bpkNoLengkap;

				} else {

					$skpNoLengkap = $v->skpNoLengkap;

                }

                

                //TODO: tidak semua berjenis (dsptKelompok='Permanen'), karena ada yang Insidentil

				$worksheet->setCellValue("B{$currentRow}", $no)
				->setCellValueExplicit("C{$currentRow}", (!empty($skpNoLengkap) ? $skpNoLengkap : '-'), PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValue("D{$currentRow}", $app->MySQLDateToNormal($v->ssTglSetor))
				->setCellValue("E{$currentRow}", strtoupper($nama))
				->setCellValueExplicit("F{$currentRow}", (!empty($v->wpNIK) ? $v->wpNIK : '-'), PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValue("G{$currentRow}", strtoupper($alamat))
				->setCellValue("H{$currentRow}", $v->ssJumlahSetorPokok);

				$no++;

			}



			$worksheet->setCellValue("H".($currentRow + 1), '=SUM(H'.($initRow + 1).':H'.$currentRow.')');

		}

		$worksheet->mergeCells('B'.($currentRow + 1).':G'.($currentRow + 1));



		//$worksheet->getRowDimension($currentRow)->setRowHeight(-1)

		$worksheet->getStyle("B".($initRow + 1).":H".($currentRow + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//$worksheet->getStyle("B".($initRow + 1).":H{$currentRow}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);



		$worksheet->getStyle("H".($initRow + 1).":H".($currentRow + 1))->getNumberFormat()->setFormatCode('#,##0');



		$objPHPExcel->getActiveSheet()->setTitle($worksheetName);



		// Redirect output to a client�s web browser (Excel5)

		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');

		header('Cache-Control: max-age=0');



		// If you're serving to IE 9, then the following may be needed

		header('Cache-Control: max-age=1');



		// If you're serving to IE over SSL, then the following may be needed

		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past

		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified

		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1

		header('Pragma: public'); // HTTP/1.0



		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');

	}



	public function excelReklame($actionResult) {

		global $app;



		$data = $actionResult->value['data'];

        $detailsptpd = $actionResult->value['detailsptpd'];

		$bphtb = $actionResult->value['bphtb'];

		$bphtbkolektif = $actionResult->value['bphtbkolektif'];



		$objObyek = $actionResult->value['obyek'];

		$bulan = $actionResult->value['bulan'];

		$tahun = $actionResult->value['tahun'];



		require_once $app->serverPath.'/libraries/PHPExcel/IOFactory.php';



		if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }

        

        //Persiapkan Excel-nya

		$base = $app->serverPath.'/libraries/rekapitulasi_pajak_reklame.xls';

		$fileName = 'Rekapitulasi '.$objObyek->obyNama.' '.$periode;

		$worksheetName = $periode;

		$objReader = PHPExcel_IOFactory::createReader('Excel5');

		$objPHPExcel = $objReader->load($base);

		$worksheet = $objPHPExcel->getActiveSheet();

		

		$initRow = 6; //posisi header

		$currentRow = $initRow;

		$no = 1;



		$worksheet->setCellValue("B3", "REKAPITULASI PAJAK ".strtoupper($objObyek->obyNama));

		$worksheet->setCellValue("B4", strtoupper($periode));



		if (count($actionResult->value['data']) > 0) {

			$totalPokok = 0;

            $totalDenda = 0;

            

			foreach ($actionResult->value['data'] as $v) {

				++$currentRow;

				

				$totalPokok += $v->ssJumlahSetorPokok;

                $totalDenda += $v->ssJumlahSetorDenda;

                

				if ($v->ssBphID > 0) {

					$nama = $bphtb[$v->ssBphID]->nama;

				} else if ($v->ssBpkID > 0) {

					$nama = $bphtbkolektif[$v->ssBpkID]->nama;

				} else {

					$nama = $v->nama;

				}



				if ($v->ssBphID > 0) {

					$alamat = $bphtb[$v->ssBphID]->alamat;

				} else if ($v->ssBpkID > 0) {

					$alamat = $bphtbkolektif[$v->ssBpkID]->alamat;

				} else {

					$alamat = $v->alamat;

                }

                

                //TODO: tidak semua berjenis (dsptKelompok='Permanen'), karena ada yang Insidentil

                $arrJenis = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        if ($v2->dsptKelompok == 'Permanen') {

                            $arrJenis[] = $v2->rekJenis;

                        } else {

                            $arrJenis[] = $v2->dsptKelompok;

                        }

                    }

                } else {

                    $arrJenis[] = '-';

                }

                $jenis = implode('<br>', $arrJenis);

                

                $arrUkuran = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        if ($v2->dsptKelompok == 'Permanen') {

                            $arrUkuran[] = rtrim(rtrim($app->MySQLToMoney($v2->dsptPanjang, 2), "0"),",").'m x '.rtrim(rtrim($app->MySQLToMoney($v2->dsptLebar, 2), "0"),",").'m x '.rtrim(rtrim($app->MySQLToMoney($v2->dsptTinggi, 2), "0"),",").'m';

                        } else {

                            $arrUkuran[] = rtrim(rtrim($app->MySQLToMoney($v2->dsptPanjang, 2), "0"),",").'m x '.rtrim(rtrim($app->MySQLToMoney($v2->dsptLebar, 2), "0"),",").'m';

                        }

                    }

                } else {

                    $arrUkuran[] = '-';

                }

                $ukuran = implode('<br>', $arrUkuran);



                $arrSudutPandang = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        $arrSudutPandang[] = $v2->dsptArah.' arah';

                    }

                } else {

                    $arrSudutPandang[] = '-';

                }

                $sudutPandang = implode('<br>', $arrSudutPandang);



				$worksheet->setCellValue("B{$currentRow}", $no)

				->setCellValue("C{$currentRow}", $app->MySQLDateToNormal($v->ssTglSetor))

				->setCellValue("D{$currentRow}", strtoupper($nama))

				->setCellValueExplicit("E{$currentRow}", (!empty($v->wpNIK) ? $v->wpNIK : '-'), PHPExcel_Cell_DataType::TYPE_STRING)

				->setCellValue("F{$currentRow}", strtoupper($alamat))

				->setCellValue("G{$currentRow}", $jenis)

				->setCellValue("H{$currentRow}", $ukuran)

				->setCellValue("I{$currentRow}", $sudutPandang)

				->setCellValue("J{$currentRow}", $lokasiPemasangan)

				->setCellValue("K{$currentRow}", $v->ssJumlahSetorPokok + $v->ssJumlahSetorDenda);



				$no++;

			}



			$worksheet->setCellValue("K".($currentRow + 1), '=SUM(K'.($initRow + 1).':K'.$currentRow.')');

		}



		$worksheet->mergeCells('B'.($currentRow + 1).':J'.($currentRow + 1));



		//$worksheet->getRowDimension($currentRow)->setRowHeight(-1)

		$worksheet->getStyle("B".($initRow + 1).":K".($currentRow + 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//$worksheet->getStyle("B".($initRow + 1).":H{$currentRow}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);



		$worksheet->getStyle("K".($initRow + 1).":K".($currentRow + 1))->getNumberFormat()->setFormatCode('#,##0');



		$objPHPExcel->getActiveSheet()->setTitle($worksheetName);



		// Redirect output to a client�s web browser (Excel5)

		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');

		header('Cache-Control: max-age=0');



		// If you're serving to IE 9, then the following may be needed

		header('Cache-Control: max-age=1');



		// If you're serving to IE over SSL, then the following may be needed

		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past

		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified

		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1

		header('Pragma: public'); // HTTP/1.0



		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

	}





	public function pdfReklame($actionResult) {

		global $app;



        $data = $actionResult->value['data'];

        $detailsptpd = $actionResult->value['detailsptpd'];

		$bphtb = $actionResult->value['bphtb'];

		$bphtbkolektif = $actionResult->value['bphtbkolektif'];



		$objObyek = $actionResult->value['obyek'];

		$bulan = $actionResult->value['bulan'];

		$tahun = $actionResult->value['tahun'];



		$orientasi = $actionResult->value['orientasi'];

		$lebar = $actionResult->value['lebar'];

		$tinggi = $actionResult->value['tinggi'];

		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }

        

        //Persiapkan PDF-nya

        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);



		$pdf->create();



		$pdf->pdf->pageWidth = $lebar;

		$pdf->pdf->pageHeight = $tinggi;

		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);



		$pdf->addPage($orientasi);



		ob_start();

?>

        <p style="text-align:center;">

            <b>

                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>

    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>

			    <?php echo strtoupper($periode); ?>

            </b>

        </p>

<?php

        $cols = array(5,8,10,12,15,10,10,7,13,10);

        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jenis</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Ukuran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Sudut Pandang</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Lokasi Pemasangan</b></th>

				<?php /*<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SSPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah Pokok Pajak (Rp)</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Denda<br>(Rp)</b></th>*/ ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;

            $totalDenda = 0;

            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;

				$totalDenda += $v->ssJumlahSetorDenda;

?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php

				if ($v->ssBphID > 0) {

					$nama = $bphtb[$v->ssBphID]->nama;

				} else if ($v->ssBpkID > 0) {

					$nama = $bphtbkolektif[$v->ssBpkID]->nama;

				} else {

					$nama = $v->nama;

				}

				echo strtoupper($nama);

?>

				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php

				if ($v->ssBphID > 0) {

					$alamat = $bphtb[$v->ssBphID]->alamat;

				} else if ($v->ssBpkID > 0) {

					$alamat = $bphtbkolektif[$v->ssBpkID]->alamat;

				} else {

					$alamat = $v->alamat;

				}

				echo strtoupper($alamat);

?>

                </td>

                <td width="<?php echo $cols[$colNo++]; ?>%">

<?php

                //TODO: tidak semua berjenis (dsptKelompok='Permanen'), karena ada yang Insidentil

                $arrJenis = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        if ($v2->dsptKelompok == 'Permanen') {

                            $arrJenis[] = $v2->rekJenis;

                        } else {

                            $arrJenis[] = $v2->dsptKelompok;

                        }

                    }

                } else {

                    $arrJenis[] = '-';

                }

                $jenis = implode('<br>', $arrJenis);

                echo $jenis;

?>

                </td>

                <td width="<?php echo $cols[$colNo++]; ?>%">

<?php

                $arrUkuran = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        if ($v2->dsptKelompok == 'Permanen') {

                            $arrUkuran[] = rtrim(rtrim($app->MySQLToMoney($v2->dsptPanjang, 2), "0"),",").'m x '.rtrim(rtrim($app->MySQLToMoney($v2->dsptLebar, 2), "0"),",").'m x '.rtrim(rtrim($app->MySQLToMoney($v2->dsptTinggi, 2), "0"),",").'m';

                        } else {

                            $arrUkuran[] = rtrim(rtrim($app->MySQLToMoney($v2->dsptPanjang, 2), "0"),",").'m x '.rtrim(rtrim($app->MySQLToMoney($v2->dsptLebar, 2), "0"),",").'m';

                        }

                    }

                } else {

                    $arrUkuran[] = '-';

                }

                $ukuran = implode('<br>', $arrUkuran);

                echo $ukuran;

?> 

                </td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

<?php

                $arrSudutPandang = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        $arrSudutPandang[] = $v2->dsptArah.' arah';

                    }

                } else {

                    $arrSudutPandang[] = '-';

                }

                $sudutPandang = implode('<br>', $arrSudutPandang);

                echo $sudutPandang;

?> 

                </td>

                <td width="<?php echo $cols[$colNo++]; ?>%">

<?php

                $arrLokasiPemasangan = array();

                if (isset($detailsptpd[$v->sptID])) {

                    foreach ($detailsptpd[$v->sptID] as $v2) {

                        if (!empty($v2->dsptLokasiPemasangan)) {

                            $arrLokasiPemasangan[] = $v2->dsptLokasiPemasangan;

                        } else {

                            $arrLokasiPemasangan[] = '-';

                        }

                    }

                } else {

                    $arrLokasiPemasangan[] = '-';

                }

                $lokasiPemasangan = implode('<br>', $arrLokasiPemasangan);

                echo $lokasiPemasangan;

?>

                </td>

				<?php /*<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->no; ?></td>

				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>

				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorDenda, 2); ?></td>*/ ?>

				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok + $v->ssJumlahSetorDenda, 2); ?></td>

			</tr>

<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<?php /*<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalDenda, 2); ?></b></td>*/ ?>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok + $totalDenda, 2); ?></b></td>

			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}



	// Report PDF Pajak Restoran/ Hiburan/ Hotel
	public function pdfRestHibHot($actionResult) {

		global $app;


        $data = $actionResult->value['data'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->skpNoLengkap; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				echo strtoupper($v->nama);
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				echo strtoupper($v->alamat);
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}


	public function pdfBphtb($actionResult) {

		global $app;


        $data = $actionResult->value['data'];
		$bphtb = $actionResult->value['bphtb'];
		$bphtbkolektif = $actionResult->value['bphtbkolektif'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
<?php 						
					//BPHTB, ssBphID, ssBpkID
                    if ($v->ssBphID > 0) {

                        //ssBphID

                        echo $bphtb[$v->ssBphID]->bphNoLengkap;

                    } else {

                        //ssBpkID

                        echo $bphtbkolektif[$v->ssBpkID]->bpkNoLengkap;

                    }; 
?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				if ($v->ssBphID > 0) {

					$nama = $bphtb[$v->ssBphID]->nama;

				} else if ($v->ssBpkID > 0) {

					$nama = $bphtbkolektif[$v->ssBpkID]->nama;

				} else {

					$nama = $v->nama;

				}

				echo $nama;
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
<?php 
                    echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				if ($v->ssBphID > 0) {

					$alamat = $bphtb[$v->ssBphID]->alamat;

				} else if ($v->ssBpkID > 0) {

					$alamat = $bphtbkolektif[$v->ssBpkID]->alamat;

				} else {

					$alamat = $v->alamat;

				}

				echo $alamat;
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}


	// Pajak Parkir
	public function pdfParkir($actionResult) {

		global $app;


        $data = $actionResult->value['data'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->skpNoLengkap; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				echo strtoupper($v->nama);
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				echo strtoupper($v->alamat);
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}


	// Pajak Air Tanah
	public function pdfAirTanah($actionResult) {

		global $app;


        $data = $actionResult->value['data'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->skpNoLengkap; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				echo strtoupper($v->nama);
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				echo strtoupper($v->alamat);
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}


	public function pdfWalet($actionResult) {

		global $app;


        $data = $actionResult->value['data'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->skpNoLengkap; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				echo strtoupper($v->nama);
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				echo strtoupper($v->alamat);
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}


	public function pdfMineral($actionResult) {

		global $app;


        $data = $actionResult->value['data'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->skpNoLengkap; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				echo strtoupper($v->nama);
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				echo strtoupper($v->alamat);
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}



	// Report PDF Pajak Penerangan Jalan
	public function pdfPeneranganJalan($actionResult) {

		global $app;


        $data = $actionResult->value['data'];

		$objObyek = $actionResult->value['obyek'];
		$bulan = $actionResult->value['bulan'];
		$tahun = $actionResult->value['tahun'];

		$orientasi = $actionResult->value['orientasi'];
		$lebar = $actionResult->value['lebar'];
		$tinggi = $actionResult->value['tinggi'];
		$fontsize = $actionResult->value['fontsize'];



        if ($bulan > 0) {

            $periode = 'Bulan '.$app->months[$bulan].' '.$tahun;

        } else {

            $periode = 'Tahun '.$tahun;

        }
       

        //Persiapkan PDF-nya
        $pdf = new Report('Rekapitulasi '.$objObyek->obyNama.' '.$periode, 'Rekapitulasi '.$objObyek->obyNama.' '.$periode.'.pdf', $app->getUser()->name, $app->name);


		$pdf->create();

		$pdf->pdf->pageWidth = $lebar;
		$pdf->pdf->pageHeight = $tinggi;
		$pdf->pdf->SetFont($pdf->pdf->fontFamily, $pdf->pdf->fontStyle, $fontsize);

		$pdf->addPage($orientasi);

		ob_start();
?>

        <p style="text-align:center;">
            <b>
                BADAN PENDAPATAN DAERAH KABUPATEN KAMPAR<br>
    			REKAPITULASI <?php echo strtoupper($objObyek->obyNama); ?><br>
			    <?php echo strtoupper($periode); ?>
            </b>
        </p>

<?php

        $cols = array(5,10,10,25,12,20,18);


        if (array_sum($cols) != 100) {

            debux("Total persentase tidak sama dengan 100");

        }

?>

		<table border="1" cellpadding="2" cellspacing="0" width="100%">

		<thead>

            <tr style="background-color:lightgray;">

                <?php $colNo = 0; ?>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No.</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>No. SKPD</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Tgl. Setoran</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Nama Wajib Pajak</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>NIK</b></th>

				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Alamat</b></th>


				<th style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><b>Jumlah<br>(Rp)</b></th>

			</tr>

            <tr style="background-color:lightgray;">

<?php

        foreach (array_keys($cols) as $k) {

?>

                <th style="text-align:center;"><i><?php echo $k + 1; ?></i></th>

<?php

        }

?>

			</tr>

		</thead>

		<tbody>

<?php

		if (count($data) > 0) {

			$i = 1;

			$totalPokok = 0;            

			foreach ($data as $v) {

				$totalPokok += $v->ssJumlahSetorPokok;
?>

			<tr nobr="true">

                <?php $colNo = 0; ?>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $i; ?></td>

				<td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $v->skpNoLengkap; ?></td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">

                    <?php echo $app->MySQLDateToNormal($v->ssTglSetor); ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">
<?php

				echo strtoupper($v->nama);
?>
				</td>

                <td style="text-align:center;" width="<?php echo $cols[$colNo++]; ?>%">
                    <?php echo !empty($v->wpNIK) ? $v->wpNIK : '-'; ?>

                </td>

				<td width="<?php echo $cols[$colNo++]; ?>%">

<?php
				echo strtoupper($v->alamat);
?>

                </td>
				<td style="text-align:right;" width="<?php echo $cols[$colNo++]; ?>%"><?php echo $app->MySQLToMoney($v->ssJumlahSetorPokok, 2); ?></td>
			</tr>
<?php

				$i++;

			}

?>

			<tr>

				<td colspan="<?php echo count($cols) - 1; ?>" style="text-align:center;"><b>JUMLAH</b></td>

				<td style="text-align:right;"><b><?php echo $app->MySQLToMoney($totalPokok, 2); ?></b></td>


			</tr>

<?php

		} else {

?>

			<tr>

				<td colspan="9">Tidak ada</td>

			</tr>

<?php

		}

?>

		</tbody>

		</table>

<?php

        $content = ob_get_contents();

        ob_clean();



        $pdf->writeHTML($content);



        $pdf->output();

	}

	/**

	 * Menampilkan halaman index

	 */

	public function index() {

		global $app;

?>

	<div class="container-fluid app-container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form action="<?php echo $app->site; ?>/admin/<?php echo $app->act; ?>/export" method="get" target="_blank">
					<input type="hidden" name="html" value="0">
					<div class="pmd-card app-entry-card">
						<div class="pmd-card-title">
							<div class="media-left">
								<span class="material-icons md-dark pmd-sm"><?php echo $this->icon; ?></span>
							</div>
							<div class="media-body media-middle">
								<h2 class="pmd-card-title-text typo-fill-secondary">
									<a href="<?php echo $app->site; ?>/admin/<?php echo $app->act; ?>">
										<?php echo $this->title; ?>
									</a>
								</h2>
							</div>
						</div>
						<div class="pmd-card-body">
                			<div class="group-fields clearfix row">
                				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                					<div class="form-group form-group-sm">

                						<label for="obyek" class="control-label">

                							Jenis Penerimaan

                						</label>

<?php

		$sql = "SELECT obyID AS id, obyNama AS name
				FROM obyek
				WHERE obyID != 10 AND obyID != 12
				ORDER BY obyNama ASC";

		$obyek = $app->queryArrayOfObjects($sql);

		$this->createSelect('obyek', $obyek, 0, array(), 'select-with-search form-control pmd-select2');

?>

                                        <span class="pmd-textfield-focused"></span>

                                    </div>

                				</div>

                			</div>

							<div class="group-fields clearfix row">

								<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">

									<div class="form-group form-group-sm">

										<label for="bulan" class="control-label">

											Bulan

										</label>

<?php

		$this->createSelect('bulan', $app->months, 0, array(0=>'Seluruh Bulan'), 'select-with-search form-control pmd-select2');

?>

                                        <span class="pmd-textfield-focused"></span>

									</div>

								</div>

								<div class="col-lg-1 col-md-1 col-sm-6 col-xs-6">

									<div class="form-group form-group-sm">

										<label for="tahun" class="control-label">

											Tahun

										</label>

										<input type="number" class="form-control" id="tahun" name="tahun" maxlength="10" value="<?php echo date('Y'); ?>" required>

										<span class="pmd-textfield-focused"></span>

									</div>

								</div>

							</div>

							<div class="group-fields clearfix row" style="background-color: antiquewhite;">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

									<b>Pengaturan PDF</b>

								</div>

							</div>

							<div class="group-fields clearfix row">

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

									<div class="form-group form-group-sm">

										<label for="orientasi" class="control-label">

											Orientasi

										</label>

<?php

		$opsi = array(

            'P'=>'Portrait',

		    'L'=>'Landscape'

		);

		$this->createSelect('orientasi', $opsi, 'P', array(), 'select-simple form-control pmd-select2');

?>

										<span class="pmd-textfield-focused"></span>

									</div>

								</div>

							</div>

							<div class="group-fields clearfix row">

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

									<div class="form-group form-group-sm">

										<label for="lebar" class="control-label">

											Lebar

										</label>

										<input type="number" class="form-control" id="lebar" name="lebar" min="1" value="215">

										<span class="pmd-textfield-focused"></span>

									</div>

								</div>

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

									<div class="form-group form-group-sm">

										<label for="tinggi" class="control-label">

											Tinggi

										</label>

										<input type="number" class="form-control" id="tinggi" name="tinggi" min="1" value="330">

										<span class="pmd-textfield-focused"></span>

									</div>

								</div>

							</div>

							<div class="group-fields clearfix row">

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

									<div class="form-group form-group-sm">

										<label for="fontsize" class="control-label">

											Ukuran Font

										</label>

										<input type="number" class="form-control" id="fontsize" name="fontsize" min="1" value="10">

										<span class="pmd-textfield-focused"></span>

									</div>

								</div>

							</div>

						</div>

						<div class="pmd-card-actions">

							<button type="submit" class="btn btn-primary" name="btnExport" value="PDF">PDF</button>

							<button type="submit" class="btn btn-success" name="btnExport" value="Excel">MS. Excel</button>

						</div>

					</div>

				</form>

			</div>

		</div>

	</div>

<?php

	}

}

?>

