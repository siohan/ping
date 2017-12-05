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
		$date_debut = '';
		if (isset($params['date_debut']) && $params['date_debut'] != '')
		{
			$date_debut = $params['date_debut'];
		}
		
		$date_fin = '';
		if (isset($params['date_fin']) && $params['date_fin'] != '')
		{
			$date_fin = $params['date_fin'];
		}
		
		$iddivision = '';
		if (isset($params['iddivision']) && $params['iddivision'] != '')
		{
			$iddivision = $params['iddivision'];
		}
		else
		{
			$error++;
		}
		$idorga = '';
		if (isset($params['idorga']) && $params['idorga'] != '')
		{
			$idorga = $params['idorga'];
		}
		else
		{
			$error++;
		}
		$tour = '';
		if (isset($params['tour']) && $params['tour'] != '')
		{
			$tour = $params['tour'];
		}
		else
		{
			$error++;
		}
		$tableau = '';
		if (isset($params['tableau']) && $params['tableau'] != '')
		{
			$tableau = $params['tableau'];
		}
		else
		{
			$error++;
		}
		if($error ==0)
		{
			//on vire toutes les données de cette compet avant 
			$query = "DELETE FROM ".cms_db_prefix()."module_ping_participe_tours WHERE idepreuve = ? AND iddivision = ? AND idorga = ? AND tour = ? AND tableau = ? AND saison = ?";
			$dbquery = $db->Execute($query, array($idepreuve, $iddivision, $idorga, $tour, $tableau,$saison));
			
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
					$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_participe_tours (licence, idepreuve,iddivision, idorga,tour, tableau, saison) VALUES (?, ?, ?, ?, ?, ?, ?)";
					echo $query2;
					$dbresultat = $db->Execute($query2, array($key, $idepreuve, $iddivision, $idorga, $tour, $tableau, $saison));
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
		


$this->Redirect($id,'participants', $returnid,array("idepreuve"=>$idepreuve));

?>