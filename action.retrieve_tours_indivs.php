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


if(isset($params['idepreuve']) && $params['idepreuve'] >0)
{
	$idepreuve = (int) $params['idepreuve'];
}
	

		$query = "SELECT dv.id,tc.name,tc.indivs, tc.idorga, tc.idepreuve, dv.libelle, dv.iddivision,dv.scope, dv.uploaded FROM ".cms_db_prefix()."module_ping_type_competitions AS tc , ".cms_db_prefix()."module_ping_divisions AS dv ";
		$query.=" WHERE  tc.idepreuve = dv.idepreuve AND tc.indivs = '1' ";
		$query.=" AND tc.idepreuve = ?";
		
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				while ($row= $dbresult->FetchRow())
				{
					$tours = $ret->retrieve_div_tours($params['idepreuve'],$row['iddivision']);
				}
				//on vérifie que l'épreuve indivs compte bien au moins 1 tour et un tour échu
				$nb_tours = $epr->has_tours($idepreuve);
				//on peut faire les conditionnelles
				if($nb_tours >0)//on a bien au moins un tour, on peut continuer
				{
					$status = 1;
					$designation = $idepreuve.' : '.$nb_tours. 'récupérés';
					$action = "retrieve_indivs";
					$log->ecrirejournal($status, $sdeignation, $action);
					$this->Redirect($id, 'retrieve_indivs', $returnid, array('obj'=>'classements', 'idepreuve'=>$idepreuve));
				}
				else
				{
					//pas de tours récupérés, on désactive l'épreuve ?
					//on , on passe à l'épreuve suivante
					$status = 0;
					$designation = $idepreuve.' : pas de tours récupérés';
					$action = "retrieve_indivs";
					$log->ecrirejournal($status, $sdeignation, $action);
					$this->Redirect($id, 'retrieve_div_indivs', $returnid, array('idepreuve'=>$idepreuve,'next'=>'1'));
				}
				
			}
			else
			{
				$status = 0;
				$designation = $idepreuve.' : pas de tours récupérés';
				$action = "retrieve_indivs";
				$log->ecrirejournal($status, $sdeignation, $action);
				$this->Redirect($id, 'retrieve_div_indivs', $returnid, array('idepreuve'=>$idepreuve,'next'=>'1'));
				
			}
		}
		else
		{
			$status = 0;
			$designation = $idepreuve.' : pas de tours récupérés';
			$action = "retrieve_indivs";
			$log->ecrirejournal($status, $sdeignation, $action);
			$this->Redirect($id, 'retrieve_div_indivs', $returnid, array('idepreuve'=>$idepreuve,'next'=>'1'));
		}
		
?>
