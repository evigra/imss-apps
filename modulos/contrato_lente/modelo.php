<?php
	class 
	contrato_lente extends contrato
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		public $mod_menu		=array();
		public $sys_table		="contrato";
		public $module			="contrato_lente";
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function __CONSTRUCT($option=array())
		{	
			$this->sys_fields["detalle_ids"]["class_name"]	="contrato_lente_detalle";
			parent::__CONSTRUCT($option);
		}
	}
?>
