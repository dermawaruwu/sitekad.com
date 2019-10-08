<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Kegiatan */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kegiatan-view">

    <h1><?= Html::encode($this->title) ?></h1>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            [
                'label'=>'Seksi',
                'value'=> $model->kegiatanSeksi->nama,
            ],
            [
                'label'=>'Periode',
                'value'=> $model->kegiatanPeriode->periode,
            ],
            [
                'label'=>'Dibuat',
                'value'=> date("d-m-Y H:i:s",$model->created_at) . " oleh " . $model->kegiatanUserCreatedBy->username,
            ],
            [
                'label'=>'Diperbarui',
                'value'=> date("d-m-Y H:i:s",$model->updated_at) . " oleh " . $model->kegiatanUserUpdatedBy->username,
            ],
        ],
    ]) ?>

</div>
