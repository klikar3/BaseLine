<?php

use yii\db\Migration;

/**
 * Handles the creation for table `serverdata`.
 */
class m161017_130046_create_serverData_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('serverdata', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('serverdata');
    }
}
