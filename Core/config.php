<?php
if(!defined('INC')) exit();
/**
 * Config
 * Un objet qui gère les configurations du site
 * Les configs sont stockées dans le fichier configs/configs.php 
 *
 * @version 0.1
 * @author Poppy
 */
class Config {
	
	private $configsPath = 'configs/configs.php';
	private $configs = array();
	
	/**
	*	Constructeur
	*	Charge le tableau de configurations dans $configs
	*/
	public function __construct(){
		require_once($this->configsPath);
		$this->configs = $configs; 
	}
	
	/**
	*	Retourne une config
	*	@param String Clé de la config à récupérer
	*	@return Mixed Configuration que l'on souhaite récupérer
	*/
	public function get($key){
		return $this->configs[$key];
	}
	
	/**
	*	Modifie une config
	*	@param String Clé de la config à upadater
	*	@param Mixed  Contenu de la config
	*	@return Void
	*/
	public function set($key, $content){
		$this->configs[$key] = $content;
	}
	
}

?>