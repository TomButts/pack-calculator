<?php

namespace app\models;

use Yii;

use app\models\interfaces\CombinationSolver;

/**
 * This is the model class for table "Order".
 *
 * @property int $id
 * @property int $volume
 * @property string $created_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['volume'], 'required'],
            [['volume'], 'integer', 'min' => 1],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'volume' => 'Number of bananas ordered',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Calculate the packs required to fulfill an order
     *
     * @param integer $target Number of products ordered
     * @param array $packs Pack sizes available to fulfill order
     * @param CombinationSolver $solver Pass solving class
     * @return array
     */
    public function calculateRequiredPacks(array $packs, CombinationSolver $solver)
    {
        $requiredPacks = [];

        $remainingProducts = $this->volume;
        
        $largestPack = max($packs);
        $secondLargest = $largestPack;

        if (count($packs) > 1) {
            arsort($packs);
            $secondLargest = $packs[1];
        }
        
        // To calculate larger totals, quickly add largest pack until closer to fulfilling order
        while ($remainingProducts > ($largestPack + $secondLargest)) {
            $requiredPacks[] = $largestPack;
            $remainingProducts = $remainingProducts - $largestPack;
        }
        
        return array_merge(
            $requiredPacks,
            $solver->calculateCombinations($remainingProducts, $packs)
        );
    }   
}
