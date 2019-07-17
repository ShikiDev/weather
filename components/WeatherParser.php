<?php
/**
 * Created by PhpStorm.
 * User: Shiki
 * Date: 7/14/2019
 * Time: 1:55 PM
 */

namespace app\components;

use Yii;
use Yii\base\Component;
use phpQuery;

class  WeatherParser extends Component
{
    private static $link = 'https://yandex.ru/pogoda/moscow/details';

    public static function parsePage()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function collectData()
    {
        $data = self::parsePage();
        if ($data) {
            $days_weather = array();
            $pq = phpQuery::newDocument($data);
            $main_elems = $pq->find('div.forecast-details');
            $parsed_days = $main_elems->find('dt > strong.forecast-details__day-number');

            $parsed_temperature_tables = $main_elems->find('dd > .weather-table');
            if ($parsed_temperature_tables->count() != $parsed_days->count()) return false;

            $temp = array();
            $days_array = $parsed_days->texts();

            foreach ($parsed_temperature_tables as $key => $tables) {
                $day_part_info = pq($tables)->find('.weather-table__row');
                $temp[] = $day_part_info;
                if (!empty($day_part_info)) {
                    foreach ($day_part_info as $day_part) {
                        $day_part_name = pq($day_part)->find('div.weather-table__daypart')->text();
                        $day_temperature = pq($day_part)->find('div.weather-table__temp > div.temp > span.temp__value')->texts();
                        if (empty($day_part_name) and empty($day_temperature)) break;

                        if (empty($days_array[$key])) continue;
                        else $days_weather[$days_array[$key]][$day_part_name] = $day_temperature;
                    }
                } else break;
            }

            return $days_weather;

        } else return false;
    }
}