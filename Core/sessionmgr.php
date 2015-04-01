<?php
if(!defined('INC')) exit();
/**
*	SessionMgr
*	Gère la session utilisateur
*
*	@author Guillaume LESNIAK
*   @version 1.0
*/

class SessionMgr extends Core {
	/**
	*	Variable qui met en cache le nom complet
	*/
	private $FullName;
	
	private $GroupID;
	
	private $Admin = false;
	
	public function __construct() {
		$this->rebuildSessionFromCookie();
		
		// Met à jour les statistiques date dernière page vue
		if ($this->isConnected()) {
			/*$this->get('database')->query("INSERT INTO utilisateurs_activite VALUES('".$_SESSION['GUID']."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."') ON DUPLICATE KEY UPDATE DateDernierePage='".date("Y-m-d H:i:s")."', DateDernierPing='".date("Y-m-d H:i:s")."';");*/
			$this->get('database')->query("UPDATE LOW_PRIORITY utilisateurs SET DateConnexion=NOW() WHERE GUID='".intval($_SESSION['GUID'])."' LIMIT 1");
		}
		
	}
	
	/**
	*	Retourne si l'utilisateur est actuellement connecté
	*/
	public function isConnected() {
		if (!isset($_SESSION))
			return false;
		else
			return !empty($_SESSION['email']) && !empty($_SESSION['GUID']);	
	}
	
	/**
	*	Retourne le GUID de l'utilisateur
	*/
	public function getGUID() {
		if (!$this->isConnected())
			return -1;
		else
			return intval($_SESSION['GUID']);	
	}
	
	/**
	*	Retourne le nom complet (Prénom Nom) de l'utilisateur
	*/
	public function getName() {
		if (empty($this->FullName)) {
			$fetch = $this->get('database')->fetch($this->get('database')->query("SELECT Nom, Prenom, IDGroupe, Actif FROM utilisateurs WHERE GUID='".$this->getGUID()."' LIMIT 1"));
			$this->FullName = $fetch['Prenom']." ".$fetch['Nom'];
			$this->GroupID = $fetch['IDGroupe'];
			
			if ($fetch['Actif'] == 2)
				$this->Admin = true;
			else
				$this->Admin = false;
		}
		
		return $this->FullName;
	}
	
	public function isAdministrator() {
		$this->getName();		
		return $this->Admin;
	}
	
	/**
	*	Retourne le nom complet (Prénom Nom) de l'utilisateur
	*/
	public function getNameFromID($guid) {
		$fetch = $this->get('database')->fetch($this->get('database')->query("SELECT Nom, Prenom FROM utilisateurs WHERE GUID='".intval($guid)."' LIMIT 1"));
		return $fetch['Prenom']." ".$fetch['Nom'];
	}
	
	/** 
	 * Retourne la photo de l'utilisateur
	 */
	public function getPhotoOfID($guid) {
		$fetch = $this->get('database')->fetch($this->get('database')->query("SELECT IDPhoto FROM utilisateurs WHERE GUID='".intval($guid)."' LIMIT 1"));
		return $fetch['IDPhoto'];
	}
	
	/**
	* 	Retourne l'ID du groupe de l'utilisateur
	*/
	public function getGroupID() {
		if (empty($this->GroupID))
			$this->getName();
			
		return $this->GroupID;	
	}
	
	public function getSubscriptionDate() {
		$fetch = $this->get('database')->fetch($this->get('database')->query("SELECT DateInscription FROM utilisateurs WHERE GUID='".$this->getGUID()."' LIMIT 1"));
		return $fetch['DateInscription'];
	}
	
	/**
	*	Génère la session
	*/
	public function buildSession($email, $pass, $guid) {
		$_SESSION['GUID'] = $guid;
		$_SESSION['email'] = $email;
		$_SESSION['sha1_pass'] = $pass;
	}
	
	/**
	*	Génère un cookie à partir de la session actuelle
	*	voir buildSession()
	*/
	public function buildCookie() {
		setcookie("U_L", $_SESSION['email'], time() + 3600*24*365, '/');
		setcookie("U_P", $_SESSION['sha1_pass'], time() + 3600*24*365, '/');
	}
	
	/**
	* Régénère une session depuis un cookie (si possible et valide)
	*/
	public function rebuildSessionFromCookie(){
		if (empty($_SESSION['email']) && !empty($_COOKIE['U_L']) && !empty($_COOKIE['U_P'])) {
			$query = ($this->get('database')->query('SELECT GUID, EMail, Password FROM utilisateurs WHERE EMail="'.mysql_real_escape_string($_COOKIE['U_L']).'" AND Password="'. mysql_real_escape_string($_COOKIE['U_P']). '" LIMIT 1'));
			
			if (mysql_num_rows($query) == 1) {
				$userOK = $this->get('database')->fetch($query);
				$this->buildSession($userOK['EMail'], $userOK['Password'], $userOK['GUID']);
			}
			else {
				setcookie("U_L", "", 0, '/');
				setcookie("U_P", "", 0, '/');	
			}
		}
		else {
		
		}
	}
	
	
	/**
	* 	Libère la session et le cookie
	*/
	public function clearSession() {
		session_destroy();
		setcookie("U_L", "", 0, '/');
		setcookie("U_P", "", 0, '/');	
	}
}

?>