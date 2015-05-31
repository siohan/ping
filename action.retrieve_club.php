<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
/*
$maClasse = 'class.Service.php';
$service = new $maClasse();
*/
$service = new Service();
//$result = $service->getJoueurParties("07290229");
//$result = $service->getJoueurParties("292271");
$result = $service->getRencontre("is_retour=0&phase=1&res_1=7&res_2=7&renc_id=2570415&equip_1=BOULOGNE+BILLANCOURT+AC+2&equip_2=FOUESNANT+RP+1&equip_id1=296936&equip_id2=296941");
var_dump($result);

/*     

foreach($result as $cle =>$tab)
{
	
	$cle_appel = random(20);
	$licence = $tab[licence];
	$advlic = $tab['advlic'];
	$vd = $tab['vd'];
	if ($vd =='V'){
		$vd = 1;
		}
	else 
		{$vd = 0;}
	$numjourn = $tab['numjourn'];
	$codechamp = $tab['codechamp'];
	$date = $tab['date'];
	$advsexe = $tab['advsexe'];
	$advnompre = $tab['advnompre'];
	$pointres = $tab['pointres'];
	$coefchamp = $tab['coefchamp'];
	$advclaof = $tab['advclaof'];
	
	$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult  && $dbresult->RecordCount() == 0) {
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id,cle_appel, licence, advlic, vd, numjourn, codechamp, date, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresultat = $db->Execute($query,array('', $cle_appel, $licence, $advlic, $vd, $numjourn, $codechamp, $date, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));
		
		if(!$dbresultat)
		{
			die('FATAL SQL ERROR 1: '.$db->ErrorMsg().'<br/>QUERY: '.$db->sql);
		}
//	}
}
	
	$this->SetMessage($this->Lang('saved_record'));
	$this->RedirectToAdminTab('rencontres');
*/
#
# EOF
#
?>