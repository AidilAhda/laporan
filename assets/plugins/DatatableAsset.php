<?php
namespace app\assets\plugins;
use yii\web\AssetBundle;
class DatatableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/datatable/datatables.min.css',
    ];
    public $js = [
        'plugins/datatable/datatables.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
