<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= 'SITEKAD - ' . Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    $tahun = date('Y');
    $bulan = date('m');
    $datestring = $tahun . '-' . $bulan . ' first day of last month';
    $bulanSebelum = date_create($datestring);

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        
        //['label' => 'Tentang', 'url' => ['/site/about']],

        ['label' => 'Matriks', 'url' => [
            '/jadwaloh/tampil', 
            "tahun" => $tahun, 
            "bulan" => $bulanSebelum->format('m'), 
            "seksi" => "all",
        ]],
        [
            "label" => 'Analisis', 'url' => [
                '/analisis/perorang',
                "tahun" => $tahun, 
                "bulan" => $bulanSebelum->format('m'),
                "analisis" => "OH Per Pegawai",
            ],
        ]
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        //$menuItems[] = ['label' => 'Tambah User', 'url' => ['/site/signup']]; 
    } else {
        $menuItems[] = [
            'label' => 'Master',
            'items' => [
                ['label' => 'Kegiatan', 'url' => ['/kegiatan/index']],
                ['label' => 'Periode', 'url' => ['/periode/index']],
                ['label' => 'Seksi', 'url' => ['/seksi/index']]
            ],
        ]; 
        //$menuItems[] = ['label' => 'Tambah User', 'url' => ['/site/signup']]; 
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> developed by Derma Waruwu</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
