<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Jadwaloh */

$this->title = 'Pengaturan Jadwal OH';
?>
<div class="jadwaloh-create">

    <h1><?php //Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        "kegiatanDropdown" => $kegiatanDropdown,
        'model' => $model,
        "tanggal" => $tanggal,
        "username" => $username,
        "seksi" => $seksi,
    ]) ?>

</div>
