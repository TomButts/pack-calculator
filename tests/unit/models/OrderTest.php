<?php
namespace orders;

use app\models\Order;
use app\models\Pack;

class OrderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $order;

    protected $pack;
    
    public function testItHasTheOrderVolume()
    {
        $this->order = new Order();
        
        $this->order->volume = 19;

        expect($this->order->volume)->equals(19);
    }

    /**
     * @dataProvider packProvider
     */
    public function testItCalculatesRequiredPacks($volume, $expected)
    {
        $order = new Order();
        $order->volume = $volume;
        
        expect($order->calculateRequiredPacks(new Pack()))->equals($expected);
    }

    public function packProvider()
    {
        return [
            'Correct for 1' => [1, [250]],
            'Correct for 250' => [250, [250]],
            'Correct for 251' => [251, [500]],
            'Correct for 500' => [500, [500]],
            'Correct for 760' => [760, [1000]],
            'Correct for 12001' => [12001, [5000, 5000, 2000, 250]],
            'Correct for 15100' => [15100, [5000, 5000, 5000, 250]],
            'Correct for 15257' => [15257, [5000, 5000, 5000, 500]],
            'Correct for 15751' => [15751, [5000, 5000, 5000, 1000]]
        ];
    }
}