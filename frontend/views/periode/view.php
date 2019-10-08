<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Periode */

$this->title = $model->periode;
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="periode-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'periode',
            [
                'label'=>'Dibuat',
                'value'=> date("d-m-Y H:i:s",$model->created_at) . " oleh " . $model->periodeUserCreatedBy->username,
            ],
            [
                'label'=>'Diperbarui',
                'value'=> date("d-m-Y H:i:s",$model->updated_at) . " oleh " . $model->periodeUserUpdatedBy->username,
            ],
        ],
    ]) ?>

</div>
