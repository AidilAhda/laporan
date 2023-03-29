<?php
namespace app\assets;
use yii\web\AssetBundle;
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/fontawesome/css/font-awesome.min.css',
        'styles/adminlte.min.css',
        'styles/skins/skin-green.min.css',
        'plugins/pace/pace.css',
        'plugins/toastr/toastr.min.css',
        'styles/app.css',
    ];
    public $js = [
        'scripts/adminlte.min.js',
        'plugins/pace/pace.js',
        'plugins/toastr/toastr.min.js',
        'scripts/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
