<?php
//cette page récupère l'ensemble des résultats dispo pour une compétition individuelle
 
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('compets');
}

//debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db = cmsms()->GetDb();
$ret = new retrieve_ops;
$epr = new EpreuvesIndivs;

if(isset($params['idorga']) && $params['idorga'] != '')
{
	$idorga = $params['idorga'];
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
}
	
switch($params['obj'])
{
	
	
	case "divisions" :
	
		$orga = array('fede'=>$this->GetPreference('fede'), 'zone'=>$this->GetPreference('zone'),'ligue'=>$this->GetPreference('ligue'), 'dep'=>$this->GetPreference('dep'));
		if(isset($params['type']) && $params['type'] != '')
		{
			$type = $params['type'];
		}
		else
		{
			$type = '';
		}
		foreach($orga as $value)
		{
			$retrieve = $ret->retrieve_divisions($value,$idepreuve,$type="");
		}
		//var_dump($retrieve);
		$message='Retrouvez toutes les infos dans le journal';
		//$this->SetMessage($message);
		
		if(false == empty($retrieve))
		{
			$this->SetMessage('Aucune division récupérée pour le moment !');
			$next = $epr->next($idepreuve);
			$this->Redirect($id, 'retrieve_indivs', $returnid, array("obj"=>"divisions","idepreuve"=>$next, "idorga"=>$idorga));
			//$this->Redirect($id, 'defaultadmin', $returnid, array('__activetab'=>'compets', 'indivs_suivies'=>'1'));
		}
		else
		{
		
			$this->Redirect($id, 'retrieve_indivs', $returnid, array("obj"=>"tours","idepreuve"=>$idepreuve, "idorga"=>$idorga));
		}
		
	case "tours" :
	{
		$query = "SELECT dv.id,tc.name,tc.indivs, tc.idorga, tc.idepreuve, dv.libelle, dv.iddivision,dv.scope, dv.uploaded FROM ".cms_db_prefix()."module_ping_type_competitions AS tc , ".cms_db_prefix()."module_ping_divisions AS dv ";
		$query.=" WHERE  tc.idepreuve = dv.idepreuve AND tc.indivs = '1' ";
		$query.=" AND tc.idepreuve = ?";
		//$query.=" AND dv.idorga = ?";
		$dbresult = $db->Execute($query, array($idepreuve));//, $idorga));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				$i = 0;
				while ($row= $dbresult->FetchRow())
				{
					//pour l'accès auto aux tours ou poules
					//on supprime d'abord (essai)
					//$del = $epr->delete_tours($idepreuve);
					$tours = $ret->retrieve_div_tours($params['idepreuve'],$row['iddivision']);
					$i++;
					
				}
				
				$this->Redirect($id, 'retrieve_indivs', $returnid, array('obj'=>'classements', 'idepreuve'=>$idepreuve));//, 'idorga'=>$idorga));
			}
			else
			{
				$this->SetMessage('Pas de tours récupérés !');
				
			}
		}
		else
		{
			//on redirige avec un message
			$this->SetMessage('Erreur dans la requête : Pas de divisions récupérées !');
			$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$idepreuve));
		}
		
	}
	break;
	
	case "tours_refresh" :
	{
		$del = $epr->delete_tours($idepreuve);
		$query = "SELECT dv.id,tc.name,tc.indivs, tc.idorga, tc.idepreuve, dv.libelle, dv.iddivision,dv.scope, dv.uploaded FROM ".cms_db_prefix()."module_ping_type_competitions AS tc , ".cms_db_prefix()."module_ping_divisions AS dv ";
		$query.=" WHERE  tc.idepreuve = dv.idepreuve AND tc.indivs = '1' ";
		$query.=" AND tc.idepreuve = ?";
		//$query.=" AND dv.idorga = ?";
		$dbresult = $db->Execute($query, array($idepreuve));//, $idorga));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				$i = 0;
				while ($row= $dbresult->FetchRow())
				{
					//pour l'accès auto aux tours ou poules
					//on supprime d'abord (essai)
					
					$tours = $ret->retrieve_div_tours($params['idepreuve'],$row['iddivision']);
					$i++;
					
				}
				$this->Redirect($id, 'retrieve_indivs', $returnid, array('obj'=>'classements', 'idepreuve'=>$idepreuve));//, 'idorga'=>$idorga));
			}
			else
			{
				$this->SetMessage('Pas de divisions récupérées !');
			}
		}
		else
		{
			//on redirige avec un message
			$this->SetMessage('Erreur dans la requête : Pas de divisions récupérées !');
			$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$idepreuve));
		}
		
	}
	break;
	
	case "classements" :
	{
		//
		$now = time();
		$query = "SELECT idepreuve, iddivision, tableau, tour FROM ".cms_db_prefix()."module_ping_div_tours WHERE idepreuve = ? AND date_prevue < ?";
		$dbresult = $db->Execute($query, array($idepreuve, $now));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$add_class = $ret->retrieve_div_classement($idepreuve, $row['iddivision'], $row['tableau'], $row['tour']);
				}
			}
			else
			{
				//pas de tours correspondant à la date_prevue
				$this->SetMessage('Pas de tours ou tours à venir');
				$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$idepreuve));
			}
		}
		else
		{
			
		}
	}
	//$this->Redirect($id, 'retrieve_indivs', $returnid, array('obj'=>'has_clt', 'idepreuve'=>$idepreuve));//, 'idorga'=>$idorga));
	$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$idepreuve));
	break;
	
	//on vérifie qu'une épreuve a des joueurs du club dans les classements
	case "has_clt" :
	{
		$club = $epr->nom_club();
		$nclub = '%.$club.%';
		$nb_players = $epr->nb_players_incla($idepreuve, $club);
		var_dump($nb_players);
		if(false !=$nb_players && $nb_players >0) //il y a des joueurs du club dans le classement
		{
			//on peut passer à l'autre épreuve si on veut garder les résultats
		}
		else
		{
			//on redirige pour désactiver
			$epr->desactive_epreuve($idepreuve);
			$epr->raz_divisions($idepreuve);
			$epr->raz_tours($idepreuve);
			$epr->raz_classements($idepreuve);
			$this->SetMessage('Epreuve désactivée !');
			$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$idepreuve));
		}
			
	}
	break;
	
	//on désactive une épreuve
	case "deactive" :
	{
		$epr->desactive_epreuve($idepreuve);
	}
	//redir
	break;
	
}
?>
