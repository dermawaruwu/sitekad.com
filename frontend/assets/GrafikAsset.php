<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GrafikAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/highcharts/highcharts.js',
        'js/highcharts/exporting.js',
        //'js/highcharts/offline-exporting.js',
        'js/highcharts/export-data.js',
        'js/grafik.js',

    ];
    public $depends = [
        //'depends' => 'yii\web\JqueryAsset',
    ];
}
