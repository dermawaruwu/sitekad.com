<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Kegiatan */

$this->title = 'Update Kegiatan: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Kegiatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kegiatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        "periodeDropdown" => $periodeDropdown,
        "seksiDropdown" => $seksiDropdown,
        'model' => $model,
    ]) ?>

</div>
