<?php
if(!defined('INC')) exit();
/**
*	Model
*	Classe de gestion des modèles
*
*	@author Baptiste WALLERICH
*	@author Guillaume LESNIAK
*	@version 1.0
*/
class Model extends Core {
	protected $Database;
	
	public function __construct() {
		$Database = Core::singleton()->get('database');
	}
	
	/**
	* Retourne si oui ou non la requête est en cache
	*/
	public function isQueryCached($query){
		
	}
	
	public function getCachedResults(){
		
	}
}
?>