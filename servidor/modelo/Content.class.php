<?php

class Content extends ModeloGenerico{

	function Content(){

		parent::__construct("WS_CONTENT_INF");

	}
	public function findByContainer($ConID){

		try{
			//consulta
			$sql = "SELECT * FROM " . $this->nombreTabla . " c WHERE c.ConID=:1";

			$consulta = $this->coneccion->prepare($sql);
			$consulta->bindParam(':1', $ConID);
			$consulta->execute();

			$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

			if(!$resultados){
				return $resultados;//"no hay datos ";
			}
			return $resultados;
		}
		catch (Exception $e){
			return "error en la consulta : ".mysql_error();
		}
	}
	public function lastContent($ConID){
		//consulta
		//$sql = "SELECT MAX(ConID) as ConID FROM " . $this->nombreTabla ." WHERE OrgID=:1 AND WebSitID=:2";
		$sql = "SELECT MAX(ConInfID) as ConInfID FROM " . $this->nombreTabla ." ";

		$consulta = $this->coneccion->prepare($sql);
		//$consulta->bindParam(':1', $orgID);
		//$consulta->bindParam(':2', $webSitID);
		$consulta->execute();

		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

		if(!$resultado )
			return 0;

		return $resultado;
	}
}
?>
