<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:server=ipsqlstdby01-1\sql2014;database=BaselineData',
    'username' => 'ignite',
    'password' => 'ignite4vsa!',
    'charset' => 'utf8',
    'attributes' => [
        // use a bigger connection timeout
        PDO::ATTR_TIMEOUT => 3600,
    ],

];
