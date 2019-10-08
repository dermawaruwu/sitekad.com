<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Jadwaloh;
use frontend\models\JadwalohSearch;
use frontend\models\Pegawai;
use frontend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use frontend\models\Kegiatan;
use yii\helpers\ArrayHelper;


/**
 * JadwalohController implements the CRUD actions for Jadwaloh model.
 */
class JadwalohController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCoba(){
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
            ->where(['between', 'j.tanggal', "2019-02-01", "2019-02-28" ])
            ->andFilterWhere(['like', 'j.user', 1])
            ->all();

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
        $tanggalContent[0] = "admin";
        for ($i=1; $i <= 28; $i++) {
            $temp = false;
            for ($j=0; $j < $jumlah; $j++) { 
                if ($i == $jsonArray[$j]["tanggal"]) {
                    // $tanggalContent[$i] = [
                    //     "id" => $jsonArray[$j]["id"],
                    // ];
                    echo  " c " . $jsonArray[$j]["tanggal"] . " c ";
                    $temp = true;
                }
            }
            if(!$temp){
                echo $i;
            } 
        }
    }

    public function actionData(){

        $tahun = 2019;
        $bulan = 2;
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tanggalAwal = $tahun . "-" . $bulan . "-" ."1";
        $tanggalAkhir = $tahun . "-" . $bulan . "-" .$jumlahHari;

        // Menggenerate header tabel jadwal dinamis, sesuai dengan bulan dan tahun
        $tanggalHeader;
        $tanggalHeader[0] = "Nama";
        $tanggalHeader[1] = "Σ";
        for ($i=2; $i <= $jumlahHari+1; $i++) { 
            $tanggalHeader[$i] = $i;
        }

        // Mengambil id dan nama pegawai dari tabel user
        $pegawai = new Pegawai();
        $userIsPegawai = json_decode($pegawai->getUserIsPegawai(), true);
        $daftarTanggalOH;
        $jumlahPegawai = sizeof($userIsPegawai);
        for ($i=0; $i < $jumlahPegawai; $i++) { 
            // $daftarTanggalOH[$i] = json_decode($pegawai->getTanggalByUser(
            //     $userId = $userIsPegawai[$i]["id"],
            //     $username = $userIsPegawai[$i]["username"],
            //     $jumlahHari = $jumlahHari,
            //     $tanggalAwal = $tanggalAwal,
            //     $tanggalAkhir = $tanggalAkhir
            // ));
        }
        $daftarTanggalOH[$i] = json_decode($pegawai->getTanggalByUser(
            $userId = $userIsPegawai[0]["id"],
            $username = $userIsPegawai[0]["username"],
            $jumlahHari = $jumlahHari,
            $tanggalAwal = $tanggalAwal,
            $tanggalAkhir = $tanggalAkhir
        ));
        return json_encode($daftarTanggalOH, JSON_PRETTY_PRINT);


        //return json_encode($tanggalHeader, JSON_PRETTY_PRINT);
    }

    public function actionTampil($bulan, $tahun, $seksi){

        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tanggalAwal = $tahun . "-" . $bulan . "-" ."1";
        $tanggalAkhir = $tahun . "-" . $bulan . "-" .$jumlahHari;

        // Menggenerate header tabel jadwal dinamis, sesuai dengan bulan dan tahun
        $headers;
        $headers[0] = "Nama";
        for ($i=1; $i <= $jumlahHari; $i++) { 
            $headers[$i] = $i;
        }
        $headers[$jumlahHari+1] = "Σ";

        // Mengambil id, nama pegawai, dan tanggal OH 
        $pegawai = new Pegawai();
        $userIsPegawai = json_decode($pegawai->getUserIsPegawai(), true);
        $daftarTanggalOH;
        $jumlahPegawai = sizeof($userIsPegawai);
        for ($i=0; $i < $jumlahPegawai; $i++) { 
            $daftarTanggalOH[$i] = json_decode($pegawai->getTanggalByUser(
                $userId = $userIsPegawai[$i]["id"],
                $username = $userIsPegawai[$i]["username"],
                $jumlahHari = $jumlahHari,
                $tanggalAwal = $tanggalAwal,
                $tanggalAkhir = $tanggalAkhir,
                $seksi = $seksi
            ));
        }

        //return json_encode($daftarTanggalOH, JSON_PRETTY_PRINT);
        
        return $this->render("tampil", [
            "headers" => $headers,
            "jumlahHeader" => $jumlahHari,
            "tanggalOHs" => json_decode(json_encode($daftarTanggalOH), True),
            "jumlahPegawai" => $jumlahPegawai,
            "tahun" => $tahun,
            "bulan" => $bulan,
            "seksiDropdown" => $seksi
        ]);
    }


    /**
     * Lists all Jadwaloh models.
     * @return mixed
     */
    public function actionIndex($tahun, $bulan)
    {

        // $tahun = date('Y');
        // $bulan = date('m');
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tanggalAwal = $tahun . "-" . $bulan . "-" ."1";
        $tanggalAkhir = $tahun . "-" . $bulan . "-" .$jumlahHari;

        // Menggenerate header tabel jadwal dinamis, sesuai dengan bulan dan tahun
        $tanggalHeader = [];
        $tanggalHeader[0]['attribute'] = "Nama";
        $tanggalHeader[$jumlahHari+1]['attribute'] = "Σ";
        for ($i=1; $i <= $jumlahHari; $i++) { 

            //menentukan warna untuk weekend
            $warna = "white";
            $isWeekend = date('N', strtotime($tahun . "-" . $bulan . "-" . $i)) >= 6;
            if($isWeekend) $warna = "#c7ecee";
            
            $tanggalHeader[$i] = [
                "attribute" => strval($i),
                'headerOptions' => ['style'=>'text-align:center', 'style' => 'background-color:' . $warna],
                'contentOptions' =>['style' => 'background-color:' . $warna],
            ]; 
        }

        //return json_encode($tanggalHeader, JSON_PRETTY_PRINT);

        // Mengambil id dan nama pegawai dari tabel user
        $pegawai = new Pegawai();
        $userIsPegawai = json_decode($pegawai->getUserIsPegawai(), true);

        $daftarTanggalOH;
        $jumlahPegawai = sizeof($userIsPegawai);
        for ($i=0; $i < $jumlahPegawai; $i++) { 
            $daftarTanggalOH[$i] = json_decode($pegawai->getTanggalByUser(
                $userId = $userIsPegawai[$i]["id"],
                $username = $userIsPegawai[$i]["username"],
                $jumlahHari = $jumlahHari,
                $tanggalAwal = $tanggalAwal,
                $tanggalAkhir = $tanggalAkhir
            ));
        }
        //return json_encode($daftarTanggalOH, JSON_PRETTY_PRINT);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $daftarTanggalOH,
            'sort' => [
                'attributes' => $tanggalHeader,
            ],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]); 

        $tanggalUntukSort;
        for ($i=1; $i <= $jumlahHari; $i++) { 
            $tanggalUntukSort[] = $i;
        }

        //return json_encode($tanggalUntukSort, JSON_PRETTY_PRINT);
        $dataUntukSort = [
            'Nama' => [
                'asc' => ['Nama' => SORT_ASC],
                'desc' => ['Nama' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'Σ' => [
                'asc' => ['Σ' => SORT_ASC],
                'desc' => ['Σ' => SORT_DESC],
                'default' => SORT_ASC
            ],
            "1","2","3","4","5","6","7","8","9","10", "11", "12", "13", "14","15","16","17",
            "18","19","20","21","22","23","24","25","26","27","28","29","30","31"
        ];

        $dataProvider->setSort([
            'attributes' => $dataUntukSort,
            'defaultOrder' => [
                'Nama' => SORT_ASC
            ]
        ]);

         return $this->render('/jadwaloh/index5', [
             "dataProvider" => $dataProvider,
             "tanggalHeader" => $tanggalHeader,
             "jumlahHari" => $jumlahHari,
             "tahun" => $tahun,
             "bulan" => $bulan
        ]);

        
    }

    public function actionFix(){
        return $this->render('fix', [
       ]);
    }

    /**
     * Displays a single Jadwaloh model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Jadwaloh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dt)
    {
        $seksi = "all";
        $model = new Jadwaloh();

        //Get Date
        $tanggalOriginal = substr($dt, 0, 10); 

        // Get User ID
        preg_match('~£(.*?)_~', $dt, $output);
        $userId = $output[1]; 

        // Get username
        $username = strval(substr($dt, strpos($dt, "_") + 1));

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $model->tanggal = $tanggalOriginal;
            $model->user = $userId;
            $model->id = \thamtech\uuid\helpers\UuidHelper::uuid();
            //return $model->tanggal;
            if($model->save()){
                return $this->redirect([
                    'tampil', 
                    'tahun' => substr($tanggalOriginal, 0, 4),
                    'bulan' => substr($tanggalOriginal, 5, 2),
                    'seksi' => $seksi
                ]);
            } else {
                return "terjadi kesalahan, hubungi Wak Ute";
            }
            
        }
       
        $tanggal = date("d-m-Y", strtotime($tanggalOriginal));
        $kegiatanDropdown = $this->kegiatanDropdownCreate();
        
        return $this->renderAjax('create', [
            "kegiatanDropdown" => $kegiatanDropdown,
            'model' => $model,
            "tanggal" => $tanggal,
            "username" => $username,
            "seksi" => $seksi,
        ]);
    }

    /**
     * Updates an existing Jadwaloh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $seksi = "all";
        //Get Date
        $tanggalOriginal = substr($id, 0, 10); 

        // Get User ID
        preg_match('~μ(.*?)_~', $id, $output);
        $jadwalohId = $output[1]; 

        
        // Get username
        $username = strval(substr($id, strpos($id, "_") + 1));
        
        $model = $this->findModel($jadwalohId);

        //return $model->userKegiatan->created_by;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect([
                'tampil', 
                'tahun' => substr($tanggalOriginal, 0, 4),
                'bulan' => substr($tanggalOriginal, 5, 2),
                'seksi' => $seksi
            ]);
        }

        $tanggal = date("d-m-Y", strtotime($tanggalOriginal));

        if ($model->userKegiatan->created_by == \Yii::$app->user->id) {
            $kegiatanDropdown = $this->kegiatanDropdownUpdateCurrent(); 
        } else {
            $kegiatanDropdown = $this->kegiatanDropdownUpdate();
        }
        

        
        return $this->renderAjax('update', [
            "kegiatanDropdown" => $kegiatanDropdown,
            'model' => $model,
            "tanggal" => $tanggal,
            "username" => $username,
            "seksi" => $seksi
        ]);
    }

    /**
     * Deletes an existing Jadwaloh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $tahun, $bulan, $seksi)
    {
        $jadwaloh = $this->findModel($id)->delete();

        return $this->redirect([
            'tampil', 
            'tahun' => $tahun,
            'bulan' => $bulan,
            "seksi" => $seksi,
        ]);
    }

    /**
     * Finds the Jadwaloh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jadwaloh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jadwaloh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function kegiatanDropdownCreate(){
        $kegiatan = ArrayHelper::map(Kegiatan::find()
            ->where(["kegiatan.created_by" => \Yii::$app->user->id])
            ->andFilterWhere(["isDeleted" => 0])
            ->orderBy('id DESC')
            ->all(), "id", "nama");
        return $kegiatan;
    }

    public function kegiatanDropdownUpdateCurrent(){
        $kegiatan = ArrayHelper::map(Kegiatan::find()
            ->where(["kegiatan.created_by" => \Yii::$app->user->id])
            ->andFilterWhere(["isDeleted" => 0])
            ->orderBy('id DESC') 
            ->all(), "id", "nama");
        return $kegiatan;
    }

    public function kegiatanDropdownUpdate(){
        $kegiatan = ArrayHelper::map(Kegiatan::find()
            ->andFilterWhere(["isDeleted" => 0])
            ->orderBy('id DESC') 
            ->all(), "id", "nama");
        return $kegiatan;
    }

    public function pegawaiDropdown(){
        $pegawai = ArrayHelper::map(User::find()->where(['like','isPegawai',1])->all(), "id", "username");
        return $pegawai;
    }

    public function actionCekJadwaloh($user, $tanggal){
        $pegawai = new Pegawai();

        return $pegawai->cekJadwaloh($user = $user, $tanggal = $tanggal);
    }

}
