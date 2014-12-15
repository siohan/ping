<?php
if( !isset( $gCms() ) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
$db =& $this->GetDb();
//debug_display($params, 'Parameters');


$query = "SELECT * FROM ".cms_db_prefix()."module_ping_classement AS clt WHERE saison = ?";
$parms['saison'] = $saison_courante;
//en parametres possibles : 
#le championnat recherché ou non
#une equipe précise ou non
$query.=" ORDER BY ";
	if(isset($equipe) && $equipe !='')
	{
		$query.=" AND clt.idequipe = ?";
		$equipe = $parms['equipe'];
		$order = "clt.idequipe";
	}

//on aordonne la table
$query.= "ORDER BY clt.id ASC";
echo $query;

//on effectue la requete
$dbresult = $db->Execute($query,$parms);

if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->rowclass $rowclass;
		
	}
}



#
#EOF
#
?>