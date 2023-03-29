<?php
namespace app\assets\pages;
use yii\web\AssetBundle;
class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'pages/index/style.css'
    ];
    public $js = [
        'pages/index/script.js'
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];
}
