<?php

require "../modelo/modelo.inc.php";
require "../modelo/ModeloGenerico.php";

include  "FuncionJson.php";

require "GenericService.php";

class ContentService extends GenericService{
	public function processGET($datos,$user){

		$content = new Content();
        switch($datos->accion){
			case 1:
                echo( miJson( $content->findByContainer($user->ConID,$datos->ConID) ) );
				return;
			case 2:
				return;
            default:
                echo( miJson( $content->findByContainer($user->ConID,$datos->ConID) ) );
		}


	}

	public function processPOST($datos,$user){

		$content = new Content();

		$datos->CreDat = $user->Dat;
		$datos->CreByID = $user->UseID;
		$datos->UpdDat = $user->Dat;
		$datos->UpdByID = $user->UseID;
		$datos->RegSta = 'A';

		$datos->ConID = $user->ConID;

		$datos->ConInfID = $content->lastContent($user->ConID, $datos->ConID )['ConID'] + 1;


		$res = $content->insertarDato($datos);
		$res['ID'] = $datos->ConInfID;


		echo( miJsonIns( $res ) );

	}
	public function processPUT($datos,$user){

		$content = new Content();

		$datos->dato->UpdDat = $user->Dat;
		$datos->dato->UpdByID = $user->UseID;

		echo( miJsonRes( $content->actualizarDato($datos->dato,$datos->ID) ) );
	}
	public function processDELETE($datos,$user){

		$content = new Content();

		echo( miJsonRes( $content->delete($datos,$user) ) );
	}
}
	$servicio = new ContentService();
	$servicio->atenderSolicitud();

?>
