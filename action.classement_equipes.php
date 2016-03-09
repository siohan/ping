<?php
if( !isset( $gCms) ) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
$saison = $this->GetPreference('saison_en_cours');
$phase =$this->GetPreference('phase_en_cours');
$record_id = '';
$parms = array();
$nom_equipes = $this->GetPreference('nom_equipes');
$equipes = "%$nom_equipes%";
$query = "SELECT cl.id AS row_id,cl.idequipe,eq.friendlyname,eq.libequipe,cl.poule,cl.idpoule,cl.clt,cl.equipe,cl.joue,cl.pts FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.id = cl.idequipe AND equipe LIKE ?  AND cl.saison = ? AND phase = ?";
//$parms['saison'] = $saison;
//en parametres possibles : 
#le championnat recherché ou non
#une equipe précise ou non
	if(isset($params['idepreuve']) && $params['idepreuve'] !='')
	{
		$idepreuve = $params['idepreuve'];
		$query." AND cl.idepreuve = ?";
		$parms['idepreuve'] = $idepreuve;
	}
	/*
	if(isset($params['idepreuve']) && $params['idepreuve'] !='')
	{
		
	}
	if(isset($params['idepreuve']) && $params['idepreuve'] !='')
	{
		
	}
	*/
	if(isset($params['record_id']) && $params['record_id'] !='')
	{
			
		$query.=" AND cl.idequipe = ?";
		$params['record_id'] = $parms['idequipe'];
	
	}

//on aordonne la table
$query.= " ORDER BY eq.id ASC";


//on effectue la requete
$dbresult = $db->Execute($query,array($equipes,$saison,$phase));
//echo $query;
$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$row_id = $row['row_id'];
		$clt = $row['clt'];
		$idpoule = $row['idpoule'];
		if($clt == 0)
		{
			//il faut sélectionner un id au dessus
			$query2 = "SELECT clt FROM ".cms_db_prefix()."module_ping_classement WHERE id < ? AND idpoule = ? AND saison = ? AND clt !='0' ORDER BY id DESC LIMIT 1";
			$dbresult2 = $db->Execute($query2, array($row_id,$idpoule,$saison));
			$row2 = $dbresult2->FetchRow();
			$clt = $row2['clt'];
		}
		$equipe = $row['friendlyname'];
		if($equipe =='')
		{
			$onerow->friendlyname = $row['libequipe'];
		}
		else
		{
			$onerow->friendlyname = $row['friendlyname'];
		}
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		
		
		$onerow->clt = $clt;
		//$onerow->equipe = $row['equipe'];		
		$rowarray[]  = $onerow;
			
	}

}

$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
echo $this->ProcessTemplate('classement.tpl');
#
#EOF
#
?>