<?php
   if (!isset($gCms)) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$nom_equipes = $this->GetPreference('nom_equipes');
$saison = $this->GetPreference('saison_en_cours');
$mois_courant = date('m');
//echo "le mois courant est :".$mois_courant;
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$phase = $this->GetPreference('phase_en_cours');
$annee_courante = date('Y');

	if($phase==1)
	{
		$mois_depart=9;
		$mois_fin = 12;
		
	}
	else{
		
	}


$rowarray = array();
$rowjoueur = array();
$joueur = array();
$query1 = "SELECT CONCAT_WS(' ',nom, prenom) AS joueur, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";
$dbresultat = $db->Execute($query1);

	if($dbresultat && $dbresultat->RecordCount()>0)
	{
		while($row = $dbresultat->FetchRow())
		{
			//$max =  $row['total'];
			$joueur = $row['joueur'];
			//echo $joueur;
			$licence = $row['licence'];
			$rowarray[$licence] = $joueur;	
			$smarty->assign('rowjoueur',$joueur);
			$smarty->assign('licence',$licence);
			$smarty->assign('rowarray',$rowarray);
			//echo "le nb de lignes est  : ".$max;
			//print_r($rowarray);
			$smarty->assign('formstart',
	    			$this->CreateFormStart( $id, 'do_add_all_sit_mens', $returnid ) );
				$tableau = array("12"=>"Décembre");
				$smarty->assign('choix_mois',
					$this->CreateInputDropdown($id, 'choix_mois',$tableau, $mois_courant,-1));
			//$smarty->assign('lignes', $max);	
						
							
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
		}	
}		
			
			
	
echo $this->ProcessTemplate('add_all_sit_mens.tpl');		

#
?>