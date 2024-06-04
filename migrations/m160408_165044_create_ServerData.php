<?php

use yii\db\Migration;

class m160408_165044_create_ServerData extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('ServerData', $tables))  { 
        	$this->createTable('{{%ServerData}}', [
        		'id' => 'BIGINT IDENTITY NOT NULL',
        		0 => 'PRIMARY KEY (`id`)',
        		'Server' => 'NVARCHAR NOT NULL',
        		'usertyp' => 'NVARCHAR NOT NULL',
        		'user' => 'NVARCHAR NULL',
        		'password' => 'NVARCHAR NULL',
        		'snmp_pw' => 'NVARCHAR NULL',
        		'typ' => 'NVARCHAR NOT NULL',
        		'stat_wait' => 'NVARCHAR NOT NULL DEFAULT \'(N'unknown')\'',
        		'stat_queries' => 'NVARCHAR NOT NULL DEFAULT \'(N'unknown')\'',
        		'stat_cpu' => 'NVARCHAR NOT NULL DEFAULT \'(N'unknown')\'',
        		'stat_mem' => 'NVARCHAR NOT NULL DEFAULT \'(N'unknown')\'',
        		'stat_disk' => 'NVARCHAR NOT NULL DEFAULT \'(N'unknown')\'',
        		'stat_sess' => 'NVARCHAR NOT NULL DEFAULT \'(N'unknown')\'',
        		'stat_net' => 'NVARCHAR NULL',
        	], $tableOptions_mssql);
        }
    }

    public function down()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (!in_array('ServerData', $tables))  {
          $this->execute('SET foreign_key_checks = 0');
          $this->dropTable('ServerData');
          $this->execute('SET foreign_key_checks = 1;');        
        }
    }
}
