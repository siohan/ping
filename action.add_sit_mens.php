<?php
#############################################################
###            Ajout manuel d'une situation mensuelle     ###
###                                                       ###
###            Auteur : Claude SIOHAN                     ###
#############################################################
#
#
#
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$nom_equipes = $this->GetPreference('nom_equipes');
$saison = $this->GetPreference('saison_en_cours');
$mois_courant = date('n');
//$mois_courant = 11;
//$mois_courant = 7;//c'est le mois de référence avec lequel il faut travailler en prod
//echo "le mois courant est :".$mois_courant;
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
//$phase = 1;//pour test
$smarty->assign('phase',$phase);
$annee_courante = date('Y');

	if($phase==1)
	{
		$mois_depart=9;
		$mois_fin = 12;		
	}
	else{
		$mois_depart = 7; //postulat		
	}

$licence = '';

	if(isset($params['licence']) && $params['licence'] !='')
	{
		$licence = $params['licence'];
	}
	else
	{
		$this->SetMessage($this->lang['error_insufficientparams']);
		$this->RedirectToAdminTab('situation');
	}

$rowarray = array();
$smarty->assign('formstart',
		$this->CreateFormStart( $id, 'do_add_sit_mens', $returnid ) );
$smarty->assign('licence',
		$this->CreateInputText($id,'licence',$licence,10,15));
$i=0;
$query = "SELECT j.nom, j.prenom, j.licence, st.mois, st.points FROM ".cms_db_prefix()."module_ping_sit_mens AS st, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE st.licence = j.licence AND j.licence = ?";//" AND saison = ?";
//echo $query;
$dbresult = $db->Execute($query, array($licence));

	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			//var_dump($row);			
			$mois = $row['mois'];
			$cla = $row['points'];
			$nom = $row['nom'];
			$prenom = $row['prenom'];
			$rowarray[$mois] = $cla;
			//print_r($rowarray);		
			$smarty->assign('nom',
					$this->CreateInputText($id, 'nom', $nom, 30, 80));
			$smarty->assign('prenom',
					$this->CreateInputText($id, 'prenom', $prenom, 30, 80));
			$smarty->assign('mois_courant', $mois_courant);				
			$smarty->assign('rowarray',$rowarray);
							
		}			
			
	}	
	else
	{		
		$smarty->assign('nom',
				$this->CreateInputText($id, 'nom', $nom, 30, 80));
		$smarty->assign('prenom',
				$this->CreateInputText($id, 'prenom', $prenom, 30, 80));
		$smarty->assign('mois_courant', $mois_courant);				
		$smarty->assign('rowarray',$rowarray);			
	}	
	
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));
	$smarty->assign('back',
			$this->CreateInputSubmit($id,'back',
						$this->Lang('back')));
	$smarty->assign('formend',
			$this->CreateFormEnd());
	
	
echo $this->ProcessTemplate('add_sit_mens.tpl');		

#
?>