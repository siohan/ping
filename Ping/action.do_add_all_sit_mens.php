<?php
if (!isset($gCms)) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
//debug_display($params, 'Parameters');
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
//var_dump($licence);
		$choix_mois = '';
		if (isset($params['choix_mois']) && $params['choix_mois'] != '')
		{
			$choix_mois = $params['choix_mois'];
			//$error++;
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
		
		foreach($licence as $key=>$value)
		{
			//echo $key."=>".$value."<br/>";
			if( $value !=0 || $value !='')
			
			{
				
				$query = "SELECT mois, annee, licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
				//echo $query;
				$dbresult = $db->Execute($query, array($key,$choix_mois,$annee));
			
					if($dbresult && $dbresult->RecordCount()==0)
					{
						
						$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id, datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						//echo $query2;
						$dbresultat = $db->Execute($query2, array($now, $now, $choix_mois, $annee, $phase, $key,$nom, $prenom,$value));
						$i++;
						
					}
			}
				
		}

$designation.=$i." situation(s) modifiée(s)";
$this->SetMessage("$designation");
$this->RedirectToAdminTab('situation');

?>