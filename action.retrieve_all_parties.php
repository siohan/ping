<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
require_once(dirname(__FILE__).'/include/prefs.php');

$now = trim($db->DBTimeStamp(time()), "'");
$query = "SELECT licence, CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";
$dbresult = $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount() > 0)
  {
  // on instancie la classe 

	while ($row= $dbresult->FetchRow())
      	{
		$service = new retrieve_ops();
		$licence = $row['licence'];
		$joueur = $row['joueur'];
		retrieve_ops::retrieve_parties_fftt("$licence");
		sleep(1);
     	}
		
		
}//fin du if $dbresult
else {echo "<p>Pas de joueurs actifs.</p>";}
/**/
	
	$this->SetMessage('Voir Journal');
	$this->RedirectToAdminTab('fftt');

#
# EOF
#
?>