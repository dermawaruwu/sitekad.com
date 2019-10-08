<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;

/**
 * This is the model class for table "USer" - isPegawai.
 *
 */
class Pegawai extends Model
{

    /**
     * This is the function to get who is user that is pegawai, not admin.
     *
     */
    public function getUserIsPegawai(){
        
        $query = new Query();

        $query->select("
                id,
                username
            ")
            ->from("user")
            ->where(['like', 'isPegawai', 1])
            ->orderBy("username ASC")
            ->all();

        $jumlah = $query->count();
        $command = $query->createCommand();
        $datas = $command->queryAll();

        $jsonArray = [];

        foreach ($datas as $data) {
            $jsonArray[] = [
                "id" => $data["id"],
                "username" => $data["username"]
            ];
        }

        return json_encode($jsonArray, JSON_PRETTY_PRINT);
        
    }


    /**
     * This is the function to get tanggal OH by user.
     *
     */
    public function getTanggalByUser($userId, $username, $jumlahHari, $tanggalAwal, $tanggalAkhir, $seksi){

        $query = new Query();

        // $query->select("
        //         j.id AS id,
        //         j.tanggal AS tanggalKegiatan,
        //         k.kegiatan_nama AS namaKegiatan,
        //         s.status_nama AS namaStatus
        //         ")
        //     ->from("jadwaloh AS j")
        //     ->where(['user_id' => $user_id])
        //     ->innerJoin("status AS s", "s.status_id = j.status_id")
        //     ->innerJoin("kegiatan AS k", "k.kegiatan_id = j.kegiatan_id")
        //     ->all(); 

        $query->select("
                j.id AS id,
                j.user AS user,
                k.seksi AS seksi,
                j.tanggal AS tanggal
            ")
            ->from("jadwaloh AS j")
            ->innerJoin("kegiatan AS k", "k.id = j.kegiatan")
            ->where(['between', 'j.tanggal', $tanggalAwal, $tanggalAkhir ])
            ->andFilterWhere(['j.isDeleted' => 0])
            ->andFilterWhere(['k.isDeleted' => 0])
            ->andFilterWhere(['like', 'j.user', $userId]);
        
        if($seksi != "all") {
            $query->andFilterWhere(["k.seksi" => $seksi]);
        }    
            
        $query->all();

        $jumlah = $query->count();
        $command = $query->createCommand();
        $datas = $command->queryAll();

        $jsonArray = [];
        
        if ($datas) {
            foreach ($datas as $data) {
                $jsonArray [] = [
                    "tanggal" => (int)substr($data["tanggal"], -2),
                    "id" => $data["id"],
                    "seksi" => $data["seksi"]
                ];
            }
        } 

        $tanggalContent = [];
        $tanggalContent[0] = $username;
        for ($i=1; $i <= $jumlahHari; $i++) {
            $temp = false;
            for ($j=0; $j < $jumlah; $j++) { 
                if ($i == $jsonArray[$j]["tanggal"]) {
                    $tanggalContent[$i] = [
                        "id" => $jsonArray[$j]["id"],
                        "tanggal" => $jsonArray[$j]["tanggal"],
                        "seksi" => $jsonArray[$j]["seksi"],
                    ];
                    $temp = true;
                }
            }
            if(!$temp){
                $tanggalContent[$i] = [
                    "id" => "nol",
                    "tanggal" => $i,
                    "seksi" => "",
                ];
            } 
        }
            // if (in_array($i, $jsonArray)) {
            //     $tanggalContent [$i]= "Y";
            // } else {
            //     $tanggalContent [$i] = "";
            // }
            
            // ;
        

        $tanggalContent[$jumlahHari+1] = $jumlah;
        $tanggalContent[$jumlahHari+2] = $userId;

        return json_encode($tanggalContent, JSON_PRETTY_PRINT);
    }

    public function cekJadwaloh($user, $tanggal){
        $query = new Query();

        $query->select("id")
            ->from("jadwaloh")
            ->where(["user" => $user])
            ->andFilterWhere(["tanggal" => $tanggal])
            ->all();

        $jumlah = $query->count();
        $command = $query->createCommand();
        $datas = $command->queryAll();

        $jsonArray;

        if($jumlah > 0){
            foreach ($datas as $data) {
                $jsonArray = [
                    "status" => "ada",
                    "idJadwaloh" => $data["id"]
                ];
            }
        } else {
            $jsonArray['status'] = "kosong";
        }

        return json_encode($jsonArray, JSON_PRETTY_PRINT);
        //return $jsonArray;
    }
}