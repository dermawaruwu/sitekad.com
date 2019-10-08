<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Jadwaloh;
use frontend\models\JadwalohSearch;
use frontend\models\Pegawai;
use frontend\models\User;
use frontend\models\Analisis;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use frontend\models\Kegiatan;
use yii\helpers\ArrayHelper;


/**
 * AnalisisController .
 */
class AnalisisController extends Controller
{
    public function actionPerorang($bulan, $tahun, $analisis){
        
        return $this->render('perorang', [
            "bulan" => $bulan,
            "tahun" => $tahun,
            "analisis" => $analisis
        ]);
    }
    public function actionPerseksi($bulan, $tahun, $analisis){
        return $this->render('perseksi', [
            "bulan" => $bulan,
            "tahun" => $tahun,
            "analisis" => $analisis
        ]);
    }

    public function actionRekapPerseksi($bulan, $tahun, $analisis){
        return $this->render('rekap', [
            "bulan" => $bulan,
            "tahun" => $tahun,
            "analisis" => $analisis
        ]);
    }

    public function actionJumlahohPerOrang($jenisGrafik, $bulan, $tahun){

        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tanggalAwal = $tahun . "-" . $bulan . "-" . "1";
        $tanggalAkhir = $tahun . "-" . $bulan . "-" .$jumlahHari;

        // Mengambil id, nama pegawai, dan tanggal OH 
        $pegawai = new Pegawai();
        $userIsPegawai = json_decode($pegawai->getUserIsPegawai(), true);
        $jumlahPegawai = sizeof($userIsPegawai);

        $jumlahOH;

        $jumlahOH[0]["name"] = "Pegawai";
        $jumlahOH[0]["type"] = $jenisGrafik;
        for ($i=0; $i < $jumlahPegawai; $i++) { 
            $jumlahOH[0]["data"][] = (int)$this->actionGetJumlahOHPerOrang($userIsPegawai[$i]["id"], $tanggalAwal, $tanggalAkhir);
            $jumlahOH[0]["xaxis"][] = $userIsPegawai[$i]["username"];
        }

        if(count($jumlahOH[0]["data"])) {
            $jumlahOH[0]["rerata"] = array_sum($jumlahOH[0]["data"])/count($jumlahOH[0]["data"]);
        }

        return json_encode($jumlahOH, JSON_PRETTY_PRINT);
    }

    public function actionGetJumlahOHPerOrang($userId, $tanggalAwal, $tanggalAkhir){
        
        $jumlahOHPerOrang = new Analisis();

        return $jumlahOHPerOrang->getJumlahOHPerOrang($userId, $tanggalAwal, $tanggalAkhir);  
    
    }

    public function actionJumlahohPerSeksi($jenisGrafik, $bulan, $tahun){

        $daftarSeksi = \json_decode($this->actionSeksi(), TRUE);

        $jumlahOHPerSeksi;
        for ($i=0; $i < \sizeof($daftarSeksi); $i++) { 
            $jumlahOHPerSeksi["content"][$i]["y"] = (int)$this->actionOhPerSeksi(
                $daftarSeksi[$i]["id"], 
                $bulan, 
                $tahun
            );
            $jumlahOHPerSeksi["content"][$i]["name"] = $daftarSeksi[$i]["nama"];
            $jumlahOHPerSeksi["content"][$i]["color"] = $daftarSeksi[$i]["warna"];
            $jumlahOHPerSeksi["content"][$i]["sliced"] = TRUE;
        }

        return json_encode($jumlahOHPerSeksi, JSON_PRETTY_PRINT); 
    }

    public function actionOhPerSeksi($seksiId, $bulan, $tahun ){

        $analisis = new Analisis();

        return $analisis->getOHPerSeksi($seksiId, $bulan, $tahun);
    }

    public function actionSeksi(){
        $analisis = new Analisis();

        return $analisis->getDaftarSeksi();
    }

    public function actionPegawaiSeksi(){
        $daftarSeksi = \json_decode($this->actionSeksi(), TRUE);
        
        $OHPerSeksi = [];
        for ($i=0; $i < sizeof($daftarSeksi) ; $i++) { 
            # code...
        }
        
        // SELECT k.id, k.nama, COUNT(*) AS jumlah
        // FROM jadwaloh AS j 
        // RIGHT JOIN kegiatan AS k ON j.kegiatan = k.id
        // GROUP BY k.id
        // HAVING jumlah > 1

        $query = new Query();
        $query->select("k.id, k.nama, COUNT(*) AS jumlah")
            ->from("jadwaloh AS j")
            ->rightJoin("kegiatan AS k", "k.id = j.kegiatan")
            ->andFilterWhere(['between', 'j.tanggal', $tanggalAwal, $tanggalAkhir ])
            ->andFilterWhere(['j.isDeleted' => 0])
            ->andFilterWhere(['k.isDeleted' => 0])
            ->groupBy("k.id")
            ->all();

        $jsonArray = [];

        foreach ($datas as $data) {
            $jsonArray[] = [
                "id" => $data["id"],
                "nama" => $data["nama"],
                "warna" => $data["warna"],
            ];
        }

        return json_encode($jsonArray, JSON_PRETTY_PRINT);
    }

}
