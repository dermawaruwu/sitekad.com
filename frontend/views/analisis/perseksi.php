<?php
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use frontend\assets\GrafikAsset;


GrafikAsset::register($this);

// Mendapatkan bulan sebelumnya
$datestring = $tahun . '-' . $bulan . ' first day of last month';
$bulanSebelum = date_create($datestring);

?>
<div class="row">
    <h3>
        <div class="col-sm-4">
            <?= Html::a(
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', 
                [
                    '/analisis/perseksi', 
                    'tahun' => $bulanSebelum->format('Y'), 
                    'bulan' => $bulanSebelum->format('m'),
                    "analisis" => $analisis
                ], 
                ['class'=>'btn btn-warning']) 
            ?> 

            <?= " &nbsp; <strong> " . (int)$bulan . " / "  . $tahun . " </strong> &nbsp; " ?>

            <?php
            // Mendapatkan bulan sesudahnya
            $datestring = $tahun . '-' . $bulan . ' +1 month';
            $bulanSesudah = date_create($datestring);
            ?>
            <?= Html::a(
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', 
                [
                    '/analisis/perseksi', 
                    'tahun' => $bulanSesudah->format('Y'), 
                    'bulan' => $bulanSesudah->format('m'),
                    "analisis" => $analisis
                ], 
                ['class'=>'btn btn-warning']) 
            ?> 
        </div>
        <div class="col-sm-4">
            
            <?php 

            
            echo ButtonDropdown::widget([
                'label' => $analisis, 
                'dropdown' => [
                    'items' => [
                        ['label' => 'OH Per Pegawai', 'url' => [
                            'analisis/perorang', 
                            'bulan' => $bulan, 
                            "tahun" => $tahun,
                            "analisis" => "OH Per Pegawai",
                        ]],
                        ['label' => 'OH Per Seksi', 'url' => [
                            'analisis/perseksi', 
                            'bulan' => $bulan, 
                            "tahun" => $tahun,
                            "analisis" => "OH Per Seksi",

                        ]]
                    ],
                ],
                'options' => ['class' => 'btn btn-primary']
            ]); 
            ?>
        </div>
        <div class="col-sm-4">
            
            <?php
            
            ?>
        </div>
    </h3>
</div>
<br><br>
<div id="perSeksi" style="width:100%; height:400px;"></div>