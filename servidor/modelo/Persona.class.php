<?php

class Persona extends ModeloGenerico{
		
	function Persona(){
		
		parent::__construct("MA_PERSONA");
		
	}
	public function buscarPersona($usuario,$password){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " WHERE NomUsu = :1 and Pas = :2";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $usuario);
		$consulta->bindParam(':2', $password);
		$consulta->execute();
		
		//$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_LAZY);
		
		
		if(!$resultado )
			return array("estado" => false, "mensaje"=> "ERROR en el registro");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "se registro con exito");
		
	}
    public function buscarPorDNI($dni){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " WHERE DNI = :1 ";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $dni);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);		
		
		if(!$resultado )
			return array("estado" => false, "mensaje"=> "ERROR en el registro");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "se registro con exito");
	}
    /*
    public function buscarPersona($usuario,$password){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " WHERE NomUsu = :1 and Pas = :2";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $usuario);
		$consulta->bindParam(':2', $password);
		$consulta->execute();
		
		//$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_LAZY);
		
		
		if(!$resultado )
			return array("estado" => false, "mensaje"=> "ERROR en el registro");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "se registro con exito");
		
	}*/
	/*
	public function insertar($dato){
		
		$consulta = $this->coneccion->prepare('INSERT INTO '.$this->nombreTabla.' (Cod,Nom,Des,Can,Pre,UniMedID,MonID) VALUES(:Cod,:Nom,:Des,:Can,:Pre,:UniMedID,:MonID)');
		$consulta->bindParam(':Cod', $dato->Cod);
		$consulta->bindParam(':Nom', $dato->Nom);
		$consulta->bindParam(':Des', $dato->Des);
		$consulta->bindParam(':Can', $dato->Can);
		$consulta->bindParam(':Pre', $dato->Pre);
		$consulta->bindParam(':UniMedID', $dato->UniMedID);
		$consulta->bindParam(':MonID', $dato->MonID);
		
		$consulta->execute();	
		
	}*/
}
?>