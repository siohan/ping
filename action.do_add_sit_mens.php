<?php
if (!isset($gCms)) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
//debug_display($params, 'Parameters');
$phase = $this->GetPreference('phase_en_cours');
$saison = $this->GetPreference('saison_en_cours');
	if (!$this->CheckPermission('Ping Manage'))
	{
		$designation.=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('situation');
	}
	$annee = date('Y');
	$mois = date('n');
	
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
$i = 0;
		
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
		
		$prenom = '';
		if (isset($params['prenom']) && $params['prenom'] != '')
		{
			$prenom = $params['prenom'];
		}
		
		
		$month = '';
		if (isset($params['month']) && $params['month'] != '')
		{
			$month = $params['month'];
		}
		
		else
		{
			$error++;
		}
		
		if($error>0)
		{
			$this->SetMessage('paramètres manquants');
			$this->RedirectToAdminTab('situation');
		}
		foreach($month as $key=>$value)
		{
			
		if($phase ==1)
		{
			$annee_ref = $annee;
		}
		elseif($phase ==2)
		{
			if($key >=9 && $key <=12)
			{
				$annee_ref = $annee-1;
			}
			else
			{
				$annee_ref = $annee;
			}
		}
			$query = "SELECT mois, annee, licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
			$dbresult = $db->Execute($query, array($licence,$key,$annee_ref));
			
				if($dbresult && $dbresult->RecordCount()==0)
				{
					
					
					if( $value >0 )
					{
						
					$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id, datecreated, datemaj, saison, mois, annee, phase, licence, nom, prenom, points) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					//echo $query2;
					$dbresultat = $db->Execute($query2, array($now, $now,$saison, $key, $annee_ref, $phase, $licence,$nom, $prenom,$value));
					$i++;
					}
				}
				/*
				elseif($dbresult->RecordCount()==1)
				{
					//Il y a déjà un enregistrement, est-il complet ?
					
					if($value >0)
					{
						$query3 = "UPDATE ".cms_db_prefix()."module_ping_sit_mens SET points = ? WHERE licence = ? AND mois = ?";
						$dbres = $db->Execute($query3, array($value,$licence,$key));
					}
					
				}
				*/
		}

$designation = $i." situation(s) modifiée(s)";
$this->SetMessage("$designation");
$this->RedirectToAdminTab('situation');

?>