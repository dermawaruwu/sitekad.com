<?php

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

// Mendapatkan bulan sebelumnya
$datestring = $tahun . '-' . $bulan . ' first day of last month';
$bulanSebelum = date_create($datestring);

?>

<?php
Modal::begin([
    'header' => '<h3>Pengaturan Jadwal OH</h3>',
    'id' => 'modalTampil',
    'size' => 'modal-lg',
    'options' => ['tabindex' => ''], //penting untuk Select2 dalam modal popup
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>

<div class="row">
    <h3>
        <div class="col-sm-4">
            <?= Html::a(
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', 
                ['/jadwaloh/tampil', 'tahun' => $bulanSebelum->format('Y'), 'bulan' => $bulanSebelum->format('m'), "seksi" => $seksiDropdown], 
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
                ['/jadwaloh/tampil', 'tahun' => $bulanSesudah->format('Y'), 'bulan' => $bulanSesudah->format('m'), "seksi" => $seksiDropdown], 
                ['class'=>'btn btn-warning']) 
            ?> 
        </div>
        <div class="col-sm-4">
            
            <?php 

            switch ($seksiDropdown) {
                case "13":
                    $seksiDropdownLabel = "Tata Usaha";
                    break;
                case "14":
                    $seksiDropdownLabel = "Distribusi";
                    break;
                case "15":
                    $seksiDropdownLabel = "IPDS";
                    break;
                case "16":
                    $seksiDropdownLabel = "Sosial";
                    break;
                case "17":
                    $seksiDropdownLabel = "Produksi";
                    break;
                case "18":
                    $seksiDropdownLabel = "NWAS";
                    break;
                default:
                    $seksiDropdownLabel = "Semua Seksi";

            }
            echo ButtonDropdown::widget([
                'label' => $seksiDropdownLabel, 
                'dropdown' => [
                    'items' => [
                        ['label' => 'Semua Seksi', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 'all']],
                        ['label' => 'Tata Usaha', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 13]],
                        ['label' => 'Distribusi', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 14]],
                        ['label' => 'IPDS', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 15]],
                        ['label' => 'NWAS', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 18]],
                        ['label' => 'Sosial', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 16]],
                        ['label' => 'Produksi', 'url' => ['jadwaloh/tampil', 'bulan' => $bulan, "tahun" => $tahun, "seksi" => 17]],
                        
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

<br>

<table id="tampil" class="cell-border hover" style="width:100%">
    <thead>
        <tr>
            <th>Nama</th>  
            <?php
                for ($i=1; $i <= $jumlahHeader; $i++) { 
                    //menentukan warna untuk weekend
                    $warna = "white";
                    $isWeekend = date('N', strtotime($tahun . "-" . $bulan . "-" . $i)) >= 6;
                    if($isWeekend) $warna = "#FF5733";
                    echo '<th style="background-color:'. $warna . '">' . $i . '</th>';
                }
            ?>
            <th>Σ</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i=0; $i < $jumlahPegawai; $i++) {  
            echo "<tr>";   
            echo "<td>" . $tanggalOHs[$i][0] . "</td>";
            for ($j=1; $j <= $jumlahHeader; $j++) { 
                //echo '<td style="background-color: #c7ecff">' . $tanggalOHs[$i][$j]["seksi"] . '</td>';
                $seksi = $tanggalOHs[$i][$j]["seksi"];
                $idJadwal = $tanggalOHs[$i][$j]["id"];
                $cellId = "";
                if ($idJadwal == "nol") {
                    $cellId = $tahun . "-" . $bulan . "-" . sprintf("%02d", $j) . "£" . $tanggalOHs[$i][$jumlahHeader+2] . "_" . $tanggalOHs[$i][0];
                } else {
                    $cellId = $tahun . "-" . $bulan . "-" . sprintf("%02d", $j) . "μ" . $idJadwal . "_" . $tanggalOHs[$i][0];
                }
                
                switch ($seksi) {
                    case "13":
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #c7ecff">' . "TU" . '</td>';
                        break;
                    case "14":
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #F1C40F">' . "Dis" . '</td>';
                        break;
                    case "15":
                        //echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #58D68D">' . "✔IPD" . '</td>';
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #58D68D">' . "IPD" . '</td>';
                        break;
                    case "16":
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #f8a5c2">' . "Sos" . '</td>';
                        break;
                    case "17":
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #d5b8ff">' . "Pro" . '</td>';
                        break;
                    case "18":
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: #f3a683">' . "Ner" . '</td>';
                        break;
                    default:
                        echo '<td class="tanggalOH" id="' . $cellId . '" style="background-color: white">' . "" . '</td>';

                }
            }
            echo "<td>" . $tanggalOHs[$i][$jumlahHeader+1] . "</td>";
            echo "</tr>";
        } ?>
        
        
        
    </tbody>
</table>