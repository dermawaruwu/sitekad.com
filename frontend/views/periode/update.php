<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Periode */

$this->title = 'Update Periode: ' . $model->periode;
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->periode, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="periode-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
