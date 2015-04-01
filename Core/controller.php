<?php
if(!defined('INC')) exit();
/**
*	Controller
*	Classe de prétraitements avant chargement du controlleur
*	@author Baptiste WALLERICH
*	@author Guillaume LESNIAK
*	@version 1.2
*/
class Controller extends Entry {
	
	
	/**
	* Constructeur de classe
	* Réceptionne les requêtes avant chargement des controlleurs
	*/
	public function __construct(){
		$this->controllersFolder = $this->get('config')->get('controllers_folder');
		$this->setAllowedControllers();
		
		$controller = $this->getModule();
		$action = $this->getAction();
		$params = $this->getParams();
		
		$this->load($controller, 'controllers');
		$this->launch();
	}
	
	/**
	*	Récupère l'action que l'on souhaite exécuter
	*	@return String Méthode de l'action à exécuter
	*/
	public function getAction() {
		return Core::singleton()->get('entry')->getAction();	
	}
	
	/**
	*	Récupère les paramètres que l'on souhaite exécuter
	*	@return Mixed liste des paramètres de l'action (ou index si aucun paramètre)
	*/
	public function getParams() {
		return Core::singleton()->get('entry')->getParams();	
	}
	
	/**
	*	Alias de $this->load('includes', 'controllers')
	*	@return Void
	*/
	public function loadIncludes() {
		$this->load('includes', 'controllers');
		
	}
		
	/**
	* 	launch()
	* 	Réceptionne une action et l'exécute dans son controlleur
	*	@return Void
	*/
	public function launch(){
		$action = html_entity_decode($this->getAction());
		if ((intval($action) != 0 && intval($action) == $action) || preg_match("/[^A-Za-z0-9]/", $action))
			$this->fallbackError(404);
		else
			eval ('if (method_exists($this->get("'.$this->getModule().'"), "'.$action.'")) { $this->get("' . $this->getModule() . '")->'.$action.'(); } else { $this->fallbackError(404); }');
	}
	
	/**
	*	Génère un message d'erreur
	*	@param Int Code d'erreur à renvoyer
	*	@param Void
	*/
	public function fallbackError($code){
		$this->load('error', 'controllers');
		$this->get('error')->code($code);		
	}
	
	/**
	*	Génère un message d'erreur personnalisé
	*	@param String Contenu du message d'erreur à afficher
	*	@param Void
	*/
	public function fallbackErrorMsg($code){
		$this->load('error', 'controllers');
		$this->get('error')->_custom($code);		
	}
	
	/**
	*	Remplace le nom du jour par le jour en français
	*	@param String Nom du jour en français
	*	@return Strinf Nom du jour en anglais
	*/
	public function replaceDay($day){
		return str_ireplace(array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'), $day);
	}
	
	
	/**
	*	Remplace le nom du jour par le jour en anglais
	*	@param String Nom du jour en anglais
	*	@return String Nom du jour en français
	*/
	public function replaceMonth($month){
		return str_ireplace(array('January','February','March','April','May','June','July','August','September','October','November','December'),array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'), $month);
	}
	
	/**
	*	Convertit une date anglaise au format français
	*	@param String Date au format anglais
	*	@return String Date au format français
	*/
	function frenchizeDate($datestr) {
		return str_replace(array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"),
				 array("lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"),
				 $datestr);
	}
}
?>