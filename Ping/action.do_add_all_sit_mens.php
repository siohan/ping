<?php
if (!isset($gCms)) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
debug_display($params, 'Parameters');
$phase = $this->GetPreference('phase_en_cours');

	if (!$this->CheckPermission('Ping Manage'))
	{
		$designation.=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('situation');
	}
	$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$licence = '';
		if (isset($params['licence']) && $params['licence'] != '')
		{
			$licence = $params['licence'];
		}
		else
		{
			$error++;
		}
		$nom = '';
		if (isset($params['nom']) && $params['nom'] != '')
		{
			$nom = $params['nom'];
		}
		else
		{
			$error++;
		}
		$prenom = '';
		if (isset($params['prenom']) && $params['prenom'] != '')
		{
			$prenom = $params['prenom'];
		}
		else
		{
			$error++;
		}
		
		$month = '';
		if (isset($params['month']) && $params['month'] != '')
		{
			$month = $params['month'];
			$error++;
		}
		foreach($month as $key=>$value)
		{
			
			$query = "SELECT mois, annee, licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
			$dbresult = $db->Execute($query, array($licence,$key,$annee));
			
				if($dbresult && $dbresult->RecordCount()==0)
				{
					$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id, datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$dbresultat = $db->Execute($query2, array($now, $now, $key, $annee, $phase, $licence,$nom, $prenom,$value));
				}
				
				elseif($dbresult->RecordCount()==1)
				{
					$query3 = "UPDATE ".cms_db_prefix()."module_ping_sit_mens SET points = ? WHERE licence = ? AND mois = ?";
					$dbres = $db->Execute($query3, array($value,$licence,$key));
					
				}
				
		}


$this->SetMessage('Situation modifiée !');
$this->RedirectToAdminTab('situation');

?>