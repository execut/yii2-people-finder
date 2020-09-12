<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Bootstrap;


use execut\peopleFinder\Console\ReportController;
use yii\base\BootstrapInterface;
use yii\console\Application;

class Auto implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if (!($app instanceof Application)) {
            return;
        }

        $app->controllerMap['peopleFinder'] = ReportController::class;
    }
}