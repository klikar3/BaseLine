<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ServerData".
 *
 * @property string $id
 * @property string $Server
 * @property string $usertyp
 * @property string $user
 * @property string $password
 * @property string $snmp_pw
 * @property string $typ
 * @property string $stat_wait
 * @property string $stat_queries
 * @property string $stat_cpu
 * @property string $stat_mem
 * @property string $stat_disk
 * @property string $stat_sess
 * @property string $stat_net
 * @property resource $User_Encrypted 
 * @property resource $Password_Encrypted 
 */
class ServerData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ServerData';
    }

//    public $Server;
    public $usr;
    public $pwd;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['Server', 'usr', 'pwd', 'usertyp', 'typ'], 'required'],
            ['Server', 'unique'],
            [['paused'], 'integer'],
            [['Server', 'usertyp', 'user', 'usr', 'password', 'pwd', 'snmp_pw', 'typ', 'stat_wait', 'stat_queries', 'stat_cpu', 'stat_mem', 'stat_disk', 'stat_sess', 'stat_net'], 'string'],
            [['User_Encrypted', 'Password_Encrypted', 'Description'], 'string'],
            [['usr'], 'validateUser', 'skipOnEmpty' => false, 'skipOnError' => false],

        ];
    }

    public function validateUser($attribute, $params) 
    {   // Nur für nicht pausierte SQL-Server
        if (($this->typ != "sql") OR ($this->paused == 1)) return;
        $dsn = "sqlsrv:Server=".$this->Server.";Database=master";
        $connection = new \yii\db\Connection([
            'dsn' => $dsn,
            'username' => $this->usr,
            'password' => $this->pwd,
        ]);
        try {
            $connection->open();
            $command = $connection->createCommand('SELECT @@version');
            try {
              $posts = $command->queryAll();
              if (empty($posts)) {
                  $this->addError($attribute, Yii::t('app', 'Berechtigung nicht ausreichend.'));
              }
            } catch (\yii\db\Exception $e) {
    //        $command = $connection->createCommand('UPDATE post SET status=1');
    //        $command->execute();
            $this->addError($attribute, Yii::t('app', 'Berechtigung nicht ausreichend.'));
            }
        } catch (\yii\db\Exception $e) {
            $this->addError($attribute, Yii::t('app', 'Datenbankverbindung nicht möglich.'));
        }        
//       $this->Server = $srv; 
        
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Server' => Yii::t('app', 'Server'),
            'usertyp' => Yii::t('app', 'Usertyp'),
            'user' => Yii::t('app', 'User'),
            'usr' => Yii::t('app', 'User'),            
            'password' => Yii::t('app', 'Password'),
            'snmp_pw' => Yii::t('app', 'Snmp Pw'),
            'typ' => Yii::t('app', 'Typ'),
            'stat_wait' => Yii::t('app', 'Wait'),
            'stat_queries' => Yii::t('app', 'Queries'),
            'stat_cpu' => Yii::t('app', 'Cpu'),
            'stat_mem' => Yii::t('app', 'Mem'),
            'stat_disk' => Yii::t('app', 'Disk'),
            'stat_sess' => Yii::t('app', 'Sess'),
            'stat_net' => Yii::t('app', 'Net'),
            'User_Encrypted' => Yii::t('app', 'User Encrypted'),
		        'Password_Encrypted' => Yii::t('app', 'Password Encrypted'),
            'paused' => Yii::t('app', 'paused'),
 		        ];
    }
    
    public function beforeSave($insert)
    {
      $this->setUsr($this->usr);
      $this->setPwd($this->pwd);
      $this->setSrv($this->Server);
//      \yii\helpers\VarDumper::dump($this->User_Encrypted, 10, true);                  
//      Yii::error($this->Server, 'application');                  
//      Yii::error($this->User_Encrypted, 'application');                  
      return true;
    }

    public function getUsr()
    {
        $this->usr = \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_decrypt_ServerData(:uenc, :srvr) ')
                          ->bindValues([':uenc' => $this->User_Encrypted, ':srvr' => $this->Server])->queryScalar();               
//                          ->bindValue(':srvr', $this->Server)->queryScalar(); 
//        \yii\helpers\VarDumper::dump($u, 10, true); 
    }    
    
    public function setUsr($u)
    {
        $this->User_Encrypted = \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_encrypt_ServerData(:u, :srvr) ')
                          ->bindValues([':u' => $u, ':srvr' => $this->Server])->queryScalar();
        $this->usr = $u;
//        \yii\helpers\VarDumper::dump($this->User_Encrypted, 10, true);                  
//        return true;                                 
    }    

    public function getPwd()
    {
        $this->pwd =  \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_decrypt_ServerData(:pwenc, :srvr) ')
                          ->bindValues([':pwenc' => $this->Password_Encrypted, ':srvr' => $this->Server])->queryScalar();               
    }
        
    public function setPwd($p)
    {
        $this->Password_Encrypted = \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_encrypt_ServerData(:pw, :srvr) ')
                          ->bindValues([':pw' => $p, ':srvr' => $this->Server])->queryScalar();
        $this->pwd = $p;               
    }    

    public function setSrv($s)
    {
        $this->Server = $s;               
    }
    
    public function getConfigData()
    {
        return $this->hasMany(ConfigData::className(), ['Server' => 'Server']);
    }    
        
    public function getServerConfig()
    {
        return $this->hasMany(ServerConfig::className(), ['Server' => 'Server']);
    }    

    public function getDbData()
    {
        return $this->hasMany(DbData::className(), ['Server' => 'Server']);
    }    
    
    public function getPerfCounterPerServer()
    {
        return $this->hasMany(PerfCounterPerServer::className(), ['Server' => 'Server']);
    }    
    
    public function getIoCounters()
    {
        return $this->hasMany(IoCounters::className(), ['Server' => 'Server']);
    }    
    
    public function getNetMonData()
    {
        return $this->hasMany(NetMonData::className(), ['Server' => 'serverconfig_value'])
                    ->viaTable('serverconfig', ['Server' => 'Server', 'Property' => "MachineName"]);   
    }    
    
    public function getPerfMonData()
    {
        return $this->hasMany(PerfMonData::className(), ['Server' => 'Server']);
    }    
    
    public function getPerfmonDataAgg1H()
    {
        return $this->hasMany(PerfmonDataAgg1H::className(), ['Server' => 'Server']);
    } 
       
    public function getNetmonDataAgg1H()
    {
        return $this->hasMany(PerfmonDataAgg1H::className(), ['Server' => 'Server']);
    } 
    
}
