<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
require_once(dirname(__FILE__).'/include/prefs.php');

$now = trim($db->DBTimeStamp(time()), "'");
$query = "SELECT licence, CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";
$dbresult = $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
$cle_appel = random(10);
if ($dbresult && $dbresult->RecordCount() > 0)
  {
  // on instancie la classe 

    while ($row= $dbresult->FetchRow())
      {
	  $service = new Service();
	$licence = $row['licence'];
	$joueur = $row['joueur'];
	
	echo $licence." ".$joueur."<br />";
	//echo "<td>".$row['licence']."</td>";

//var_dump($result);
     
/**/
$result = $service->getJoueurParties("$licence");
$i = 0;
		foreach($result as $cle =>$tab)
		{
			$comptage = 0;
			
			//on vérifie que le service est ok sinon on passe au suivant
			if(!is_array($result) && count($result)==0){
				//le service est down
				$designation = "Service coupé ou licence indisponible pour ".$joueur;
				$status = 'Echec';
				$action ='retrieve_all_parties';
				
				ping_admin_ops::ecrirejournal($now, $status, $designation, $action);
			}
			else{
		
			$licence = $tab[licence];
			$advlic = $tab[advlic];
			$vd = $tab[vd];
	
				if ($vd =='V'){
					$vd = 1;
					}
				else 
					{$vd = 0;
				}
		
			$numjourn = $tab[numjourn];
			if(is_array($numjourn)){$numjourn = '0';}
			$codechamp = $tab[codechamp];
			$dateevent = $tab[date];
			$chgt = explode("/",$dateevent);
			$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
			//echo "la date est".$date_event;
	
			//	$date_event = conv_date_vers_mysql($dateevent);
			$advsexe = $tab[advsexe];
			$advnompre = $tab[advnompre];
			$pointres = $tab[pointres];
			$coefchamp = $tab[coefchamp];
			$advclaof = $tab[advclaof];
	
/**/		$query = "SELECT licence,advlic, numjourn, codechamp, date_event, coefchamp FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND advlic = ? AND numjourn = ? AND codechamp = ? AND date_event = ? AND coefchamp = ?";
		$dbresult = $db->Execute($query, array($licence, $advlic, $numjourn, $codechamp, $date_event, $coefchamp));
		if($dbresult  && $dbresult->RecordCount() == 0) {
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$i++;
			//echo $query;
			$dbresultat = $db->Execute($query,array( $licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));
		
			if(!$dbresultat)
				{
					$designation = $db->ErrorMsg(); 
					$status = 'Echec';
					$action = 'retrieve_all_parties';
					ping_admin_ops::ecrirejournal($now, $status, $designation, $action);
				}
				
			}
			
		}//fin du else !is_array
		}//fin du foreach
		$designation = "Inclusion de ".$i." résultats pour ".$joueur;
		$status = 'Ok';
		$action = 'retrieve_all_parties';
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
		/*$comptage = $i;
		$designation = "Récupération de ".$comptage." parties de ".$player;
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datemaj, designation, action) VALUES ('', ?, ?, ?)";
		$action = "retrieve_parties";
		$dbresult = $db->Execute($query, array($now, $designation,$action));
		if(!$dbresult)
		{
			echo $db->sql.'<br/>'.$db->ErrorMsg(); die();
		}
		*/
		
	}//fin du while
}//fin du if $dbresult
else {echo "<p>Pas de joueurs actifs.</p>";}
/**/
/*	
	$this->SetMessage($this->Lang('saved_record'));
	$this->RedirectToAdminTab('rencontres');
*/
#
# EOF
#
?>