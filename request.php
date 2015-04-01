<?php
/**
*	request.php
*	Point pour les requêtes AJAX/XHR
*	@author Guillaume LESNIAK
*/

// Constantes pour les dossiers
define('DS', DIRECTORY_SEPARATOR);
define('TRUNK_FOLDER', 'public_html');
//define('TRUNK_FOLDER', 'trunk');
define('ROOT', dirname(dirname(__FILE__)));
define('EXT', '.php');
define('INC', null);
date_default_timezone_set("Europe/Berlin");
session_start();

// Inclusion du coeur
require_once('core' . DS . 'core.php');

// Récupération du singleton du coeur du framework !
// Registre d'objets
$CFWK = Core::singleton();

// Chargement de la librairie traitant les requêtes entrant vers le serveur
$CFWK->load('config', 'core');
//$CFWK->load('debug', 'core');
$CFWK->load('database', 'core');
$CFWK->load('sessionmgr', 'core');
//$CFWK->load('contentmgr', 'core');
//$CFWK->load('permissionsmgr', 'core');
$CFWK->load('model', 'core');
//$CFWK->load('view', 'core');

//$CFWK->load('searchengine', 'core');
//$CFWK->load('model', 'core');
$Database = $CFWK->get('database');

if (!$CFWK->get('sessionmgr')->isConnected()) {
	header('Location: /home');
	exit();
}


// Fonction convertit une date de type "Mon 2 January 2012" en "Lundi 2 janvier 2012"
function frenchizeDate($datestr) {
	return str_replace(array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"),
				 array("lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"),
				 $datestr);
}

?>