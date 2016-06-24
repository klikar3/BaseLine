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

    private $usr;
    private $pwd;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Server', 'usertyp', 'typ'], 'required'],
            [['Server', 'usertyp', 'user', 'usr', 'password', 'pwd', 'snmp_pw', 'typ', 'stat_wait', 'stat_queries', 'stat_cpu', 'stat_mem', 'stat_disk', 'stat_sess', 'stat_net'], 'string'],
            [['User_Encrypted', 'Password_Encrypted', 'Description'], 'string']
        ];
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
		        ];
    }
    
/*    public function beforeSave($insert)
    {
//      $this->setUsr($this->usr);
//      \yii\helpers\VarDumper::dump($this->User_Encrypted, 10, true);                  
//      Yii::error($this->usr, 'application');                  
//      Yii::error($this->User_Encrypted, 'application');                  
      return true;
    }
*/
    public function getUsr()
    {
        return \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_decrypt_ServerData(:uenc, :srvr) ')
                          ->bindValues([':uenc' => $this->User_Encrypted, ':srvr' => $this->Server])->queryScalar();               
//                          ->bindValue(':srvr', $this->Server)->queryScalar();                                                                        User_Encrypted
    }    
    
    public function setUsr($u)
    {
//        $this->User_Encrypted = \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_encrypt_ServerData(:u, :srvr) ')
//                          ->bindValues([':u' => $u, ':srvr' => $this->Server])->queryScalar();
        $this->usr = $u;
//        \yii\helpers\VarDumper::dump($this->User_Encrypted, 10, true);                  
//        return true;                                 
    }    

    public function getPwd()
    {
        return \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_decrypt_ServerData(:pwenc, :srvr) ')
                          ->bindValues([':pwenc' => $this->Password_Encrypted, ':srvr' => $this->Server])->queryScalar();               
    }
        
    public function setPwd($p)
    {
//
//                          ->bindValues([':pw' => $p, ':srvr' => $this->Server])->queryScalar();
        $this->pwd = $p;               
    }    
}
