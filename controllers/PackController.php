<?php

namespace app\controllers;

use app\models\Pack;

class PackController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $packs = Pack::find()
            ->orderBy(['volume' => SORT_DESC])
            ->all();

        return $this->render('index', ['packs' => $packs]);
    }
}
