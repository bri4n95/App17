<?php
require_once "clases/AccesoDatos.php";
require_once "clases/Usuario.php";

class Administracion
{
	
	function __construct()
	{
		
	}

	public static function Login($correo,$pass)
	{
		$respuesta["logU"]=TRUE;			

		$Usuario=Usuario::TraerUsuarioLogueado($correo,$pass);

		$respuesta=[];
		$respuesta["logU"]=FALSE;

		if ($Usuario!=NULL) {
			
			session_start();

			$_SESSION["UserLog"]=json_decode(json_encode($Usuario));
				
			$respuesta["logU"]=TRUE;
			$respuesta["dUs"]=$Usuario->id;
		}

		return json_encode($respuesta);	
	}

	public static function Eliminar($id)
	{
		Usuario::Borrar($id);

       $respuesta['mensaje']="USUARIO ELIMINADO"; 

       return json_encode($respuesta);
	}

	public static function Modificar($userModificado)
	{        
		$Newuser=new Usuario($userModificado["id"]);

            session_start(); 
                 
             if ($Newuser->id==$_SESSION["UserLog"]->id) {
                  
                   $_SESSION["UserLog"]=json_decode(json_encode($userModificado));
                   
            } 

        return Usuario::Modificar(json_decode(json_encode($userModificado)));
	}

	public static function Salir()
	{        
		session_start();

        $objRespuesta=new stdClass();
        $objRespuesta->salio=false;
                
        if (isset($_SESSION["UserLog"])) {

            session_destroy();
            $objRespuesta->salio=true;
            $objRespuesta->redir="index.php";
        }
                
        return json_encode($objRespuesta);
	}
}

?>