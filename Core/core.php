<?php
if(!defined('INC')) exit();
/**
 * Core
 * Le coeur de la machine !
 * Implémentation du pattern registry et singleton
 *
 * @version 1.0
 * @author Baptiste Wallerich
 */
class Core {

	/**
	 * Tableau contenant les références des objets
	 * @access private
	 */
	private static $objets = array();

	/**
	 * Instance de Registry
	 * @access private
	 */
	private static $instance;

	/**
	 * Constructeur private -> impossible de créer un Registry directement
	 * @access private
	 */
	private function __construct(){}

	/**
	 * design pattern Singleton : permet un instance unique de la classe coeur
	 * @access public
	 * @return Core
	 */
	public static function singleton(){
		
		// Si aucune instance de cet objet est définie alors instancier cette classe
		if( !isset( self::$instance ) ){
			$obj = __CLASS__;
			self::$instance = new $obj;
		}
		// Sinon, c'est que Registry est instancié donc on peut le retourner
		return self::$instance;
	}

	/**
	 * On interdit le clonage d'objet puisque l'on veut une instance unique de core
	 */
	public function __clone(){
		trigger_error( 'Clonage de Core impossible', E_USER_ERROR );
	}

	/**
	 * Charge un objet passé en paramètre dans Core
	 * @param String $objet le nom de l'objet à stocker sera également 
	 *				 		la clé dans le tableau d'objets de Core
	 * @param String $folder type d'objet : 'libs', 'views', 'models'. Par défaut 'libs'
	 * @return void
	 */
	public function load( $objet, $folder = 'libs' ){
		
		// Si un objet de tel nom a déjà été créé alors on lance un erreur
		if(array_key_exists($objet, self::$objets)){
			//trigger_error( 'Cet objet est déjà instancié !', E_USER_ERROR );
		
		// Sinon on requiert la librairie coresspondant
		} else {
			if($folder == 'libs'){
				require_once('libs/' . $objet . EXT);
				self::$objets[ $objet ] = new $objet( self::$instance );
			
			} elseif($folder == 'views'){
				require_once('views/' . $objet . EXT);
				self::$objets[ $objet ] = new $objet( self::$instance );
			
			} elseif($folder == 'core'){
				require_once('core/' . $objet . EXT);
				self::$objets[ $objet ] = new $objet( self::$instance );
			
			} elseif($folder == 'controllers'){
				require_once('controllers/' . $objet . EXT);
				self::$objets[ $objet ] = new $objet( self::$instance );
			
			} elseif($folder == 'models'){
				require_once('models/' . $objet . EXT);
				self::$objets[ $objet ] = new $objet( self::$instance );
			
			} else {
				trigger_error( 'Dossier de l\'objet '.$objet.' inconnu !', E_USER_ERROR );
			}	
		}
	}

	/**
	 * Récupère la référence d'un objet
	 * @param String $key Nom de l'objet à récupérer dans le tableau
	 * @return object de type $key
	 */
	public function get( $key ){
		
		if( is_object ( self::$objets[ $key ] ) ){
			return self::$objets[ $key ];
		}
	}
}

?>