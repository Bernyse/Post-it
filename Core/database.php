<?php
if(!defined('INC')) exit();
/**
*	Databasesss
*	Classe d'accès et de traitements sur la BDD
*	@author Baptiste WALLERICH
*	@author Guillaume LESNIAK
*	@version 1.0
*/
class Database extends Core {
	
	/**
	*	Hébergement du serveur de BDD
	*	@access Private
	*/
	private $SQL_HOST;
	
	/**
	*	Root user de la BDD
	*	@access Private
	*/
	private $SQL_USER;
	
	/**
	*	Mot de passe de la BDD
	*	@access Private
	*/
	private $SQL_PASS;
	
	/**
	*	Nom de la BDD
	*	@access Private
	*/
	private $SQL_BASE;
	
	/**
	*	Compteur de requêtes
	*	@access Private
	*/
	private $QueryCount;
	
	/**
	*	Constructeur de classe
	*	Initialise les paramètres d'accès à la BDD
	*	et ouvre une connnection vers celle-ci
	*/
	public function __construct(){
		
		$this->SQL_HOST = $this->get('config')->get('SQL_HOST');
		$this->SQL_USER = $this->get('config')->get('SQL_USER');
		$this->SQL_PASS = $this->get('config')->get('SQL_PASS');
		$this->SQL_BASE = $this->get('config')->get('SQL_BASE');
		
		$this->QueryCount = 0;
		
		$this->connect();
	}
	
	/**
	*	connect
	*	Ouvre une connection vers la BDD
	*/
	private function connect(){
		mysql_connect($this->SQL_HOST, $this->SQL_USER, $this->SQL_PASS);
		mysql_select_db($this->SQL_BASE);
	}
	
	/**
	*	query
	*	Exécute une requête SQL
	*/
	public function query($SQL_Query){
		$return = mysql_query($SQL_Query) or die(mysql_error());
		$this->QueryCount++;
		return $return;
	}
	
	/**
	*	fetch
	*	Récupère plusiers enregistrements depuis la requête
	*/
	public function fetchAll($QueryResult) {
		$lolol = array();
		
		while($fetch = mysql_fetch_assoc($QueryResult)) {
			$lolol[] = $fetch;
		}
		
		return $lolol;
	}
	
	/**
	*	fetch
	*	Récupère un enregistrement depuis la requête
	*/
	public function fetch($QueryResult) {
		return mysql_fetch_assoc($QueryResult);	
	}
	
	/**
	*	count_rows
	*	Récupère le nombre d'enregistrements dans la requête
	*/
	public function count_rows($QueryResult) {
		return mysql_num_rows($QueryResult);
	}
	
	/**
	*	insert_id
	*	Renvoie l'ID de l'enregistrement inséré précédemment
	*/
	public function insert_id() {
		return mysql_insert_id();	
	}
}
?>