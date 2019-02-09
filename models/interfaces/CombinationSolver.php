<?php

namespace app\models\interfaces;

interface CombinationSolver {
    public function calculateCombinations(int $target, array $numbers);
}

