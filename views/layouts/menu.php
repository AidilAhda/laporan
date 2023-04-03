<?php

use app\components\Helper;
use yii\helpers\Url;
use app\widgets\AuthUser;
use app\models\SdmMPegawai;


?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Url::base(); ?>/images/logo_sirindit.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>PELAPORAN RSUD</p>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li <?=Yii::$app->controller->id=="site" ? 'class="active"' : ""?>><a
                    href="<?php echo Url::to(['/site']) ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li <?=Yii::$app->controller->id=="monitoring" ? 'class="active"' : ""?>><a
                    href="<?php echo Url::to(['/monitoring']) ?>"><i class="fa fa-dashboard"></i>
                    <span>Monitoring</span></a></li>
            <li <?=Yii::$app->controller->id=="laporan" ? 'class="active"' : ""?>><a
                    href="<?php echo Url::to(['/cetak-laporan']) ?>"><i class="fa fa-dashboard"></i> <span>Rekap Pasien
                        RI</span></a></li>

            <li class="treeview " style="height: auto;">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo Url::to(['/cetak-laporan/diagnosa']) ?>" class="nav-link">
                            <i class="fa fa-circle-o"></i>Diagnosa
                        </a>
                    </li>

                    <li <?=Yii::$app->controller->id=="sdm-riwayat-cuti/approval" ? 'class="active"' : ""?>>
                        <a href="<?php echo Url::to(['/cetak-laporan/kunjungan-pasien']) ?>" class="nav-link">
                            <i class="fa fa-circle-o"></i>Kunjungan Pasien
                        </a>
                    </li>

                    <li <?=Yii::$app->controller->id=="sdm-riwayat-cuti/approval" ? 'class="active"' : ""?>>
                        <a href="<?php echo Url::to(['/cetak-laporan/laporan-farmasi']) ?>" class="nav-link">
                            <i class="fa fa-circle-o"></i>Farmasi
                        </a>
                    </li>

                </ul>
            </li>
            <li <?=Yii::$app->controller->id=="indexing" ? 'class="active"' : ""?>><a
                    href="<?php echo Url::to(['/site']) ?>"><i class="fa fa-dashboard"></i> <span>indexing</span></a>
            </li>

            <li <?=Yii::$app->controller->id=="pelaporan-emr" ? 'class="active"' : ""?>><a
                    href="<?php echo Url::to(['/pelaporan-emr']) ?>"><i class="fa fa-dashboard"></i> <span>Pelaporan
                        EMR</span></a></li>

        </ul>
    </section>
</aside>