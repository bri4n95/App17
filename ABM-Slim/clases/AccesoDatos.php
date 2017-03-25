<?php
class AccesoDatos
{
    private static $_objetoAcceso;
    private $_objetoPDO;

    private function __construct()
    {
		try {

            $this->_objetoPDO=new PDO("mysql:host=localhost;dbname=login_pdo","root","");
            
        } catch (PDOException $e) {
            
            print $e->getMessage();

            die();
        }
    }
 
    public function RetornarConsulta($sql)
    { 
		return $this->_objetoPDO->prepare($sql);
    }
    
     public function RetornarUltimoIdInsertado()
    { 
		return $this->_objetoPDO->lastInsertId();
    }
 
    public static function dameUnObjetoAcceso()
    { 
        if (!isset(self::$_objetoAcceso)) {
            
            self::$_objetoAcceso=new AccesoDatos();
        }

        return self::$_objetoAcceso;
    }
 
    public function __clone()
    { 
 		trigger_error("La clonacion del objeto no se permite",E_USER_ERROR);
    }
}