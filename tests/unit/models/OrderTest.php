<?php
namespace orders;

use app\models\Order;
use app\models\RecursiveCombinationSolver;

class OrderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $order;

    /**
     * Packs from the question
     *
     * @var array
     */
    protected $packs = [250, 500, 1000, 2000, 5000];

    /**
     * @dataProvider questionPackProvider
     */
    public function testItCalculatesRequiredPacksUsingQuestionPacks($volume, $expected)
    {
        $order = new Order();
        $order->volume = $volume;

        $solver = new RecursiveCombinationSolver();

        expect($order->calculateRequiredPacks($this->packs, $solver))
            ->equals($expected);
    }

    public function questionPackProvider()
    {
        return [
            'for 1' => [1, [250]],
            'for 250' => [250, [250]],
            'for 251' => [251, [500]],
            'for 500' => [500, [500]],
            'for 760' => [760, [1000]],
            'for 12001' => [12001, [5000, 5000, 2000, 250]]
        ];
    }

    /**
     * @dataProvider packProvider
     */
    public function testItCalculatesRequiredPacks($volume, $expected)
    {
        $order = new Order();
        $order->volume = $volume;

        $solver = new RecursiveCombinationSolver();

        $packs = [123, 300, 500, 600, 5000];

        expect($order->calculateRequiredPacks($packs, $solver))
            ->equals($expected);
    }

    public function packProvider()
    {
        return [
            'when number is awkwardly below max pack' => [4000, [600, 600, 600, 600, 600, 500, 500]]
        ];
    }
}