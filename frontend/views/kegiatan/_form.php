<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Kegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kegiatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama', 
        ['inputOptions' => [
            "autofocus" => "autofocus",
            "class" => "form-control",
            
        ]])->textInput(); 
    ?>

    <?= $form->field($model, 'kode')->textInput(); 
    ?>
    
    <?php echo $form->field($model, 'periode')->widget(Select2::classname(), [
        'data' => $periodeDropdown,
        'options' => ['placeholder' => 'Pilih Periode ... '],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
