<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
require_once "clases/ClaseAdministracion.php";

$app = new \Slim\App;

$app->get('/traerGrilla', function (Request $request, Response $response) {
    include "grilla.php";
});

$app->get('/salir', function (Request $request, Response $response) {
      return Administracion::Salir();
});

#Funciones ABM

$app->post('/login', function ($request, $response, $args) {

  			$datos = $request->getParsedBody();
   			
   			return Administracion::Login($datos["correo"],$datos["pass"]);
});

$app->post('/cargarForm', function ($request, $response, $args) {

    include "form.php";        
});

$app->delete('/eliminar', function ($request, $response, $args) {

      $dato=$request->getParsedBody();
      return Administracion::Eliminar($dato["idEliminar"]);     	
});


$app->put('/modificarusuario', function ($request, $response, $args) {

    	$userModificado=$request->getParsedBody();

      return Administracion::Modificar($userModificado);
});


$app->run();