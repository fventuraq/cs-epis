<?php

require "bd/coneccionBD.php";
require "modelo/ModeloGenerico.php";
include  "modelo/WebSite.class.php";
include  "modelo/Container.class.php";
include  "modelo/Product.class.php";
include  "modelo/Service.class.php";
include  "modelo/Content.class.php";

	function processGET($user){

		$web = new WebSite();
		$con = new Container();
		$pro = new Product();
		$ser = new Service();
		$cont = new Content();
        switch($user->accion){
			case 1:
				return;
			case 2:
				return;
            default:


				$json = "{";
                $json .= "\"web\":" . json_encode($web->findByOrganizationWeb($user->org,$user->web));
                $json .= ',';
								$json .= "\"sections\":" . json_encode($con->findByOrganization($user->org,$user->web));
                $json .= ",";
								$json .= "\"products\":" . json_encode($pro->findByOrganization($user->org,$user->web));
								$json .= ",";
								$json .= "\"services\":" . json_encode($ser->findByOrganization($user->org,$user->web));
								/*$json .= ",";
								$json .= "\"content\":" . json_encode($cont->findByContainer($user->con,$user->con));*/
			$json .= "}";

                echo( $json );
		}

	}

	function atenderSolicitud(){

		//recibiendo el tipo de metodo
		$metodo = $_SERVER['REQUEST_METHOD'];


		// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
		switch ($metodo) {
			// Lectura
			// código para método GET
			case 'GET':
				$user = (object)$_GET;
				processGET($user);
				break;
			default:
				echo('{"data":"ERROR"}');
				break;
		}
	}
	atenderSolicitud();

?>
