<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\KegiatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kegiatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kegiatan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Kegiatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama',
            'kode',
            [
                "attribute" => "seksi",
                "value" => 'kegiatanSeksi.nama'
            ],
            //[
              //  "attribute" => "periode",
                //"value" => 'kegiatanPeriode.periode'
            //],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },
        
                    'update' => function ($url, $model) {
                        if($model->created_by==\Yii::$app->user->id) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'lead-update'),
                            ]);
                        }
                            
                    },
                    'delete' => function ($url, $model) {
                        if($model->created_by==\Yii::$app->user->id) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title'        => 'delete',
                                'data-confirm' => Yii::t('yii', 'Apakah Anda yakin menghapus kegiatan ini?'),
                                'data-method'  => 'post',
                            ]);
                        }
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url ='index.php?r=kegiatan/view&id='.$model->id;
                        return $url;
                    }
        
                    if ($action === 'update') {
                        $url ='index.php?r=kegiatan/update&id='.$model->id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url ='index.php?r=kegiatan/delete&id='.$model->id;
                        return $url;
                    }
    
                }
            ],
        ],
    ]); ?>
</div>
