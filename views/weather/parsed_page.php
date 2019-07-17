<?php
/**
 * Created by PhpStorm.
 * User: Shiki
 * Date: 7/14/2019
 * Time: 2:35 PM
 */

use yii\helpers\Html;
use yii\base\view;

$this->title = 'Weathers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="weather-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#day">День</a></li>
        <li><a data-toggle="tab" href="#week">Неделя</a></li>
    </ul>
    <div class="tab-content">
        <div id="day" class="tab-pane fade in active">
            <div class="row">
                <?php
                echo $this->render('_first_day_info', ['res' => $result[0]])
                ?>
            </div>
        </div>
        <div id="week" class="tab-pane fade">
            <div class="row">
                <?php
                foreach ($result as $res) {
                    echo $this->render('_day_weather_part', ['res' => $res]);
                }
                ?>
            </div>
        </div>
