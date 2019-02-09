<?php

namespace app\controllers;

use Yii;

use app\models\Order;
use app\models\Pack;
use app\models\RecursiveCombinationSolver;

use app\components\Helper;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Create an order
     *
     * @return void
     */
    public function actionCreate()
    {
        $order = new Order();

        if ($order->load(Yii::$app->request->post())) {
            if ($order->validate()) {                
                $pack = new Pack();
                $solver = new RecursiveCombinationSolver();

                $allPacks = $pack->allSizes();
                
                // Calculate required packs
                $requiredPacks = $order->calculateRequiredPacks($allPacks, $solver);

                // Render order pack details page
                return $this->render('pack-requirements', [
                    'volume' => $order->volume,
                    'requiredPacks' => $pack->formatPackSizes($requiredPacks),
                    'totalRequired' => Helper::sumArray($requiredPacks)
                ]);                
            }
        }

        return $this->render('create', ['model' => $order]);
    }
}
