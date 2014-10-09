<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/action.authentification.php');
$cle_compte = $_SESSION['cle_compte'];
if ( isset( $params['cle'])) {
	$cle = $params['cle'];
	
}



$db =& $this->GetDb();
global $themeObject;

$result= array ();
$query= "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE cle = ? AND cle_compte = ? ORDER BY date_compet DESC GROUP BY date_compet";
$dbresult= $db->Execute($query, array($cle,$cle_compte));
$rowclass= 'row1';
$rowarray= array ();

$returnLink = $this->CreateFrontendLink($id,$returnid, 'fe_teamresults',$addtext='Retour');
echo '<p>'.$returnLink.'</p>';
if ($dbresult && $dbresult->RecordCount() > 0)
  {
   echo '<table class="display" style="border: 1"><tr><th>Id</th><th>Tour</th><th>Equipe</th><th>Joueur</th><th>Adversaire</th><th>Vic Déf</th><th>Pts</th></tr>';	
    while ($row= $dbresult->FetchRow())
      {
	echo '<tr><td>'.$row['id'].'</td><td>'.$row['equipe'].'</td><td>'.$row['tour'].'</td><td>'.$row['joueur'].'</td><td>'.$row['adversaire'].'</td><td>'.$row['vic_def'].'</td><td>'.$row['points'].'</td></tr>';

      }
echo '</table>';
  }
else{
	echo "pas de résultats correspondant à votre demande";
}
/*
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));

$smarty->assign('returnlink', 
		$this->CreateLink($id,'viewteamresults', $returnid,'Retour', 'class=\'button\’'));

//echo $this->ProcessTemplate('userslist.tpl');

*/
#
# EOF
#
?>