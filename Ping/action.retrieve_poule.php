<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
$service = new Service();
$result = $service->getPoules("2107");
//$result = $service->getEquipesByClub("07290229","M");
//$result = $service->getJoueurParties("292271");

var_dump($result);
     
/*
foreach($result as $cle =>$tab)
{
	
	$cle_appel = 'AP';
	echo "$cle_appel <br />";
	$libequipe = $tab[libequipe];
	$libdivision = $tab[advlic];
	$liendivision = $tab[liendivision];
	$idpoule = $tab[idpoule];
	$iddiv = $tab[iddiv];
	
	
	$query = "SELECT advlic, cle_appel FROM ".cms_db_prefix()."module_ping_equipes WHERE advlic = ? AND cle_appel = ?";
	$dbresult = $db->Execute($query, array($advlic, $cle_appel));
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id,cle_appel, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		echo $query;
		$dbresultat = $db->Execute($query,array($cle_appel, $licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));
		
		if(!$dbresultat)
		{
			$error = $db->ErrorMsg().' -- '.$db->sql;
			break;
		}
//	}
}
/**/
/*	
	$this->SetMessage($this->Lang('saved_record'));
	$this->RedirectToAdminTab('rencontres');
*/
#
# EOF
#
?>