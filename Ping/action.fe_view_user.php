<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
/*
$maClasse = 'class.Service.php';
$service = new $maClasse();
*/
$service = new Service();
$result = $service->getLicencesByClub("07290229");

//var_dump($result);
//$pointeur = count($result);
//echo 'la valeur du pointeur est de : '.$pointeur;
//echo $result[0];
/*
for($i=0;$i<=$pointeur;$i++)
{
	echo "$result[$i]['licence'] <br />";
}

//var_dump($result);
/**/

foreach($result as $cle =>$tab)
{
	$licence = $tab[licence];
	$nom = $tab[nom];
	$prenom = $tab[prenom];
	
	$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id, licence, nom, prenom) VALUES ('', ?, ?, ?)";
		$dbresultat = $db->Execute($query,array($licence,$nom, $prenom));
		
		if(!$dbresultat)
		{
			die('FATAL SQL ERROR 1: '.$db->ErrorMsg().'<br/>QUERY: '.$db->sql);
		}
	}
}
	
	$this->SetMessage($this->Lang('saved_record'));
	$this->RedirectToAdminTab('rencontres');

#
# EOF
#
?>