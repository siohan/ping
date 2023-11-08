<?php
//cette page récupère l'ensemble des résultats dispo pour une compétition individuelle
 
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}

//debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db = cmsms()->GetDb();
$ret = new retrieve_ops;

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
	
		
		if(isset($params['type']) && $params['type'] != '')
		{
			$type = $params['type'];
		}
		else
		{
			$type = '';
		}
		$retrieve = $ret->retrieve_divisions($idorga,$idepreuve,$type="");
		//var_dump($retrieve);
		$message='Retrouvez toutes les infos dans le journal';
		//$this->SetMessage($message);
		
		if(false == empty($retrieve))
		{
			$this->SetMessage('Aucune division récupérée pour le moment !');
			$this->Redirect($id, 'defaultadmin', $returnid, array('__activetab'=>'compets', 'indivs_suivies'=>'1'));
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
		$query.=" AND dv.idorga = ?";
		$dbresult = $db->Execute($query, array($idepreuve, $idorga));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				$i = 0;
				while ($row= $dbresult->FetchRow())
				{
					//pour l'accès auto aux tours ou poules
					$tours = $ret->retrieve_div_tours ($params['idepreuve'],$row['iddivision']);
					$i++;
					
				}
				$this->Redirect($id, 'retrieve_indivs', $returnid, array('obj'=>'classements', 'idepreuve'=>$idepreuve, 'idorga'=>$idorga));
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
		$query = "SELECT idepreuve, iddivision, tableau FROM ".cms_db_prefix()."module_ping_div_tours WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$add_class = $ret->retrieve_div_classement($idepreuve, $row['iddivision'], $row['tableau']);
				}
			}
			else
			{
				
			}
		}
		else
		{
			
		}
	}
	$this->Redirect($id, 'view_indivs_details', $returnid, array('record_id'=>$idepreuve));
	break;
	
}
?>
