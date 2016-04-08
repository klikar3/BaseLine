<?php

use yii\db\Migration;

class m160408_165002_create_PerfCounterPerServer extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('PerfCounterPerServer', $tables))  { 
          	$this->createTable('{{%PerfCounterPerServer}}', [
          		'id' => 'BIGINT IDENTITY NOT NULL',
          		0 => 'PRIMARY KEY (`id`)',
          		'Server' => 'NVARCHAR NOT NULL',
          		'counter_id' => 'INT NULL',
          		'counter_name' => 'NVARCHAR NOT NULL',
          		'instance' => 'NVARCHAR NULL',
          		'AvgValue' => 'DECIMAL NULL',
          		'StdDevValue' => 'DECIMAL NULL',
          		'WarnValue' => 'DECIMAL NULL DEFAULT \'((0))\'',
          		'AlertValue' => 'DECIMAL NULL DEFAULT \'((0))\'',
          		'is_perfmon' => 'BIT NULL',
          		'direction' => 'VARCHAR NULL',
          		'belongsto' => 'VARCHAR NULL',
          		'status' => 'NVARCHAR NULL',
          	], $tableOptions_mssql);
        }      
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('PerfCounterPerServer', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('PerfCounterPerServer');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }
}
