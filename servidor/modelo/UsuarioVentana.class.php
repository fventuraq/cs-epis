<?php

class UsuarioVentana extends ModeloGenerico{
		
	function UsuarioVentana(){
		
		parent::__construct("MA_ROL_VEN");
		
	}
	public function buscarTodosPorUsuario($usuarioID){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " as uv LEFT JOIN MA_VENTANA as v ON uv.VenID=v.VenID WHERE uv.UseID = :1";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $usuarioID);
		$consulta->execute();
		
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		
		if(!$resultados){
			return "error en la consulta : ".mysql_error();
		}			
		return $resultados; 
	}
    public function buscarTodosPorRol($rolID){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " as rv JOIN MA_VENTANA as v ON rv.VenID=v.VenID WHERE rv.RolID = :1 ORDER BY rv.NumOrd";
        
        //RolID,VenID,Per,NumOrd,Nom,Url,Lin,Ctr,Ico,EstReg,VenPadID
        $sql2 = "SELECT rv.RolID,v2.VenID,rv.Per,rv.NumOrd,v2.Nom,v2.Url,v2.Lin,v2.Ctr,v2.Ico,v2.EstReg,v2.VenPadID FROM " . $this->nombreTabla . " as rv ".
        "LEFT JOIN MA_VENTANA as v ON rv.VenID=v.VenID JOIN MA_VENTANA as v2 ON v.VenID=v2.VenPadID WHERE rv.RolID = :1 ORDER BY rv.NumOrd ,v2.VenID";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $rolID);
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
        $consulta = $this->coneccion->prepare($sql2);
		$consulta->bindParam(':1', $rolID);
		$consulta->execute();
		$resultados2 = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
        $numHijos = count($resultados2);
        /*
        if($numHijos==0)
            return array("estado" => false, "mensaje"=> "ERROR el rol no tiene asignado ninguna funcion");*/

        $i = 0;
        foreach($resultados as &$clave ) {
            
            $menus = array();
            while( $i < $numHijos && $clave['VenID'] == $resultados2[$i]['VenPadID']){
                array_push($menus,$resultados2[$i]);
                $i++;
            }
            if( count($menus) > 0 )
                $clave['menus'] = $menus;
        }
        unset($clave);
        
        
        
        if(!$resultados )
			return array("estado" => false, "mensaje"=> "ERROR el rol no tiene asignado ninguna funcion");		
		return array("estado" => true,"resultado" => $resultados, "mensaje"=> "se registro con exito");
	}
    /*
	public function buscarTodosPorRol($rolID){
		//consulta
		$sql = "SELECT * FROM " . $this->nombreTabla . " as rv LEFT JOIN MA_VENTANA as v ON rv.VenID=v.VenID WHERE rv.RolID = :1";
	
		$consulta = $this->coneccion->prepare($sql);
		$consulta->bindParam(':1', $rolID);
		$consulta->execute();
		
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
		//$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		
		if(!$resultados){
			return "error en la consulta : ".mysql_error();
		}			
		return $resultados; 
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