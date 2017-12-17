<?php

class Usuario extends ModeloGenerico{
		
	function Usuario(){
		
		parent::__construct("MA_USER");
		
	}
	public function buscarUsuario($usuario,$password){
		//consulta
		$sql = "SELECT u.UseID,u.NomUsu,u.OrgID,r.RolID,r.Nom as rol,p.DNI,p.RUC,p.Nom,p.PriApe,p.SegApe,p.FecNac,p.CiuPro,p.DirAct,p.Ema,p.Tel,p.SexID,p.PaiID,p.EstCivID,p.Img FROM " . $this->nombreTabla . " as u ".
                "JOIN MA_PERSONA as p ON u.PerID=p.PerID LEFT JOIN MA_ROL as r ON u.RolID=r.RolID ".
                "WHERE NomUsu = :1 and Pas = :2 and u.EstReg='A'";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $usuario);
		$consulta->bindParam(':2', $password);
		$consulta->execute();
		
		//$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_LAZY);
		
		
		if(!$resultado )
			return array("estado" => false, "mensaje"=> "ERROR en el registro");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "el usuario si esta registrado");
		
	}
    public function getUsuario($usuarioID){
		//consulta
		$sql = "SELECT u.UseID,u.NomUsu,u.Pas  FROM " . $this->nombreTabla . " as u ".
                "WHERE UseID = :1 and u.EstReg='A'";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $usuarioID);
		$consulta->execute();
		
		//$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_LAZY);
		
		
		if(!$resultado )
			return array("estado" => false, "mensaje"=> "no se encuentra el usuario");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "el usuario si esta registrado");
		
	}
    public function verficarUsuario($usuario,$password){
		//consulta
		$sql = "SELECT u.UseID, p.Ema FROM " . $this->nombreTabla . " as u ".
                "JOIN MA_PERSONA as p ON u.UseID=p.PerID ".
                "WHERE NomUsu = :1 and Pas = :2 and u.EstReg='A'";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $usuario);
		$consulta->bindParam(':2', $password);
		$consulta->execute();
		
		//$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_LAZY);
		
		
		if(!$resultado )
			return array("estado" => false, "mensaje"=> "La contraseña es incorrecta, vuelva a intentarlo");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "el usuario si esta registrado");
		
	}
	public function buscarTrabajadores($usuario,$password){
		//consulta
		$sql = "SELECT u.UseID,u.NomUsu,u.EstID,r.RolID,r.Nom as rol FROM " . $this->nombreTabla . " as u LEFT JOIN MA_ROL as r ON u.RolID=r.RolID WHERE NomUsu = :1 and Pas = :2 and r.RolID!=3";
	
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
	public function buscarDistribuidor($usuario,$password){
		//consulta
		$sql = "SELECT d.DisID as UseID,p.Nom as NomUsu,r.RolID,r.Nom as rol, dp.DisPerID FROM CV_DISTRIBUIDOR as d LEFT JOIN CO_DISTRIBUIDOR_PER as dp ON d.DisID=dp.DisID,MA_PERSONA as p, MA_USER as u LEFT JOIN MA_ROL as r ON u.RolID=r.RolID ".
				"WHERE d.DIsID = :1 and d.UseID=u.UseID and u.Pas = :2 and d.PerID=p.PerID and dp.EstReg='A'";
	
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
	public function actualizarConstraseña($dato,$datoID){
			
		//consulta
		$sql = "UPDATE $this->nombreTabla SET Pas='$dato' WHERE UseID=$datoID";
		
		//return $sql;
		
		//preparando la consulta
		$consulta = $this->coneccion->prepare($sql);
		
		//ejecutando
		if($consulta->execute() )
			return true;
		else
			return false;
	}
	
	public function buscarTodosTrabajadores(){
		//consulta
		$sql = "SELECT u.UseID,u.NomUsu,u.Pas,u.RolID,u.EstID,r.Nom as rol,u.EstReg FROM " . $this->nombreTabla . " as u JOIN MA_ROL as r ON u.RolID=r.RolID WHERE u.RolID>3";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->execute();
		
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		
		if(!$resultados){
			return "error en la consulta : ".mysql_error();
		}			
		return $resultados;
	}
    public function buscarAdmin(){
		//consulta
		$sql = "SELECT u.UseID,u.NomUsu,u.Pas,u.RolID,u.OrgID FROM " . $this->nombreTabla . " as u WHERE u.RolID=1";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        
        if(!$resultado )
			return array("estado" => false, "mensaje"=> "ERROR en el registro");
		
		return array("estado" => true,"resultado" => $resultado, "mensaje"=> "se registro con exito");
	}
    public function buscarAdministrador(){
		//consulta
		$sql = "SELECT * FROM MA_USER as u WHERE u.RolID=2";
        $consulta = $this->coneccion->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        
        if(!$resultado )
			return array("estado" => false, "mensaje"=> "ERROR no esta registrado el administrador");
        
        $sql2 = "SELECT * FROM MA_PERSONA as p WHERE p.PerID=:1";
	
		$consulta = $this->coneccion->prepare($sql2);
        $consulta->bindParam(':1', $resultado['UseID']);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
        
        if(!$resultado2 )
			return array("estado" => false, "mensaje"=> "ERROR no esta registrado el usuario administrador");
		
		return array("estado" => true,"resultado" => array("r1" => $resultado, "r2"=> $resultado2) , "mensaje"=> "se registro con exito");
	}
    public function iniciarSession($usuarioID,$fechaI){			
        $sql = "INSERT INTO MA_REGISTRO_LOG (FecIniSes,UseID)".
        " VALUES('$fechaI','$usuarioID')";
        $consulta = $this->coneccion->prepare($sql);
        $consulta->execute();
        
        return $this->coneccion->lastInsertId();
    }
    public function cerrarSession($sessionID,$fechaF){
        $sql = "UPDATE MA_REGISTRO_LOG SET FecFinSes='$fechaF' WHERE RegLogID=$sessionID";
        $consulta = $this->coneccion->prepare($sql);
        $consulta->execute();
    }
    
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