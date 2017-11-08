<?php
if (!isset($gCms)) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
//debug_display($params, 'Parameters');
/*

	if (!$this->CheckPermission('Ping Manage'))
	{
		$designation.=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('situation');
	}
*/
$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
$saison = $this->GetPreference('saison_en_cours');
		
		$idepreuve = '';
		if (isset($params['idepreuve']) && $params['idepreuve'] != '')
		{
			$idepreuve = $params['idepreuve'];
		}
		else
		{
			$error++;
		}
		
		if($error ==0)
		{
			//on vire toutes les données de cette compet avant 
			$query = "DELETE FROM ".cms_db_prefix()."module_ping_participe WHERE idepreuve = ? AND saison = ?";
			$dbquery = $db->Execute($query, array($idepreuve, $saison));
			
			//la requete a fonctionné ?
			
			if($dbquery)
			{
				$licence = '';
				if (isset($params['licence']) && $params['licence'] != '')
				{
					$licence = $params['licence'];
					$error++;
				}
				foreach($licence as $key=>$value)
				{
					$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_participe (licence, idepreuve, saison) VALUES (?, ?, ?)";
					echo $query2;
					$dbresultat = $db->Execute($query2, array($key, $idepreuve, $saison));
				}
			$this->SetMessage('participants ajoutés !');
			}
			else
			{
				echo "la requete de suppression est down !";
			}
				
				
		}
		else
		{
			echo "Il y a des erreurs !";
		}
		


$this->RedirectToAdminTab('compets');

?>