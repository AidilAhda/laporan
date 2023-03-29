<?php
namespace app\assets;
use yii\web\AssetBundle;
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'iofrm/css/bootstrap.min.css',
        'iofrm/css/fontawesome-all.min.css',
        'iofrm/css/iofrm-style.css',
        'iofrm/css/iofrm-theme8.css'
    ];
    public $js = [
        'iofrm/js/bootstrap.min.js',
        'iofrm/js/jquery.min.js',
        'iofrm/js/main.js',
        'iofrm/js/popper.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
