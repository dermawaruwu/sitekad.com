<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;

/**
 * This is the model class for table "USer" - isPegawai.
 *
 */
class Analisis extends Model
{

    public function getJumlahOHPerOrang($userId, $tanggalAwal, $tanggalAkhir){

        if ($userId == "nol") {
            return 0;
        }

        $query = new Query();

        $query->select("id")
            ->from("jadwaloh")
            ->andFilterWhere(['between', 'tanggal', $tanggalAwal, $tanggalAkhir ])
            ->andFilterWhere(['isDeleted' => 0])
            ->andFilterWhere(['user' => $userId])
            ->all();

        $jumlah = $query->count();
        $command = $query->createCommand();
        $datas = $command->queryAll();

        return $jumlah;
    }

    public function getDaftarSeksi(){
        $query = new Query();

        $query->select("
                id,
                nama,
                warna
            ")
            ->from("seksi")
            ->andFilterWhere(['isDeleted' => 0])
            ->orderBy("nama ASC")
            ->all();

        $jumlah = $query->count();
        $command = $query->createCommand();
        $datas = $command->queryAll();

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

    public function getOHPerSeksi($seksiId, $bulan, $tahun ){

        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tanggalAwal = $tahun . "-" . $bulan . "-" . "1";
        $tanggalAkhir = $tahun . "-" . $bulan . "-" .$jumlahHari;

        $query = new Query();
        $query->select("k.id")
            ->from("jadwaloh AS j")
            ->leftJoin("kegiatan AS k", "k.id = j.kegiatan")
            ->andFilterWhere(['between', 'j.tanggal', $tanggalAwal, $tanggalAkhir ])
            ->andFilterWhere(['j.isDeleted' => 0])
            ->andFilterWhere(['k.isDeleted' => 0])
            ->andFilterWhere(['k.seksi' => $seksiId])
            ->all();

        $jumlah = $query->count();
        $command = $query->createCommand();
        $datas = $command->queryAll();

        return $jumlah;
    }

    
}