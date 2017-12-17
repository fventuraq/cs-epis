<?php

require "../modelo/modelo.inc.php";
require "../modelo/ModeloGenerico.php";
/*
include  "../modelo/Persona.class.php";
*/
include  "FuncionJson.php";	

require "GenericService.php";

class ServicioPersona extends GenericService{
	public function processGET($datos){
        
        switch($datos->accion){
			case 1:
				
				break;
            default:
                $persona = new Persona();
                echo( miJson( $persona->buscarTodos() ) );
		}
		
	}
	public function processPOST($datos){
		
		$persona = new Persona();
        date_default_timezone_set('America/Lima');
        $datos->FecNac = "".date('Y-m-d', strtotime(urldecode($datos->FecNac)));
        $datos->FecCre = "".date("Y-m-d H:i:s");
        echo( miJsonIns( $persona->insertarDato($datos) ) );
	
		
	}
	public function processPUT($datos){
        
        $persona = new Persona();
        date_default_timezone_set('America/Lima');
        $datos->dato->FecNac = "".date('Y-m-d', strtotime(urldecode($datos->dato->FecNac)));
        echo( miJsonRes( $persona->actualizarDato($datos->dato,$datos->ID) ) );
	}
	public function processDELETE($datos){
		
		$persona = new Persona();
		
		echo( miJsonRes( $persona->eliminarDato($datos) ) );
	}
}
	$servicio = new ServicioPersona();
	$servicio->atenderSolicitud();

?>


