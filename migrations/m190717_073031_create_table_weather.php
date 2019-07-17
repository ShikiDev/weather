<?php

use yii\db\Migration;

/**
 * Class m190717_073031_create_table_weather
 */
class m190717_073031_create_table_weather extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('weather',[
            'id' => $this->primaryKey('11'),
            'city' => $this->string('255')->notNull(),
            'date' => $this->date(),
            'data' => $this->text(),
            'deleted' => $this->integer('2')->defaultValue(0)
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('weather');
    }
}
