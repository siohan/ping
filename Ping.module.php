<?php

#-------------------------------------------------------------------------
# Module : Ping - 
# Version : 0.8.0.2, Sc
# Auteur : AssoSimple
#-------------------------------------------------------------------------
/**
 *
 * @author AssoSimple
 * @since 0.1
 * @version $Revision: 3827 $
 * @modifiedby $LastChangedBy: Claude
 * @lastmodified $Date: 2020-25-10 11:56:16 +0200 (Mon, 25 oct 2020) $
 * @license GPL
 **/

class Ping extends CMSModule
{
  
  function GetName() { return 'Ping'; }   
  function GetFriendlyName() { return $this->Lang('friendlyname'); }   
  function GetVersion() { return '0.8.0.2'; }  
  function GetHelp() { return $this->Lang('help'); }   
  function GetAuthor() { return 'AssoSimple'; } 
  function GetAuthorEmail() { return 'contact@assosimple.fr'; }
  function GetChangeLog() { return $this->Lang('changelog'); }
    
  function IsPluginModule() { return true; }
  function HasAdmin() { return true; }   
  function GetAdminSection() { return 'content'; }
  function GetAdminDescription() { return $this->Lang('moddescription'); }
 
  function VisibleToAdminUser()
  {
    	return 
		$this->CheckPermission('Ping Use');
	
  }
  
  
  function GetDependencies()
  {
	return array('CGSmartImage'=>'1.22.7');
  }

  

  function MinimumCMSVersion()
  {
    return "2.0";
  }

  
  function SetParameters()
  { 
  	$this->RegisterModulePlugin();
	$this->RestrictUnknownParams();
	
	//form parameters
	$this->SetParameterType('submit',CLEAN_STRING);
	$this->SetParameterType('tourlist',CLEAN_INT);
	$this->SetParameterType('equipelist',CLEAN_STRING);
	$this->SetParameterType('type_compet',CLEAN_STRING);
	$this->SetParameterType('record_joueur', CLEAN_STRING);
	$this->SetParameterType('cancel',CLEAN_STRING);
	$this->SetParameterType('id_user',CLEAN_INT);
	$this->SetParameterType('nom_complet',CLEAN_STRING);
	$this->SetParameterType('adresse',CLEAN_STRING);
	$this->SetParameterType('codepostal',CLEAN_INT);
	$this->SetParameterType('eq_id',CLEAN_INT);
	$this->SetParameterType('commune',CLEAN_STRING);
	$this->SetParameterType('email',CLEAN_STRING);
	$this->SetParameterType('confirm_email',CLEAN_STRING);
	$this->SetParameterType('record_id', CLEAN_INT);
	$this->SetParameterType('type_competition', CLEAN_STRING);
	$this->SetParameterType('date_compet', CLEAN_NONE);
	$this->SetParameterType('adversaires', CLEAN_STRING);
	$this->SetParameterType('tour', CLEAN_INT);
	$this->SetParameterType('equipe', CLEAN_STRING);
	$this->SetParameterType('locaux', CLEAN_STRING);
	$this->SEtParameterType('joueur', CLEAN_STRING);
	$this->SetParameterType('id', CLEAN_INT);
	$this->SetParameterType('numero', CLEAN_INT);
	$this->SetParameterType('licence', CLEAN_INT);
	$this->SetParameterType('advlic', CLEAN_INT);
	$this->SetParameterType('vd', CLEAN_STRING);
	$this->SetParameterType('numjourn', CLEAN_INT);
	$this->SetParameterType('codechamp', CLEAN_STRING);
	$this->SetParameterType('date', CLEAN_STRING);
	$this->SetParameterType('advsexe', CLEAN_STRING);
	$this->SetParameterType('advnompre', CLEAN_STRING);
	$this->SetParameterType('pointres', CLEAN_STRING);
	$this->SetParameterType('coefchamp', CLEAN_STRING);
	$this->SetParameterType('advclaof', CLEAN_STRING);
	$this->SetParameterType('club_uniquement', CLEAN_INT);
	$this->SetParameterType('template', CLEAN_INT);
	$this->SetParameterType('edit', CLEAN_STRING);
	$this->SetParameterType('limit', CLEAN_INT);
	$this->SetParameterType('step', CLEAN_NONE);
	//
	$this->SetParameterType('datecreated', CLEAN_STRING);
	$this->SetParameterType('datemaj', CLEAN_STRING);
	$this->SetParameterType('mois', CLEAN_INT);
	$this->SetParameterType('month', CLEAN_STRING);
	$this->SetParameterType('monthslist',CLEAN_INT);
	$this->SetParameterType('annee', CLEAN_INT);
	$this->SetParameterType('phase', CLEAN_INT);
	$this->SetParameterType('nom', CLEAN_STRING);
	$this->SetParameterType('prenom', CLEAN_STRING);
	$this->SetParameterType('actif', CLEAN_INT);
	$this->SetParameterType('point', CLEAN_INT);
	$this->SetParameterType('clnat', CLEAN_INT);
	$this->SetParameterType('rangreg', CLEAN_INT);
	$this->SetParameterType('rangdep', CLEAN_INT);
	$this->SetParameterType('progmois', CLEAN_INT);
	$this->SetParameterType('saison', CLEAN_STRING);
	$this->SetParameterType('date_debut', CLEAN_STRING);
	$this->SetParameterType('date_fin', CLEAN_STRING);
	$this->SetParameterType('type', CLEAN_STRING);
	$this->SetParameterType('idpoule', CLEAN_INT);
	$this->SetParameterType('iddiv', CLEAN_INT);
	$this->SetParameterType('idepreuve', CLEAN_NONE);
	$this->SetParameterType('tableau', CLEAN_INT);
	$this->SetParameterType('lien', CLEAN_STRING);
	$this->SetParameterType('message', CLEAN_STRING);
	$this->SetParameterType('stall', CLEAN_INT);
	$this->SetParameterType('retrieve', CLEAN_STRING);
	$this->SetParameterType('direction', CLEAN_STRING);
	$this->SetParameterType('numero_equipe', CLEAN_STRING);
	$this->SetParameterType('template',CLEAN_STRING);
	$this->SetParameterType('display',CLEAN_STRING);
	$this->SetParameterType('number', CLEAN_INT);

}

public function InitializeAdmin()
{
  
	 return parent::InitializeAdmin();
	$this->SetParameters();
	//$this->CreateParameter('pagelimit', 100000, $this->Lang('help_pagelimit'));
	$this->CreateParameter('tour', 1, $this->Lang('help_tour'));
	$this->CreateParameter('type_compet', 1, $this->Lang('help_type_compet'));
	$this->CreateParameter('date_debut', '', $this->Lang('help_date_debut') );
	$this->CreateParameter('date_fin', '', $this->Lang('help_date_fin') );
	$this->CreateParameter('limit', 10000, $this->Lang('help_limit'));
}

public function HasCapability($capability, $params = array())
{
   if( $capability == 'tasks' ) return TRUE;
   return FALSE;
}

public function get_tasks()
{
   $obj = array();
   /*
	$obj[0] = new PingRecupFfttTask();
	$obj[1] = new PingRecupSpidTask();  
	$obj[2] = new PingRefreshFfttTask();
	$obj[3] = new PingRecupRencontresTask();
	$obj[4] = new PingRecupUsersTask();
	$obj[5] = new PingDetailsRencontresTask();
	$obj[6] = new PingClassementsTask();
	*/
return $obj; 
}

final public static function page_type_lang_callback($str)
    {
        $mod = cms_utils::get_module(__CLASS__);
        if( is_object($mod) ) return $mod->Lang('type_'.$str);
    }

