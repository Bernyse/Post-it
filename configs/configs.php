<?php
if(!defined('INC')) exit();
/**
 * Configs  -
 * Implémentation du pattern registry et singleton
 *
 */
$configs = array(

	/**
	*	Configurations générales
	*/
	'framework_name' => 'PostItFwk',
	'framework_version' => '0.3',
	
	/**
	*	Configurations de la BDD
	*/
	'SQL_HOST' => 'http://db571212032.db.1and1.com/',
	'SQL_USER' => 'dbo571212032',
	'SQL_PASS' => 'mpamab15!',
	'SQL_BASE' => 'db571212032',
	
	/**
	*	Mode de développement : alpha, beta, production
	*	Utilisé pour la configuration du debug, des logs..
	*/
	'DVPT_MODE' => 'beta',
	
	'BENCHMARK_MODE' => false,
	
	/**
	*	Configurations des libraires coeur
	*/
		/**
		*	Librairie view (template)
		*/
		'views_folder' => './views/',
		
		/**
		*	Librairie view (template)
		*/
		'controllers_folder' => './controllers/',
		
		/**
		*	Librairie debug
		*/
		'logs_folder' => './logs/'

);
