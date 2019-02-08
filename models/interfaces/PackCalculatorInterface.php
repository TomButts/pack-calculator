<?php

namespace app\models\interfaces;

use app\models\Pack;

interface PackCalculatorInterface {
    public function calculateRequiredPacks(Pack $pack);
}

