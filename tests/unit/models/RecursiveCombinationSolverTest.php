<?php
namespace models;

use app\models\RecursiveCombinationSolver;

class RecursiveCombinationSolverTest extends \Codeception\Test\Unit
{
    protected $packs = [250, 500, 1000, 2000, 5000];

    /**
     * @var \UnitTester
     */
    protected $tester;
    
    /**
     * @dataProvider sumProvider
     */
    public function testItGetsTheSmallestSum($target, $numbers, $expectedSum)
    {
        $solver = new RecursiveCombinationSolver();
        $solver->calculateCombinations($target, $numbers);
        expect($solver->bestSum)->equals($expectedSum);
    }

    public function sumProvider()
    {
        return [
            'using pack sizes from question' => [570, $this->packs, 750],
            'using pack sizes from question (finds exactly equal sum)' => [5000, $this->packs, 5000],
            'using question sizes plus a 300 pack' => [590, array_merge($this->packs, [300]), 600],
            'using question sizes on a larger total' => [5300, $this->packs, 5500]
        ];
    }

    /**
     * @dataProvider comboProvider
     */
    public function testItFindsSmallestCombination($target, $numbers, $expectedCombo)
    {
        $solver = new RecursiveCombinationSolver();

        expect($solver->calculateCombinations($target, $numbers))
            ->equals($expectedCombo);
    }

    public function comboProvider()
    {
        return [
            'using pack sizes from question' => [590, $this->packs, [500, 250]],
            'using question sizes plus a 300 pack' => [870, array_merge($this->packs, [300]), [300, 300, 300]],
            'using question sizes on a larger total' => [5610, $this->packs, [5000, 500, 250]]
        ];
    }
}