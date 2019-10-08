<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Seksi */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Seksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="seksi-view">

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
            //'id',
            'nama',
            [
                'label'=>'Dibuat',
                //'value'=>$model->functionName($data),
                'value'=> date("d-m-Y H:i:s",$model->created_at) . " oleh " . $model->seksiUserCreatedBy->username,
            ],
            [
                'label'=>'Diperbarui',
                //'value'=>$model->functionName($data),
                'value'=> date("d-m-Y H:i:s",$model->updated_at) . " oleh " . $model->seksiUserUpdatedBy->username,
            ],
        ],
    ]) ?>

</div>
