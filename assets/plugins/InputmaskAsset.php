<?php
namespace app\assets\plugins;
use yii\web\AssetBundle;
class InputmaskAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'plugins/inputmask/jquery.inputmask.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
