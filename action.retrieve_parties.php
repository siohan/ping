<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$now = trim($db->DBTimeStamp(time()), "'");
$mois_courant = date('n');
$annee_courante = date('Y');
$saison = $this->GetPreference('saison_en_cours');
$licence = $params['licence'];
$designation = '';
$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
$dbretour = $db->Execute($query, array($licence));

	if ($dbretour && $dbretour->RecordCount() > 0)
  	{
    		while ($row= $dbretour->FetchRow())
      		{
			$player = $row['player'];
			//return $player;
		}
	
	}
	else
	{
		$this->SetMessage("Joueur introuvable");
		$this->RedirectToAdminTab('recup');
	}


$service = new Service();

//$result = $service->getJoueurParties("07290229");
$result = $service->getJoueurParties("$licence");


	if (!is_array($result)|| count($result)==0)
	{
		//
		$this->SetMessage('Pb accès résultat');
		$this->RedirectToAdminTab('recup');
	}
	
//var_dump($result);  
/**/
$i = 0;
$compteur = 0;
foreach($result as $cle =>$tab)
{
	$compteur++;
	
	$licence = $tab['licence'];
	$advlic = $tab['advlic'];
	$vd = $tab['vd'];
	
		if ($vd =='V')
		{
			$vd = 1;
		}
		else 
		{
			$vd = 0;
		}
		
	$numjourn = $tab['numjourn'];
	
		if(is_array($numjourn))
		{
			$numjourn = '0';
		}
		
	$codechamp = $tab['codechamp'];
	
	//on essaie de déterminer le nom de cette compet ?
	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competition WHERE code_compet = ?";
	
	$dateevent = $tab['date'];
	$chgt = explode("/",$dateevent);
	$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
	//echo "la date est".$date_event;
	
//	$date_event = conv_date_vers_mysql($dateevent);
	$advsexe = $tab['advsexe'];
	$advnompre = $tab['advnompre'];
	$pointres = $tab['pointres'];
	$coefchamp = $tab['coefchamp'];
	$advclaof = $tab['advclaof'];
	
/**/	$query = "SELECT licence,advlic, numjourn, codechamp, date_event, coefchamp FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND advlic = ? AND numjourn = ? AND codechamp = ? AND date_event = ? AND coefchamp = ?";
	$dbresult = $db->Execute($query, array($licence, $advlic, $numjourn, $codechamp, $date_event, $coefchamp));
	
	if($dbresult  && $dbresult->RecordCount() == 0) 
	{
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id, saison, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$i++;
		//echo $query;
		$dbresultat = $db->Execute($query,array($saison,$licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));
		
			if(!$dbresultat)
			{
				$designation.=$db->ErrorMsg(); 
			}
	}
}
$comptage == $i;
$status = 'Parties FFTT';
$designation.= "Récupération de ".$i." parties sur ".$compteur." de ".$player;
$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
$action = "retrieve_parties";
$dbresult = $db->Execute($query, array($now, $status,$designation,$action));

	if(!$dbresult)
	{
			$designation.=$db->ErrorMsg(); 
	}
	
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
$dbresult = $db->Execute($query, array($licence));
$lignes = $dbresult->RecordCount();
	$aujourdhui = date('Y-m-d');
	if($lignes>0)
	{
		$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET fftt = ?, maj_fftt = ? WHERE licence = ?";
		$dbresult = $db->Execute($query, array($compteur,$aujourdhui,$licence));
	}
	else
	{
	$sit_mens = 'Janvier 2000';
	$fftt = $compteur;
	$spid = '0';
	$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens, fftt, spid) VALUES ('', ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($saison, $now, $licence, $sit_mens,$fftt,$spid));
	}



	if(!$dbresult)
	{
		$designation.=$db->ErrorMsg(); 
	}
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('recup');

#
# EOF
#
?>