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
     * Get all available pack sizes
     *
     * @return array $sizes
     */
    public function allSizes()
    {
        $sizes = [];
        
        $packs = $this->find()->select('volume')->all();

        if (!empty($packs)) {
            foreach ($packs as $pack) {
                $sizes[] = $pack->volume;
            }
        }

        return $sizes;
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
