<?php

use yii\db\Migration;

class m160408_164927_create_IoCounters extends Migration
{
    public function up()
    {
      $tables = Yii::$app->db->schema->getTableNames();
      if (!in_array('IoCounters', $tables))  { 
        	$this->createTable('{{%IoCounters}}', [
        		'id' => 'BIGINT IDENTITY NOT NULL',
        		'server' => 'NVARCHAR NOT NULL',
        		'datenbank' => 'NVARCHAR NOT NULL',
        		'filename' => 'NVARCHAR NOT NULL',
        		'io_stall_read_ms' => 'BIGINT NULL',
        		'num_of_reads' => 'BIGINT NULL',
        		'io_stall_write_ms' => 'BIGINT NULL',
        		'num_of_writes' => 'BIGINT NULL',
        		'io_stalls' => 'BIGINT NULL',
        		'io' => 'BIGINT NULL',
        		'CaptureDate' => 'DATETIME NOT NULL',
        	], $tableOptions_mssql); 
      }       
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('IoCounters', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('IoCounters');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }
}
