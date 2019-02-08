<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pack}}`.
 */
class m190203_113749_create_pack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pack}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'volume' => $this->integer()->notNull()
        ]);

        $packSizes = [
            'Extra Small Pack' => 250, 
            'Small Pack' => 500, 
            'Medium Pack' => 1000, 
            'Large Pack' => 2000, 
            'Really Large Pack' => 10000, 
        ];
        
        // Add the packs from the question.
        foreach ($packSizes as $name => $volume) {
            $this->insert('pack', [
                'name' => $name,
                'volume' => $volume
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pack}}');
    }
}
