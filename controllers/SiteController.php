<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{   
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
