<?php
if(!defined('INC')) exit();
/**
*	Entry
*	Classe de gestion des entrées sur l'application
*	Traite les requêtes pour en extraire les modules, actions et paramètres
*	@author Baptiste WALLERICH
*	@author Guillaume LESNIAK
*   @version 1.0
*/
class Entry extends Core {
	
	/**
	*	URI, destinée au rotuage des actions sur le site
	*	@access public
	*/
	private $URI;
	
	
	/**
	* Tableau des controlleurs existants
	* @access private
	*/
	private $allowedControllers = array();
	
	/**
	*	Dossier contenant les controlleurs
	*	@access protected
	*/
	protected $controllersFolder;
	
	/**
	*	setAllowedControllers
	*	Définit à partir du dossier des controlleurs
	*	la liste des controlleurs autorisés
	*	@return Void
	*/
	public function setAllowedControllers(){
		
		// On liste les controlleurs présents dans $this->controllersFolder
		$controllerList = scandir($this->controllersFolder);
		
		// On dégage le dossier racine et le dossier parent (. et ..)
		unset($controllerList[0], $controllerList[1]);
		
		// Ensuite on enlève les extensions .php
		$controllerList = str_replace(EXT, '', $controllerList);
		
		// On définit un joli tableau de controlleurs
		$this->allowedControllers = $controllerList;
	}
	
	/**
	 *  Retourne si oui ou non un controlleur est autorisé
	 *	@return boolean Le contrôlleur est-il autorisé ?
	 */
	public function isControllerAllowed($name) {
		return in_array($name, $this->allowedControllers);
	}
	
	/**
	*	Constructeur de classe
	*	Récupère la requête HTTP 
	*/
	public function __construct(){		
		$this->setHeaders();
	}
	
	/**
	*	getModule
	*
	*	Récupère le module (aka controlleur) à exécuter 
	*	@return String Une chaine contenant le nom du module
	*/
	public function getModule(){
		
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		
		if(!empty($uri[1])){
			
			if ($this->isControllerAllowed($uri[1])) {
				return $uri[1];
			}
			else {
				return 'error';
			}
		} else {
			return 'home';
		}
	}
	
	/**
	*	getAction
	*
	*	Récupère l'action a exécuter
	*	@return String Une chaine contenant l'action et index si pas d'action
	*/
	public function getAction(){
		
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		
		if(!empty($uri[2])){
			return $uri[2];
		} else {
			return 'index';
		}
	}
	
	/**
	*	getParams
	*
	*	Récupère les paramètres de l'action a exécuter
	*	@return Un tableau contenant les paramètres.
	*/
	public function getParams(){
		
		$uri = explode('/', $_SERVER['REQUEST_URI']);

		unset($uri[1], $uri[2]);
		return array_values($uri);
	}
	
	/**
	* getBrowserUserAgent
	* Récupère l'User-Agent du navigateur
	*/
	public function getBrowserUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	/**
	* getBrowserLanguage
	* Récupère la langue du navigateur
	*/
	public function getBrowserLanguage() {
		return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}
	
	/**
	* setHeaders
	* Définit des headers HTTP
	*/
	private function setHeaders(){

		/* 
			Apache renvoie du contenu utf-8, donc pensez bien à enregistrer vos fichiers à ce format
			On peut utiliser les accents et tous les carctères utf-8 sur tout le site y'a plus qu'a filtrer
		*/
		header('Content-type: text/html; charset=utf-8');

	}
}
?>