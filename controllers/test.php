<?php
if(!defined('INC')) exit();

class Event extends Controller
{

    public function __construct()
    {
        $this->load('testModel', 'models');
    }


    function index()
    {
        $this->get('view')->set_filenames(array(
            'body' => 'test.tpl'
        ));

        $this->loadIncludes();

        $this->get('includes')->get('view')->assign_var('HTML_PAGE_TITLE', 'Liste des utilisateurs');


        $allUtilisateurs = $this->get('eventModel')->getAllUtilisateurs();

        if (count($allUtilisateurs) == 0) {
            $this->get('view')->assign_block_vars('noEvents', array('' => ''));
        }

        foreach ($allUtilisateurs as $utilisateur) {
            $this->get('view')->assign_block_vars('allUtilisateurs', array('ID' => $utilisateur['IDUtilisateur'], 'Nom' => $utilisateur['NomUtilisateur'], 'Prenom' => $utilisateur['PrenomUtilisateur']));
        }

    }
}