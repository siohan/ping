<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}

//debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db = cmsms()->GetDb();
$service = new retrieve_ops;
switch($params['retrieve'])
{
	case "users" :
	
		$retrieve = $service->retrieve_users();
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
		
		
		if(isset($params['record_id']) && $params['record_id'] >0)
		{
			$record_id = (int)$params['record_id'];			
		}
		$retrieve = $service->retrieve_all_classements($record_id);
		
		$this->Redirect($id,'admin_poules_tab3',$returnid, array("record_id"=>$record_id));
		
	break;
	case "spid" :
		$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
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
					$calcul_pts_spid = $spid_ops->compte_spid_points($licence);
					$spid_ops->maj_points_spid($licence,$calcul_pts_spid);
					
				}

			}
  		}
	break;
	
	case "spid_refresh" :
		$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
		$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player, cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
		$dbretour = $db->Execute($query, array($licence));
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
			while ($row= $dbretour->FetchRow())
			{
				$player = $row['player'];
				$cat = $row['cat'];
				$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
				$maj_spid = $ping_ops->compte_spid($licence);
				$calcul_pts_spid = $spid_ops->compte_spid_points($licence);
				$spid_ops->maj_points_spid($licence,$calcul_pts_spid);
				//var_dump($resultats);
			}
  		}
	break;
	
	case "fftt" :
		$service = new retrieve_ops();
		$ping_ops = new spid_ops();
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
					$resultats = $service->retrieve_parties_fftt($licence,$player,$cat);
					//var_dump($resultats);
					$maj_spid = $ping_ops->compte_fftt($licence);
					//var_dump($resultats);
				}

			}
  		}
	break;
	//récupère les parties FFTT d'un seul joueur
	case "fftt_seul" :
		$service = new retrieve_ops;
		$spid_ops = new spid_ops;
		$ping_ops = new ping_admin_ops;
		if(isset($params['licence']) && $params['licence'] !='')
		{
			$licence = $params['licence'];
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
					$resultats = $service->retrieve_parties_fftt($licence);
				
					$player = $ping_ops->name($licence);
					$status = 'OK';
					$designation = $resultats.' parties fftt pour '.$player;
					$action = 'FFTT Seul';
					$ping_ops->ecrirejournal($status,$designation, $action);
					$maj_fftt = $spid_ops->compte_fftt($licence);
						//var_dump($resultats);
			           }


	  		}
			$this->RedirectToAdminTab("fftt");
		}
    		
	break;
	
	//récupère les parties SPID d'un seul joueur
	case "spid_seul" :
		$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
		$spid_ops = new spid_ops;
		if(isset($params['licence']) && $params['licence'] !='')
		{
			$licence = $params['licence'];
			$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player, cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
			$dbretour = $db->Execute($query, array($licence));
			if ($dbretour && $dbretour->RecordCount() > 0)
			{
				   while ($row= $dbretour->FetchRow())
				   {
					$player = $row['player'];
					$cat = $row['cat'];
					//return $player;
					$service = new retrieve_ops;
					$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
					var_dump($resultats);
					$status = 'OK';
					$designation = $resultats.' parties spid pour '.$player;
					$action = 'Spid Seul';
					$ping_ops->ecrirejournal($status,$designation, $action);
					$maj_spid = $spid_ops->compte_spid($licence);
					$calcul_pts_spid = $spid_ops->compte_spid_points($licence);
					$spid_ops->maj_points_spid($licence,$calcul_pts_spid);
						//var_dump($resultats);
			           }


	  		}
			$this->RedirectToAdminTab("spid");
		}
    		
	break;
	
	//tous les parties spid de tous les joueurs
	case "spid_all" :
		$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
		$spid_ops = new spid_ops;
		
		$query = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS player, j.cat, j.licence FROM ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.actif = '1' AND j.type = 'T'";
		$dbretour = $db->Execute($query);
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
			   while ($row= $dbretour->FetchRow())
			   {
				$player = $row['player'];
				$cat = $row['cat'];
				$licence = $row['licence'];
				//return $player;
				$service = new retrieve_ops;
				$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
				$maj_fftt = $spid_ops->compte_spid($licence);
				$maj_spid = $spid_ops->compte_spid_errors($licence);
					//var_dump($resultats);
		           }


  		}
		$this->Redirect($id, 'defaultadmin', $returnid, array("active_tab"=>"spid"));
		
    		
	break;
	//FFTT
	case "fftt_all" :
		$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
		$spid_ops = new spid_ops;
		
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE maj_fftt < NOW() + 3600";
		$dbretour = $db->Execute($query);
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
			   while ($row= $dbretour->FetchRow())
			   {
				
				$licence = $row['licence'];
				//return $player;
				$service = new retrieve_ops;
				$resultats = $service->retrieve_parties_fftt($licence);
				$maj_fftt = $spid_ops->compte_fftt($licence);
					//var_dump($resultats);
		           }


  		}
		//avant de rediriger on fait un check-up entre le spid et la fftt
		//objectif récupérer les coefficients des épreuves
		$verif = $spid_ops->verif_spid_fftt();
		$this->Redirect($id, 'defaultadmin', $returnid, array("__activetab"=>"ff"));
		
    		
	break;
	
	//toutes les situations mensuelles du mois
	case "sit_mens_all" :
		$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1' AND type = 'T'";
		$dbretour = $db->Execute($query);
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
			   while ($row= $dbretour->FetchRow())
			   {
					$licence = $row['licence'];
					$service = new retrieve_ops;
					$resultats = $service->retrieve_sit_mens($licence, $ext='false');
		       }
  		}
		$this->RedirectToAdminTab("situation");
		
    		
	break;
	
	case "club":
		$service = new retrieve_ops;
		$club_number = '03290229';
		$club = $service->retrieve_detail_club($club_number);
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
	
	//supprime les parties devenues obsolete et les adversaires aussi
	case "supp_spid" :
		$spid_ops = new spid_ops;
		$delete_spid = $spid_ops->delete_spid();
		if(true === $delete_spid)
		{
			$this->SetMessage('parties spid obsoletes supprimées');
			$delete_adversaires = $spid_ops->delete_adversaires();
		}
		$this->RedirectToAdminTab('spid');
	break;
	
	
	//active un joueur
	case "activate" :
		if(isset($params['licence']) && $params['licence'] != '')
		{
			$licence = $params['licence'];
			$joueurs = new Joueurs;
			$activate = $joueurs->activate($licence);
			if(true === $activate)
			{
				$this->SetMessage('Joueur activé');
			}
			else
			{
				$this->SetMessage('Pb !');
			}
		}
		$this->RedirectToAdminTab('joueurs');
		
	break;

	case "desactivate" :
		if(isset($params['licence']) && $params['licence'] != '')
		{
			$licence = $params['licence'];
			$joueurs = new joueurs;
			$activate = $joueurs->desactivate($licence);
			if(true === $activate)
			{
				$this->SetMessage('Joueur désactivé');
			}
			else
			{
				$this->SetMessage('Pb !');
			}
		}
		$this->RedirectToAdminTab('joueurs');
	break;
	
	
	//remet à zéro la table re récupération  des résultats spid etc...
	case "recup_parties" :
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_recup_parties";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1' AND type = 'T'";
			$dbresult2 = $db->Execute($query2);
			{
				if($dbresult2 && $dbresult2->RecordCount() >0)
				{
					$spid_ops = new spid_ops;
					while($row2 = $dbresult2->fetchRow())
					{
						$licence = $row2['licence'];
						$spid_ops->compte_fftt($licence);
						$spid_ops->compte_spid($licence);						
					}
				}
			}
		}
		
	break;
	
	case "details_rencontre" :
	
		if(isset($params['record_id']) && $params['record_id'] >0)
		{
			$renc_id = $params['record_id'];
		}
		if(isset($params['lien']) && $params['lien'] != '')
		{
			$link = $params['lien'];
		}
		$details = $service->details_rencontre($renc_id, $link);
		
	
	break;
	//récupère une poule entière
	case "retrieve_rencontre" : 
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$this->SetCurrentTab('equipes');
			$record_id = (int) $params['record_id'];
			$eq = new equipes_ping;
			$details = $eq->details_equipe($record_id);	
			var_dump($details);
			$idepreuve = $details['idepreuve'];
			$iddiv = $details['iddiv'];
			$idpoule = $details['idpoule'];
			$libequipe = $details['libequipe'];
			$cal =0;
			//on envoie vres le fichier
			$service = new retrieve_ops;
			$retrieve = $service->retrieve_poule_rencontres($record_id,$iddiv, $idpoule, $idepreuve);				
		}
		$this->Redirect($id, 'admin_poules_tab3', $returnid, array('record_id'=>$record_id));
	break;
	
	case "details_club" :
	{
		//On récupère les coordonnées de la salle et du correspondant
		$r_ops = new retrieve_ops;
		$details_club = $r_ops->retrieve_detail_club($this->GetPreference('club_number'));
	}
	
	break;
}
?>
