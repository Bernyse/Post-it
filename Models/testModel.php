<?php
if (!defined('INC')) die();

class testModel extends Model
{

    public function __construct()
    {

    }

    /**
     * Retourne les informations sur les widgets placés sur l'accueil
     */
    public function getAllUtilisateurs()
    {

        $allUtilisateurs = $this->get('database')->query(
            "SELECT IDUtilisateur, NomUtilisateur, PrenomUtilisateur
        FROM Utilisateurs;"
        );


        $arrayAllUtilisateurs = $this->get('database')->fetchAll($allUtilisateurs);
        return $arrayAllUtilisateurs;

    }

}