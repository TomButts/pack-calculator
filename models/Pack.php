<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pack".
 *
 * @property int $id
 * @property string $name
 * @property int $volume
 * @property string $type
 */
class Pack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pack';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'volume', 'type'], 'required'],
            [['volume'], 'integer', 'min' => 1],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'volume' => 'Volume',
            'type' => 'Type',
        ];
    }

    /**
     * Find closest pack with size greater than a value
     * 
     * @param integer $value
     * @return mixed 
     */
    public function closestGreaterThan($value)
    {
        $smallestPack = $this->find()
            ->where(['>=', 'volume', $value])
            ->orderBy(['volume' => SORT_ASC])
            ->one();

        if (!isset($smallestPack)) {
            return false;
        }

        return $smallestPack->volume;
    }

    /**
     * Find the largest pack size that is less than a value
     *
     * @param int $value
     * @return mixed 
     */
    public function closestLessThan($value)
    {
        $largestPack = $this->find()
            ->where(['<=', 'volume', $value])
            ->orderBy(['volume' => SORT_DESC])
            ->one();

        if (!isset($largestPack)) {
            return false;
        }

        return $largestPack->volume;
    }

    /**
     * Find a pack by searching pack volume
     *
     * @param int $volume
     * @return mixed
     */
    public function findByVolume($volume)
    {
        $pack = $this->find()
            ->where(['volume' => $volume])
            ->one();
        
        if (!isset($pack)) {
            return false;
        }

        return $pack->volume;
    }

    /**
     * Max volume of all current packs
     *
     * @return int
     */
    public function maxVolume()
    {
        return $this->find()->select('volume')->max('volume');
    }

    /**
     * Formats array of pack sizes for view
     *
     * @param array $packs
     * @return array $packs [ 'pack size' => 'number required' ... N ]
     */
    public function formatPackSizes(array $packs)
    {
        return array_count_values($packs);
    }
}
