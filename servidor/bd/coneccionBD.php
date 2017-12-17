<?php
	require_once('configBD.php');
	
	class ConeccionBD{
		private $coneccion;
		private static $instancia = null;		
		
		private function __construct(){
			
			try{	
				//conectandonos con la BD 
				$this->coneccion = new PDO("". TIPO_BD .":host=" . HOST_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, PASSWORD_BD);
				//esto nos ayuda para que se maneje las exepciones
				$this->coneccion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->coneccion -> exec("set names utf8");
			}
			catch(PDOException $ex){
				echo "ERROR CONECCION: " . $ex->getMessage();
				return;
			}
		}
		public static function getConeccionBD(){
			
			// verificando si la instancia ya existe
			if(self::$instancia == null) {
				self::$instancia = new ConeccionBD();
			}
			 
			return self::$instancia->coneccion;
		
		}
	}
?>