<?php

$rows = $dataProvider->getModels();
$data = json_encode($rows, JSON_PRETTY_PRINT);
$data2 = json_decode($data);

$url = '/sitekad/frontend/web/index.php?r=jadwaloh%2Findex&amp;tahun=2019&amp;bulan=02&amp;';

?>

<?php
\edofre\floatthead\FloatThead::widget(
    [
        'table_id' => 'table-id',
        'options'  => [
            'position'        => 'fixed',
            'scrollContainer' => true,
        ],
    ]
);
?>

<div class="scrolling outer">
    <div class="inner">
    <?php //print_r($data2) ?>
    <div class='wrapper small' style="overflow: auto; height: 300px;">
        <table id="table-id" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><a class="asc" href="<?= $url; ?>sort=-Nama" data-sort="-Nama">Nama</a></th>
                    <th><a href="<?= $url; ?>sort=%CE%A3" data-sort="Σ">Σ</a></th>
                    <?php
                        for ($i=1; $i <= $jumlahHari; $i++) { 
                            //menentukan warna untuk weekend
                            $warna = "white";
                            $isWeekend = date('N', strtotime($tahun . "-" . $bulan . "-" . $i)) >= 6;
                            if($isWeekend) $warna = "#c7ecee";
                            echo '<th style="background-color:'. $warna . '"><a href="' . $url . 'sort=' . $i . '" data-sort="'. $i .'">' . $i . '</a></th>';
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr data-key="0">
                    <td class='oke'>admin</td>
                    <td class='oke2'>3</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white">Y</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">
                </tr>
                <tr data-key="1">
                    <td class='oke'>derma</td>
                    <td>5</td>
                    <td style="background-color:white">Y</td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                </tr>
                <tr data-key="2">
                    <td class='oke'>imanda</td>
                    <td>0</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>
                <tr data-key="3">
                    <td class='oke'>sosial</td>
                    <td>2</td>
                    <td style="background-color:white"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:#c7ecee"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white"></td>
                    <td style="background-color:white">Y</td>
                </tr>

            </tbody>
        </table>
    </div>
    </div>
</div>