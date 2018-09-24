<?php
if( !isset( $gCms) ) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
$saison = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
$phase = (isset($params['phase'])?$params['phase']:$this->GetPreference('phase_en_cours'));
//$nom_equipes = $this->GetPreference('nom_equipes');
$record_id = '';
$parms = array();

$query = "SELECT cl.id AS row_id,cl.idequipe,eq.friendlyname,eq.libequipe,cl.poule,cl.idpoule,cl.clt,cl.equipe,cl.joue,cl.pts, eq.numero_equipe FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.id = cl.idequipe ";
//$query.=" AND cl.equipe LIKE ? ";
$query.= "AND cl.equipe = eq.libequipe  AND cl.saison = ? AND phase = ?";


$parms['saison'] = $saison;
$parms['phase'] = $phase;
//en parametres possibles : 
#le championnat recherché ou non
#une equipe précise ou non
	if(isset($params['idepreuve']) && $params['idepreuve'] !='')
	{
		$idepreuve = $params['idepreuve'];
		$query.=" AND eq.idepreuve = ?";
		$parms['idepreuve'] = $idepreuve;
		
	}


//on aordonne la table
$query.= " ORDER BY eq.numero_equipe ASC";


//on effectue la requete
$dbresult = $db->Execute($query,$parms);//array($equipes,$saison,$phase,$idepreuve));
//echo $query;
$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$row_id = $row['row_id'];
		$clt = $row['clt'];
		$idpoule = $row['idpoule'];
		$id_equipe = $row['idequipe'];
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		
		if($clt == '0')
		{
			//il faut sélectionner un id au dessus
			$query2 = "SELECT clt FROM ".cms_db_prefix()."module_ping_classement WHERE id < ? AND idpoule = ? AND saison = ? AND clt !='0' ORDER BY id DESC LIMIT 1";
			$dbresult2 = $db->Execute($query2, array($row_id,$idpoule,$saison));
			$row2 = $dbresult2->FetchRow();
			$clt = $row2['clt'];
		}
		
		$equipe = $row['friendlyname'];
		//$onerow->friendlyname = $row['libequipe'];
		
		if($equipe !='')
		{
			$onerow->friendlyname = $this->CreateLink($id, 'equipe',$returnid,$contents=$row['friendlyname'], array("record_id"=>$id_equipe));//$row['friendlyname'];
			//echo "est pas Null";
		}
		else
		{
			$onerow->friendlyname = $row['libequipe'];
		}
		
		//var_dump($equipe);
		
		
		
		$onerow->clt = $clt;
		//$onerow->equipe = $row['equipe'];		
		$rowarray[]  = $onerow;
			
	}

}
else
{
	 echo " pas de resultat";
	$designation = $db->ErrorMsg();
	echo $designation;
}

$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
echo $this->ProcessTemplate('classement.tpl');
#
#EOF
#
?>