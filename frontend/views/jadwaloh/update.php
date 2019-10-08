<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Jadwaloh */

$this->title = 'Update Jadwaloh: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jadwalohs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jadwaloh-update">

    <h1><?php //Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        "tanggal" => $tanggal,
        "username" => $username,
        "seksi" => $seksi,
        "kegiatanDropdown" => $kegiatanDropdown,

    ]) ?>

</div>
