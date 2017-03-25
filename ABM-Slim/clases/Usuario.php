<?php

class Usuario {

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $perfil;
    public $foto;

//--CONSTRUCTOR
    public function __construct($id = NULL) {
        if ($id !== NULL) {

           $user=Usuario::TraerUnUsuarioPorId($id);

            $this->id=$user->id;
            $this->nombre=$user->nombre;
            $this->email=$user->email;
            $this->password=$user->password;
            $this->perfil=$user->perfil;
            $this->foto=$user->foto;
        }
    }
    
    public static function TraerUsuarioLogueado($email,$pass) {

        $userLogueado=NULL;

        $objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("SELECT * FROM usuarios WHERE email = :correo AND password = :pass"); 
        $consulta->bindValue(":correo",$email,PDO::PARAM_STR);
        $consulta->bindValue(":pass",$pass,PDO::PARAM_STR);

        $consulta->execute();        

        if ($consulta->rowCount()==1) 
        {
           $userLogueado=$consulta->fetchObject("Usuario");
        }

        return $userLogueado;
    }

    public static function TraerUnUsuarioPorId($id) {
		
        $objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("SELECT * FROM usuarios WHERE id= :idUss");
        $consulta->bindParam(":idUss",$id,PDO::PARAM_INT);

        $consulta->execute();        

        if ($consulta->rowCount()==1) 
        {
           $datosU=$consulta->fetchObject("Usuario");
        }

        return $datosU;
    }

    public static function Agregar($obj) {

		$alta=new stdClass(); 
        $alta->realizada=false;

        $objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("INSERT INTO usuarios (nombre,email,password,perfil,foto) VALUES (:nom,:em,:pas,:per,:fot)");
        $consulta->bindValue(":nom",$obj->nombre,PDO::PARAM_STR);
        $consulta->bindValue(":em",$obj->email,PDO::PARAM_STR);
        $consulta->bindValue(":pas",$obj->password,PDO::PARAM_STR);
        $consulta->bindValue(":per",$obj->perfil,PDO::PARAM_STR);
        $consulta->bindValue(":fot",$obj->foto,PDO::PARAM_STR);
        
        if ($consulta->execute()) {
            $alta->realizada=true;
            $alta->nuevoId=$objACCESO->RetornarUltimoIdInsertado();
        }

        return $alta;
    }

    public function ActualizarFoto($tmpArch) {

		Archivo::Mover("./tmp/".$tmpArch,"./fotos/".$tmpArch);
    }

    public static function Modificar($obj) {

        $modificacion=new stdClass(); 
        $modificacion->realizada=false;

        $objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("UPDATE usuarios SET nombre=:nom,email=:em,perfil=:per,foto=:fot WHERE id=:idUser");
        $consulta->bindValue(":idUser",$obj->id,PDO::PARAM_INT);
        $consulta->bindValue(":nom",$obj->nombre,PDO::PARAM_STR);
        $consulta->bindValue(":em",$obj->email,PDO::PARAM_STR);
        $consulta->bindValue(":per",$obj->perfil,PDO::PARAM_STR);
        $consulta->bindValue(":fot",$obj->foto,PDO::PARAM_STR);
        
        if ($consulta->execute()) {
            $modificacion->realizada=true;
        }

        return json_encode($modificacion);
    }

    public static function TraerTodosLosUsuarios() {

        $objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("SELECT * FROM usuarios");

        $consulta->execute(); 

        $consulta->setFetchMode(PDO::FETCH_CLASS,"Usuario");

        return $consulta;
    }

    public static function TraerTodosLosPerfiles() {

		$objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("SELECT DISTINCT perfil FROM usuarios");

        $consulta->execute(); 

        $perfiles=$consulta->fetchAll(PDO::FETCH_NUM);

        return $perfiles;
    }

    public static function Borrar($id) {

        $objACCESO=AccesoDatos::dameUnObjetoAcceso();

        $consulta=$objACCESO->RetornarConsulta("DELETE FROM usuarios WHERE id = :idus"); 
        $consulta->bindParam(":idus",$id,PDO::PARAM_INT);

        $consulta->execute();        
    }
}