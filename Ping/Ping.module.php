<?php

#-------------------------------------------------------------------------
# Module: Ping - 
# Version: 0.1, Sc
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------


#-------------------------------------------------------------------------
/**
 * Skeleton example class
 *
 * @author Claude SIOHAN
 * @since 1.0
 * @version $Revision: 3827 $
 * @modifiedby $LastChangedBy: wishy $
 * @lastmodified $Date: 2007-03-12 11:56:16 +0200 (Mon, 12 Mar 2007) $
 * @license GPL
 **/
class Ping extends CMSModule
{
  
  function GetName() { return 'Ping'; }   
  function GetFriendlyName() { return $this->Lang('friendlyname'); }   
  function GetVersion() { return '0.1beta2'; }  
  function GetHelp() { return $this->Lang('help'); }   
  function GetAuthor() { return 'agi-webconseil'; } 
  function GetAuthorEmail() { return 'claude@agi-webconseil.fr'; }
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
    //return array('NMS'=>'2.9', 'FrontEndUsers'=>'1.24');
  }

  

  function MaximumCMSVersion()
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
	$this->SEtParameterType('record_joueur', CLEAN_STRING);
	$this->SetParameterType('cancel',CLEAN_STRING);
	$this->SetParameterType('id_user',CLEAN_INT);
	$this->SetParameterType('nom_complet',CLEAN_STRING);
	$this->SetParameterType('adresse',CLEAN_STRING);
	$this->SetParameterType('codepostal',CLEAN_INT);
	$this->SetParameterType('commune',CLEAN_STRING);
	$this->SetParameterType('email',CLEAN_STRING);
	$this->SetParameterType('confirm_email',CLEAN_STRING);
	$this->SetParameterType('passe', CLEAN_STRING);
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
	
	//
	$this->SetParameterType('datecreated', CLEAN_STRING);
	$this->SetParameterType('datemaj', CLEAN_STRING);
	$this->SetParameterType('mois', CLEAN_INT);
	$this->SetParameterType('monthslist',CLEAN_INT);
	$this->SetParameterType('annee', CLEAN_INT);
	$this->SetParameterType('phase', CLEAN_INT);
	$this->SetParameterType('annee', CLEAN_INT);
	$this->SetParameterType('nom', CLEAN_STRING);
	$this->SetParameterType('prenom', CLEAN_STRING);
	$this->SetParameterType('actif', CLEAN_INT);
	$this->SetParameterType('point', CLEAN_INT);
	$this->SetParameterType('clnat', CLEAN_INT);
	$this->SetParameterType('rangreg', CLEAN_INT);
	$this->SetParameterType('rangdep', CLEAN_INT);
	$this->SetParameterType('progmois', CLEAN_INT);
	$this->SetParameterType('saison', CLEAN_STRING);
	
	$this->SetParameterType('type', CLEAN_STRING);
	$this->SetParameterType('idpoule', CLEAN_INT);
	$this->SetParameterType('iddiv', CLEAN_INT);
/*	*/
	
	//$this->CreateParameter('display','');


}

function InitializeAdmin()
{
  $this->SetParameters();
	//$this->CreateParameter('pagelimit', 100000, $this->Lang('help_pagelimit'));
}

   /*

	
   $this->RestrictUnknownParams();
  
   // syntax for creating a parameter is parameter name, default value, description
   $this->CreateParameter('envoisms_id', -1, $this->Lang('help_envoisms_id'));
   // skeleton_id must be an integer
   $this->SetParameterType('envoisms_id',CLEAN_INT);

   // module_message must be a string
   $this->CreateParameter('module_message','',$this->Lang('help_module_message'));
   $this->SetParameterType('module_message',CLEAN_STRING);

   // description must be a string
   $this->CreateParameter('description','',$this->Lang('help_description'));
   $this->SetParameterType('description',CLEAN_STRING);

   // explanation must be a string
   $this->CreateParameter('explanation','',$this->Lang('help_explanation'));
   $this->SetParameterType('explanation',CLEAN_STRING);

   
    * 4. Event Handling
    *
   
    Typical example: specify the originator, the event name, and whether or not
    the event is removable (used for one-time events)

    $this->AddEventHandler( 'Core', 'ContentPostRender', true );
  
  }

 */   
  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }
     
  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
  }
/*
    function DoEvent( $originator, $eventname, &$params )
	{
	if ($originator == 'Core' && $eventname == 'ContentPostRender')
		{
		// stupid example -- lowercases entire output
		$params['content'] = strtolower($params['content']);
		}
	}
   */

  function InstallPostMessage() { return $this->Lang('postinstall'); }
  function UninstallPostMessage() { return $this->Lang('postuninstall'); }
  function UninstallPreMessage() { return $this->Lang('really_uninstall'); }
  
  
  function _SetStatus($oid, $status) {
    //...
  }

 

function dropdown ($competition){
	$db  = cmsms()->GetDb();
$query ="SELECT joueurs FROM ".cms_db_prefix()."module_ping_competitions WHERE code_compet = ?";
$dbretour = $db->Execute($query, array($competition));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$joueurs = $row['joueurs'];
	return $joueurs;
	}

}
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

/*
function coeff ($typeCompetition) {
	$db  = cmsms()->GetDb();
$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_competitions WHERE code_compet = ?";
$dbretour = $db->Execute($query, array($typeCompetition));
if ($dbretour && $dbretour->RecordCount() > 0)
  {
    while ($row= $dbretour->FetchRow())
      {
	$coeff = $row['coefficient'];
	return $coeff;
	}

  }
}
*/
function VerifierEmail($monemail){
  if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $monemail))
    { return true;}
}

function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}



/*
  function DoAction($action, $id, $params, $returnid=-1)
  {
    switch ($action) {
    case 'default':
      {
//	require_once(dirname(__FILE__).'/function.displayteams.php');
	echo $this->ProcessTemplate('teamscores.tpl');// this is the plug-in side, i.e., non-Admin
	//$this->DisplayModuleOutput($action, $id, $params);
	break;
      }
    case 'teams_tab':
	{
	require_once(dirname(__FILE__).'/function.displayteams.php');
	echo $this->ProcessTemplate('teamscores.tpl');
	}
	break;
    case 'list':
      {
	// only let people save module preferences if they have permission
	
	if ($this->CheckPermission('Use CalculTranche'))
	  {
	    	echo 'Cool!';// this is the plug-in side, i.e., non-Admin
		$this->DisplayModuleOutput($action, $id, $params);
		break;
	  }
	break;
      }
    }
  }
 
*/

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
