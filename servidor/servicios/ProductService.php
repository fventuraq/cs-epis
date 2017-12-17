<?php

require "../modelo/modelo.inc.php";
require "../modelo/ModeloGenerico.php";

include  "FuncionJson.php";

require "GenericService.php";

class ProductService extends GenericService{
	public function processGET($datos,$user){

		$product = new Product();
        switch($datos->accion){
			case 1:
                echo( miJson( $product->findByOrganization($user->OrgID,$datos->WebSitID) ) );
				return;
			case 2:
				return;
            default:
                echo( miJson( $product->findByOrganization($user->OrgID,$datos->WebSitID) ) );
		}


	}

	public function processPOST($datos,$user){

		$product = new Product();
				
		$datos->CreDat = $user->Dat;
		$datos->CreByID = $user->UseID;
		$datos->UpdDat = $user->Dat;
		$datos->UpdByID = $user->UseID;
		$datos->RegSta = 'A';

		$datos->OrgID = $user->OrgID;

		$datos->ProID = $product->lastProduct($user->OrgID, $datos->WebSitID )['ProID'] + 1;


		$res = $product->insertarDato($datos);
		$res['ID'] = $datos->ProID;


		echo( miJsonIns( $res ) );

	}
	public function processPUT($datos,$user){

		$product = new Product();

		$datos->dato->UpdDat = $user->Dat;
		$datos->dato->UpdByID = $user->UseID;

		echo( miJsonRes( $product->actualizarDato($datos->dato,$datos->ID) ) );
	}
	public function processDELETE($datos,$user){

		$product = new Product();

		echo( miJsonRes( $product->delete($datos,$user) ) );
	}
}
	$servicio = new ProductService();
	$servicio->atenderSolicitud();

?>
