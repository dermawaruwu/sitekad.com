<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/dataTables.min.css',
        'css/fixedColumns.dataTables.min.css',
        'css/buttons.dataTables.min.css',
        'css/tampil.css',
    ];
    public $js = [
        'js/dataTables.min.js',
        'js/tampil.js',
        'js/dataTables.fixedColumns.min.js',
        'js/dataTables.buttons.min.js',
        'js/jszip.min.js',
        'js/pdfmake.min.js',
        'js/vfs_fonts.js',
        'js/buttons.html5.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
