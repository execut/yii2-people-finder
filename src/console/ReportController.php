<?php
/**
 */

namespace execut\peoplesFinder\console;


use execut\peoplesFinder\Report;
use yii\console\Controller;

class ReportController extends Controller
{
    public function actionIndex($fullname, $gedcomFile) {
        $report = new Report($fullname, $gedcomFile);
        $report->run();
    }
}