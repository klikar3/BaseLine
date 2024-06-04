<?php

use yii\db\Migration;

class m160408_165025_create_PerfMonData extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('PerfMonData', $tables))  { 
        	$this->createTable('{{%PerfMonData}}', [
        		'id' => 'BIGINT IDENTITY NOT NULL',
        		0 => 'PRIMARY KEY (`id`)',
        		'Server' => 'NVARCHAR NULL',
        		'counter_id' => 'INT NULL',
        		'instance' => 'NVARCHAR NULL',
        		'Counter' => 'NVARCHAR NULL',
        		'Value' => 'DECIMAL NULL',
        		'CaptureDate' => 'DATETIME NULL',
        		'status' => 'NVARCHAR NULL',
        		'AvgValue' => 'DECIMAL NULL',
        		'StdDevValue' => 'DECIMAL NULL',
        	], $tableOptions_mssql);
        }
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('PerfMonData', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('PerfMonData');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }
}
