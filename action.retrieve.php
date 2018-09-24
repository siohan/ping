<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}

debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db =& $this->GetDb();
$service = new retrieve_ops();
switch($params['retrieve'])
{
	case "users" :
		//le paramètre FFTT est-il présent ?
		//on fait la requete
	
		$message='Retrouvez toutes les infos dans le journal';
	
		//$retrieve = $service->retrieve_users();
		$retrieve = $service->retrieve_users_fftt();
		$this->SetMessage($message);
		$this->RedirectToAdminTab('joueurs');
	break;
	
	case "teams" : 
	
		if(isset($params['type']) && $params['type']  !='')
		{
			$type = $params['type'];
			$retrieve = $service->retrieve_teams($type);
		}
	
		//message de sortie
		$message='Retrouvez toutes les infos dans le journal';
		$this->SetMessage($message);
		$this->RedirectToAdminTab('equipes');
	break;
	
	
	case "divisions" :
	
		if(isset($params['idorga']) && $params['idorga'] != '')
		{
			$idorga = $params['idorga'];
		}
		if(isset($params['idepreuve']) && $params['idepreuve'] != '')
		{
			$idepreuve = $params['idepreuve'];
		}
		if(isset($params['type']) && $params['type'] != '')
		{
			$type = $params['type'];
		}
		else
		{
			$type = '';
		}
		$retrieve = $service->retrieve_divisions($idorga,$idepreuve,$type="");
		$message='Retrouvez toutes les infos dans le journal';
		$this->SetMessage($message);
		$this->Redirect($id, 'admin_divisions_tab', $returnid, array("idepreuve"=>$idepreuve, "idorga"=>$idorga, "essai"=>"1"));
	
	break;
	
	case "compets" :
	
		if(isset($params['idorga']) && $params['idorga'] !='')
		{
			$idorga = $params['idorga'];
		}
		if(isset($params['type']) && $params['type'] != '')
		{
			$typeC = $params['type'];
		}
		else
		{
			$typeC = '';
		}
		
		
		$retrieve = $service->retrieve_compets($idorga,$type=$typeC);
		$message='Retrouvez toutes les infos dans le journal';
		$this->SetMessage($message);
		$this->RedirectToAdminTab('compets');
	
	break;
	
	case "classement_equipes" :
		
		$saison = $this->GetPreference('saison_en_cours');
		$phase = $this->GetPreference('phase_en_cours');
		$error = 0;
		$designation = '';
		$full = 0;//variable pour récupérer l'ensemble des résultats ou une seule, par défaut 0 cad toutes
		$record_id = '';
		$lignes = 0;

		//on fait une requete générale et on affine éventuellement
		$query = "SELECT iddiv, idpoule, id as id_equipe FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? ";//AND phase = ?";
		$parms['saison'] = $saison;
		//$parms['phase']  = $phase;

		if(isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$query.=" AND id = ?";
			$parms['id'] = $record_id;
			$full = 1;
		}

		$dbresult = $db->Execute($query, $parms);

		//bon tt va bien, tt est Ok
		//on fait la boucle
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while( $dbresult && $row = $dbresult->FetchRow())
			{
				$iddiv = $row['iddiv'];
				$idpoule = $row['idpoule'];
				$id_equipe = $row['id_equipe'];		
				$service = new retrieve_ops();
				if($full == '0')//toutes les équipes sont sélectionnées
				{
					$retrieve = $service->retrieve_all_classements($iddiv,$idpoule,$record_id=$id_equipe);
					sleep(1);
				}
				else
				{
					$retrieve = $service->retrieve_all_classements($iddiv,$idpoule,$record_id=$params['record_id']);
				}
				//$idequipe = $row['id']

			}
			$this->Redirect($id,'admin_poules_tab3',$returnid, array("record_id"=>$record_id));
		}
		else
		{
			echo "Pas de résultats ou requete incorrecte";
		}
		
	break;
	case "spid" :
		$service = new retrieve_ops();
		$ping_ops = new ping_admin_ops();
		foreach( $params['sel'] as $licence )
  		{
    			$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player, cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
			$dbretour = $db->Execute($query, array($licence));
			if ($dbretour && $dbretour->RecordCount() > 0)
			{
			    while ($row= $dbretour->FetchRow())
			      	{
					$player = $row['player'];
					$cat = $row['cat'];
					//return $player;
					$service = new retrieve_ops();
					$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
					$maj_spid = $ping_ops->compte_spid($licence);
					//var_dump($resultats);
				}

			}
  		}
	break;
	case "fftt" :
		$service = new retrieve_ops();
		$ping_ops = new ping_admin_ops();
		foreach( $params['sel'] as $licence )
  		{
    			$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player, cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
			$dbretour = $db->Execute($query, array($licence));
			if ($dbretour && $dbretour->RecordCount() > 0)
			{
			    while ($row= $dbretour->FetchRow())
			      	{
					$player = $row['player'];
					$cat = $row['cat'];
					//return $player;
					$service = new retrieve_ops();
					$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
					$maj_spid = $ping_ops->compte_spid($licence);
					//var_dump($resultats);
				}

			}
  		}
	break;
	case "organismes" :
		
		$service = new retrieve_ops();
		$retrieve = $service->organismes();
		$message='Retrouvez toutes les infos dans le journal';
		$this->SetMessage($message);
		$this->RedirectToAdminTab('configuration');

	break;
	
	case "sit_mens" :
		
		$service = new retrieve_ops();
		$sit_mens = $service->retrieve_sit_mens($params['sel']);
		//$this->SetMessage();
		$this->RedirectToAdminTab('situation');
		
		
	break;
	
	case "maintien" :
		$ping_ops = new ping_admin_ops;
		if(isset($params['licence']) && $params['licence'] != '')
		{
			$licence = $params['licence'];
		}
		if(isset($params['idepreuve']) && $params['idepreuve'] != '')
		{
			$idepreuve = $params['idepreuve'];
		}
		if(isset($params['iddivision']) && $params['iddivision'] != '')
		{
			$iddivision = $params['iddivision'];
		}
		if(isset($params['idorga']) && $params['idorga'] != '')
		{
			$idorga = $params['idorga'];
		}
		if(isset($params['tour']) && $params['tour'] != '')
		{
			$tour = $params['tour'];
		}
		
		$maintien = $ping_ops->maintien($licence, $idepreuve, $iddivision, $tour, $idorga);
	break;

	
}

?>