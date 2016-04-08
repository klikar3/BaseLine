<?php

use yii\db\Migration;

class m160408_164946_create_PerfCounterDefault extends Migration
{
    public function up()
    {
      $tables = Yii::$app->db->schema->getTableNames();
      if (!in_array('PerfCounterDefault', $tables))  { 
        	$this->createTable('{{%PerfCounterDefault}}', [
        		'id' => 'INT IDENTITY NOT NULL',
        		0 => 'PRIMARY KEY (`id`)',
        		'counter_name' => 'NVARCHAR NOT NULL',
        		'AvgValue' => 'DECIMAL NULL',
        		'StdDefValue' => 'DECIMAL NULL',
        		'WarnValue' => 'DECIMAL NULL DEFAULT \'((0))\'',
        		'AlertValue' => 'DECIMAL NULL DEFAULT \'((0))\'',
        		'is_perfmon' => 'BIT NULL',
        		'direction' => 'VARCHAR NULL',
        		'belongsto' => 'VARCHAR NULL',
        	], $tableOptions_mssql);
      }  
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('PerfCounterDefault', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('PerfCounterDefault');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }
}
