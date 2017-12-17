<?php

require "../modelo/modelo.inc.php";
require "../modelo/ModeloGenerico.php";

/*
include  "../modelo/Usuario.class.php";
include  "../modelo/Persona.class.php";
include  "../modelo/UsuarioVentana.class.php";
*/

include  "FuncionJson.php";	

require "GenericService.php";

class ServicioUsuario extends GenericService{
	public function processGET($datos,$user){
		
		$usuario = new Usuario();
		
		switch($datos->accion){
			case 1:
				$menus = new UsuarioVentana();
		
				if($datos->Tip == 'a')
					$res = $usuario->buscarUsuario($datos->NomUsu,$datos->Pas);
				else
					$res = $usuario->buscarDistribuidor($datos->NomUsu,$datos->Pas);
				
				if($res['estado']){
					$listaMenus = $menus->buscarTodosPorRol($res['resultado']['RolID']);
					$json = "";
				
					$json .= "{";
					$json .= "\"conectado\":" . json_encode(true);
					$json .= ',';
					$json .= "\"usuario\":" . json_encode( $res['resultado'] );
					$json .= ',';
					$json .= "\"menus\":" . json_encode($listaMenus);
					$json .= "}";
					
					echo( $json );
				}
				else{
					//echo( "{}" );
					echo( "El usuario o contraseña son incorrectos" );
				}
				
				break;
			case 2:
				echo( miJson( $usuario->buscarTodosTrabajadores() ) );
				break;
            case 3:
				echo( json_encode( $usuario->buscarAdmin() ) );
				break;
			case 4:
				echo( json_encode( $usuario->buscarAdministrador() ) );
				break;
            case 5:
                include  "../logica/Correo.php";
                
                try{
                    $usu = $usuario->getUsuario($datos->PerID);
                    if($usu['estado']){
                        mensajeDatos($datos->Ema,$datos->Nom,$usu['resultado']['NomUsu'],$usu['resultado']['Pas']);
                        echo(miJsonRes2(true,"La informacion del usuario se la envio a su correo"));
                    }
                }catch (Exception $e){
                    echo(miJsonRes2(false,"Error no se pudo enviar la informacion del usuario a su correo"));
                }
                
				break;
		}
	
		
	}
	public function processPOST($datos,$user){
        
        
        if(isset($datos->persona) && isset($datos->usuario) ){
            $usuario = new Usuario();
            $persona = new Persona();
            date_default_timezone_set('America/Lima');
            $datos->persona->FecNac = "".date('Y-m-d', strtotime(urldecode($datos->persona->FecNac)));
            $datos->persona->FecCre = "".date("Y-m-d H:i:s");
            $datos->persona->EstReg = 'A';
            
            $res = $persona->insertarDato($datos->persona);
            
            if($res['estado']){
                $datos->usuario->UseID = $res['ID'];
                $datos->usuario->EstReg = 'A';
                $datos->usuario->OrgID = 1;
                if( !isset($datos->usuario->RolID) || $datos->usuario->RolID==0){
                    //rol del adminsitrador
                    $datos->usuario->RolID = 2;
                }
                $usuario->insertarDato($datos->usuario);
                echo( miJsonIns( $res ) );
                return;
            }
            echo( "No se pudo registrar al administrador" );                
            return;
        }
        
        $usuario = new Usuario();
        echo( miJsonIns( $usuario->insertarDato($datos) ) );
	}
	public function processPUT($datos,$user){
        
        $usuario = new Usuario();
        switch($datos->accion){
			case 1:
                $res = $usuario->verficarUsuario($datos->usuario->NomUsu,$datos->usuario->PasAnt);
                if($res["estado"]){
                    $ID = (object)array("UseID" => $res['resultado']['UseID']);
                    $dato = (object)array("Pas" => $datos->usuario->Pas);
                    echo( miJsonRes( $usuario->actualizarDato($dato,$ID) ) );
                    return;
                }
                echo( miJsonRes2(false,"La contraseña Anterior ingresada no coincide, intente de nuevo") );
                
				break;
			default:
				echo( miJsonRes( $usuario->actualizarDato($datos->dato,$datos->ID) ) );
				break;
		}
	}
	public function processDELETE($datos,$user){
		
		$usuario = new Usuario();
		
		echo( miJsonRes( $usuario->eliminarDato($datos) ) );
	}
}
	$servicio = new ServicioUsuario();
	$servicio->atenderSolicitud();

?>


