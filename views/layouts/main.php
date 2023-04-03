<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= !empty($this->title) ? Html::encode($this->title).' - ' : '' ?>Pelaporan
        <?php echo Yii::$app->params['app']['full_owner_name']; ?></title>
    <link rel="shortcut icon" href="<?php echo Url::base(); ?>/images/favicon.ico" />
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>

<body class="hold-transition skin-green sidebar-collapse sidebar-mini">
    <div class="wrapper">
        <?php echo $this->render('header'); ?>
        <?php echo $this->render('menu'); ?>
        <div class="content-wrapper">
            <?php
            if(!empty($this->title)){
                ?>
            <section class="content-header">
                <h1><?= Html::encode($this->title) ?></h1>
                <?= Breadcrumbs::widget([
                        'itemTemplate' => "\n\t<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                        'activeItemTemplate' => "\t<li class=\"breadcrumb-item active\">{link}</li>\n", // template for the active link
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
            </section>
            <?php
            }
            ?>
            <section class="content"><?php echo $content; ?></section>
        </div>
    </div>
    <div class="modal fade" id="mymodal" tabindex="false" role="dialog" aria-labelledby="myModalLabel"></div>
</body>
<script>
var base_url = '<?php echo Url::base(); ?>';
</script>
<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>