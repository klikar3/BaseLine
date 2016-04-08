<?php

use yii\db\Migration;

class m160408_164025_create_ConfigData extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('ConfigData', $tables))  {
          	$this->createTable('{{%ConfigData}}', [
          		'id' => 'BIGINT IDENTITY NOT NULL',
          		0 => 'PRIMARY KEY (`id`)',
          		'Server' => 'NVARCHAR NOT NULL',
          		'ConfigurationID' => 'INT NOT NULL',
          		'Name' => 'NVARCHAR NOT NULL',
          		'Value' => 'BIGINT NULL',
          		'ValueInUse' => 'BIGINT NULL',
          		'CaptureDate' => 'DATETIME NULL',
          	]);  
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('ConfigData', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('ConfigData');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }    
}


