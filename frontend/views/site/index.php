<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Beranda';
date_default_timezone_set("Asia/Jakarta");

$tahun = date('Y');
$bulan = date('m');
$datestring = $tahun . '-' . $bulan . ' first day of last month';
$bulanSebelum = date_create($datestring);

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>SITEKAD</h1>

        <p class="lead"><strong>S</strong>istem <strong>I</strong>nformasi <strong>TEK</strong>nis dan <strong>AD</strong>ministrasi</p>

         <?= Html::a('Klik untuk Masuk ke Matriks OH', [
            '/jadwaloh/tampil', 
            "tahun" => $tahun, 
            "bulan" => $bulanSebelum->format('m'),
            "seksi" => "all",
        ], ['class'=>'btn btn-success']) ?>
    </div>

    
</div>