    public static function reset_page_type_defaults(CmsLayoutTemplateType $type)
    {
        if( $type->get_originator() != __CLASS__ ) throw new CmsLogicException('Cannot reset contents for this template type');

        $fn = null;
        switch( $type->get_name() ) {
        case 'feuille_rencontre':
            $fn = 'orig_feuille_match.tpl';
            break;
        case 'Top Flop':
            $fn = 'orig_topflop.tpl';
            break;
	case 'Résultats Par Equipes':
            $fn = 'orig_par_equipes.tpl';
            break;
	case 'Résultats pour une équipe':
            $fn = 'orig_equipe.tpl';
            break;
	case 'Classements Club':
            $fn = 'orig_classements.tpl';
            break;
	case 'Situation Mensuelle':
            $fn = 'orig_sitmens.tpl';
            break;
	case 'Situation En Live':
            $fn = 'orig_sit_prov.tpl';
            break;
	case 'Liste Joueurs':
            $fn = 'orig_liste_joueurs.tpl';
            break;
	case 'Résultats par joueur':
            $fn = 'orig_resultats_joueur.tpl';
            break;
	case 'Spid':
            $fn = 'orig_spid.tpl';
            break;
    case 'Countdown' :
    		$fn = 'displaycountdown.tpl';
    		break;

        }

        $fn = cms_join_path(dirname(__FILE__),'templates',$fn);
        if( file_exists($fn) ) return @file_get_contents($fn);
    }

  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }
     
  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
  }

  function InstallPostMessage() { return $this->Lang('postinstall'); }
  function UninstallPostMessage() { return $this->Lang('postuninstall'); }
  function UninstallPreMessage() { return $this->Lang('really_uninstall'); }
  
  
  function _SetStatus($oid, $status) {
    //...
  }



function random($car) {
$string = "";
$chaine = "abcdefghijklmnpqrstuvwxy";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string;
}

function VerifierEmail($monemail){
  if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $monemail))
    { return true;}
}

function dateversfr ($date){	   
	$datearr = explode('/', $date);
	$datefr = $datearr[2] . '-' . $datearr[1] . '-' . $datearr[0];
	return $datefr;
	}

function conv_date_vers_mysql($str_date) {
	$chgt = explode("/",$str_date);
	$day = substr($chgt,0,2);
	$month = substr($chgt,2,2);
	$year = substr($chgt,4,2);
	$date = "$year"."-"."$month"."-"."$day";


	 // $retour=date("y-m-d", mktime(0, 0, 0, $month, $day, $year));
	 return $date;
}
function mois_francais($mois){
	$months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "juillet", "Aout", "Septembre", "Octobre", "Novembre", "décembre");
	$month_to_display = $mois-1;
	$month_francais = $months["$month_to_display"];
	return $month_francais;
}

} //end class
?>
