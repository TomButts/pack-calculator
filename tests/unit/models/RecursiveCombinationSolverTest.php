<?php
namespace models;

use app\models\RecursiveCombinationSolver;

class RecursiveCombinationSolverTest extends \Codeception\Test\Unit
{
    protected $questionNumbers = [250, 500, 1000, 2000, 5000];

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
            'using pack sizes from question' => [570, $this->questionNumbers, 750],
            'using question sizes plus a 300 pack' => [590, array_merge($this->questionNumbers, [300]), 600],
            'using question sizes on a larger total' => [5300, $this->questionNumbers, 5500]
        ];
    }
}