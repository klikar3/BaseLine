<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:server=ipsqlstdby01-1\sql2014;database=BaselineData',
    'username' => 'ignite',
    'password' => 'ignite4vsa!',
    'charset' => 'utf8',
//    'attributes' => [
        // use a bigger connection timeout
//        PDO::SQLSRV_ATTR_QUERY_TIMEOUT => 36,
//        PDO::SQLSRV_ATTR_FETCHES_DATETIME_TYPE => true
//    ],
    'on afterOpen' => function ($event) {
        $event->sender->createCommand("SET DATEFORMAT ymd")->execute();
    }

];
