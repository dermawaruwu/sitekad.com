<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SeksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seksi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Tambah Seksi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nama',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            [

                'class' => 'yii\grid\ActionColumn',
            
                'template' => '{view} {update}',
            
            ],
        ],
    ]); ?>
</div>
