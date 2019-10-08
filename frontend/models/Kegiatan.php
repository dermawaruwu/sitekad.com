<?php

namespace frontend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table "kegiatan".
 *
 * @property int $id
 * @property string $nama
 * @property int $updated_at
 * @property int $created_at
 * @property int $updated_by
 * @property int $created_by
 * @property int $seksi
 * @property int $periode
 */
class Kegiatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],
                'replaceRegularDelete' => true // mutate native `delete()` method
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kegiatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'periode'], 'required'],
            [['updated_at', 'created_at', 'updated_by', 'created_by', 'seksi', 'periode'], 'integer'],
            [['kode'], 'safe'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatanUserCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatanUserUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatanPeriode()
    {
        return $this->hasOne(Periode::className(), ['id' => 'periode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatanSeksi()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'seksi']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
            'seksi' => 'Seksi',
            'kode' => 'Kode POK',
            'periode' => 'Periode',
        ];
    }
}
