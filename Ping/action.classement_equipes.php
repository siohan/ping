<?php
if( !isset( $gCms() ) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
$saison = $this->GetPreference('saison_en_cours');
$record_id = '';
$query = "SELECT cl.idequipe,eq.friendlyname,eq.libequipe,cl.poule,cl.clt,cl.equipe,cl.joue,cl.pts FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.id = cl.idequipe AND cl.saison = ?";
$parms['saison'] = $saison;
//en parametres possibles : 
#le championnat recherché ou non
#une equipe précise ou non

	if(isset($params['record_id']) && $params['record_id'] !='')
	{
			
		$query.=" AND cl.idequipe = ?";
		$params['record_id'] = $parms['idequipe'];
	
	}

//on aordonne la table
$query.= " ORDER BY cl.id ASC";


//on effectue la requete
$dbresult = $db->Execute($query,$parms);
echo $query;
$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->friendlyname = $row['friendlyname'];
		$onerow->libequipe = $row['libequipe'];
		$onerow->clt = $row['clt'];
		$onerow->equipe = $row['equipe'];		
		$rowarray[]  = $onerow;
			
	}

}
else
{
	echo 'Pas de résultats';
}
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('classement.tpl');
#
#EOF
#
?>