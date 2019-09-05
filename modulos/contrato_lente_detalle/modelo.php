<?php
	class contrato_lente_detalle extends contrato_detalle
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		public $mod_menu		=array();
		public $sys_table		="contrato_detalle";
		public $module			="contrato_lente_detalle";
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function __CONSTRUCT($option=array())
		{				
			$this->sys_fields["char1"]["title"]	="Armazon";
			$this->sys_fields["char2"]["title"]	="Unidad";
			$this->sys_fields["num1"]["title"]	="Costo";
			
			parent::__CONSTRUCT($option);
		}
		##############################################################################
   		public function __SAVE($datas=NULL,$option=NULL)
    	{    		

			#if(isset($this->module))
    			$datas["modulo"]	=$this->module;    		    		    		    	    	
			
			$return 			=parent::__SAVE($datas,$option);
    	    return $return;
		}				   		
		public function __AUTOCOMPLETE()		
    	{	
    		$option								=array();
    		
    		#$option["echo"]						="LENTE DETALLE";
    		
    		#if($this->sys_private["section"]=="create" OR $this->sys_private["section"]=="write")
    		{
    			$option["select"]					="contrato.*, contrato_detalle.*";
    			$option["from"]						="contrato  join contrato_detalle  on contrato.id = contrato_detalle.contrato_id";
    			$option["where"][]					="contrato_detalle.nombre LIKE '%{$_GET["term"]}%'";
    		}
    		
    		$option["where"]					=array();    		
    		$option["where"][]					="contrato.fecha_inicio <='{$_SESSION["var"]["date"]}'";
    		$option["where"][]					="contrato.fecha_fin 	>='{$_SESSION["var"]["date"]}'";
    		
    		
			$return 							=$this->__BROWSE($option);    				
			return $return;			
		}									
	}
?>
