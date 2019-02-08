<?php

namespace app\models;

use Yii;

use app\models\Pack;
use app\models\interfaces\PackCalculatorInterface;

/**
 * This is the model class for table "Order".
 *
 * @property int $id
 * @property int $volume
 * @property string $created_at
 */
class Order extends \yii\db\ActiveRecord implements PackCalculatorInterface
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
            [['volume'], 'integer', 'min' => 1, 'max' => 17000],
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
     * Calculate the packs required to fulfil an order.
     *
     * @param Pack $pack
     * @return array $packs Pack sizes needed to fill order.
     */
    public function calculateRequiredPacks(Pack $pack)
    {
        $requiredPacks = [];

        // Temp value to count down the number of products in order left to fulfil
        $productCounter = $this->volume;

        // Reapply this process while taking off the value of 
        // the chosen packs from the order total
        while ($productCounter > 0) {
            // Using lots of small queries could be better than getting all packs initially
            // than using logic in functions.

            // Try and get the closest pack less than the value left to deliver
            $requiredPack = $pack->closestLessThan($productCounter);

            if (!$requiredPack) {
                // If no packs are smaller try and get closest pack that is bigger
                // to fulfil order but give away least extra
                $requiredPack = $pack->closestGreaterThan($productCounter);                
            }

            $requiredPacks[] = $requiredPack;

            // Decrease the remaining product counter
            $productCounter = $productCounter - $requiredPack;
        }

        return $this->optimiseRequiredPacks($pack, $requiredPacks);
    }

    /**
     * Optimise required packs by replacing packs with larger existing 
     * packs of same size.
     *
     * @param Pack $pack Pack model for querying
     * @param array $requiredPacks
     * @return void
     */
    private function optimiseRequiredPacks(Pack $pack, array $requiredPacks)
    {
        do {
            // If array does not have two elements
            if (count($requiredPacks) < 2) {
                break;
            }

            $lastPack = $requiredPacks[count($requiredPacks) - 1];
            $penultimatePack = $requiredPacks[count($requiredPacks) - 2];
            
            // Sometimes when the penultimate pack just falls short of the total
            // The same pack is added twice.
            // This bit checks if there is a pack of equal value that replaces repeated packs 
            if ($lastPack == $penultimatePack) {
                $substituePack = $pack->findByVolume(($lastPack * 2));
                
                if ($substituePack) {
                    // If theres a sub replace the last value with the substitute
                    unset($requiredPacks[count($requiredPacks) - 1]);
                    $requiredPacks[count($requiredPacks) - 1] = $substituePack;
                }               
            }
            
            // Loop incase the same issue is present in new array
        } while ($lastPack == $penultimatePack);

        // Return fully optimised pack array
        return $requiredPacks;
    }
}
