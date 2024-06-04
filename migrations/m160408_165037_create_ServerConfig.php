<?php

use yii\db\Migration;

class m160408_165037_create_ServerConfig extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('ServerConfig', $tables))  { 
        	$this->createTable('{{%ServerConfig}}', [
        		'Server' => 'NVARCHAR NULL',
        		'Property' => 'NVARCHAR NULL',
        		'Value' => 'VARCHAR NULL',
        		'CaptureDate' => 'DATETIME NULL',
        	], $tableOptions_mssql);
        }  
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('ServerConfig', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('ServerConfig');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }
}
