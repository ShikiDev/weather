<?php
/**
 * Created by PhpStorm.
 * User: Shiki
 * Date: 7/14/2019
 * Time: 1:50 PM
 */

namespace app\component;

use Yii;
use Yii\base\Component;

class WeatherAPI extends Component
{
    private $key;
    private $server;

    public function __construct(array $config = [])
    {
        $this->key = '';
        $this->server = '';
        parent::__construct($config);
    }

    private function connectToAPI()
    {
    }

}