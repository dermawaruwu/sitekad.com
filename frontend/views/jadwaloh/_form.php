<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use \yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Jadwaloh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jadwaloh-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3><strong><?= $username ?></strong> pada <strong><?= $tanggal ?></strong> <br><br></h3>

    <?php 
    $bulan = substr($tanggal, 3,2);
    $tahun = substr($tanggal, 6,4); 
    ?>
    

    <?php if (Yii::$app->user->isGuest ) {
        echo $form->field($model, 'kegiatan')->widget(Select2::classname(), [
            'data' => $kegiatanDropdown,
            'options' => ['placeholder' => 'Tidak Ada Kegiatan'],
            'disabled' => true,
        ])->label(false);
    } elseif ($model->isNewRecord) {
        echo $form->field($model, 'kegiatan')->widget(Select2::classname(), [
            'data' => $kegiatanDropdown,
            'options' => ['placeholder' => 'Pilih Kegiatan ... '],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
    } elseif ($model->created_by==\Yii::$app->user->id) {
        echo $form->field($model, 'kegiatan')->widget(Select2::classname(), [
            'data' => $kegiatanDropdown,
            'options' => ['placeholder' => 'Pilih Kegiatan ... '],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
    } else {
        echo $form->field($model, 'kegiatan')->widget(Select2::classname(), [
            'data' => $kegiatanDropdown,
            'options' => ['placeholder' => 'Tidak Ada Kegiatan'],
            'disabled' => true,
        ])->label(false);
    }?>
    
    <?php if ( !Yii::$app->user->isGuest && (($model->created_by==\Yii::$app->user->id) || $model->isNewRecord)) { ?> 
    <div class="form-group">
        <div class="row">
            <div class="col-lg-4">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Tambah / Create') : Yii::t('app', 'Update / Perbarui'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <div class="col-lg-4">
                <button type="button" class="btn btn-warning center-block" data-dismiss="modal">Cancel / Batal</button>
            </div>
            <div class="col-lg-4">
                <?php echo $model->isNewRecord ?  "" : 
                    Html::a(Yii::t('app', ' <i class="fa fa-fw fa-user"></i> Delete / Hapus'), [
                        'delete',
                        'id' => $model->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'seksi' => $seksi
                    ],
                    [
                        'class' => 'btn btn-danger pull-right',
                        'data' => [
                            'confirm' => Yii::t('app', 'Apakah anda yakin menghapus jadwal OH ini?'),
                            'method' => 'post',
                        ],
                    ])
                ?>
            </div>
        </div>
        
        
    </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
