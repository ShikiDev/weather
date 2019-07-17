<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "weather".
 *
 * @property int $id
 * @property string $city
 * @property string $date
 * @property string $data
 * @property int $deleted
 */
class Weather extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weather';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city', 'date', 'data'], 'required'],
            [['id', 'deleted'], 'integer'],
            [['date'], 'safe'],
            [['data'], 'string'],
            [['city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'date' => 'Date',
            'data' => 'Data',
            'deleted' => 'Deleted',
        ];
    }

    public static function getByDate($date)
    {
        if ($data = self::findOne(['date' => $date]) !== null) {
            return $data;
        }

        return false;
    }

    public static function getWeekWeather($date)
    {
        if ($list = self::find([':date' => $date])->orderBy(['id' => SORT_ASC])->limit(7)->all()) {
            return $list;
        }
        return false;
    }

    public function getDataDecoded()
    {
        return json_decode($this->data);
    }

    public function getDate($format)
    {
        return date($format, strtotime($this->date));
    }
}
