<?php

namespace frontend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "jadwaloh".
 *
 * @property int $id
 * @property int $kegiatan
 * @property string $tanggal
 * @property int $user
 */
class Jadwaloh extends \yii\db\ActiveRecord
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jadwaloh';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserKegiatan()
    {
        return $this->hasOne(Kegiatan::className(), ['id' => 'kegiatan']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kegiatan', 'tanggal', 'user'], 'required'],
            [['tanggal', 'id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kegiatan' => 'Kegiatan',
            'tanggal' => 'Tanggal',
            'user' => 'Pegawai',
        ];
    }
}
