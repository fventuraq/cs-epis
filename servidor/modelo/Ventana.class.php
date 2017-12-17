<?php

class Ventana extends ModeloGenerico{
		
	function Ventana(){
		
		parent::__construct("MA_VENTANA");
		
	}
	public function buscarTodosSinPadres(){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " v WHERE v.VenPadID IS null and v.EstReg='A'";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->execute();
		
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		
		if(!$resultados){
			return "error en la consulta : ".mysql_error();
		}			
		return $resultados; 
	}
}
?>