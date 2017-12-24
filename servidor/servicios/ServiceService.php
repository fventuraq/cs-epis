<?php

require "../modelo/modelo.inc.php";
require "../modelo/ModeloGenerico.php";

include  "FuncionJson.php";

require "GenericService.php";

class ServiceService extends GenericService{
	public function processGET($datos,$user){

		$service = new Service();
        switch($datos->accion){
			case 1:
                echo( miJson( $service->findByOrganization($user->OrgID,$datos->WebSitID) ) );
				return;
			case 2:
				return;
            default:
                echo( miJson( $service->findByOrganization($user->OrgID,$datos->WebSitID) ) );
		}


	}

	public function processPOST($datos,$user){

		$service = new Service();

		$datos->CreDat = $user->Dat;
		$datos->CreByID = $user->UseID;
		$datos->UpdDat = $user->Dat;
		$datos->UpdByID = $user->UseID;
		$datos->RegSta = 'A';

		$datos->OrgID = $user->OrgID;

		$datos->SerID = $service->lastService($user->OrgID, $datos->WebSitID )['SerID'] + 1;


		$res = $service->insertarDato($datos);
		$res['ID'] = $datos->SerID;


		echo( miJsonIns( $res ) );

	}
	public function processPUT($datos,$user){

		$service = new Service();

		$datos->dato->UpdDat = $user->Dat;
		$datos->dato->UpdByID = $user->UseID;

		echo( miJsonRes( $service->actualizarDato($datos->dato,$datos->ID) ) );
	}
	public function processDELETE($datos,$user){

		$service = new Service();

		echo( miJsonRes( $service->delete($datos,$user) ) );
	}
}
	$servicio = new ServiceService();
	$servicio->atenderSolicitud();

?>
