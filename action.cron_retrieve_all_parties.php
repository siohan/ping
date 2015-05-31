<?php
//if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
require_once(dirname(__FILE__).'/include/prefs.php');
$saison = $this->GetPreference('saison_en_cours');
$now = trim($db->DBTimeStamp(time()), "'");
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE maj_fftt < NOW()-INTERVAL 3 DAY AND saison = ? ORDER BY maj_fftt DESC LIMIT 25 ";
$dbresult = $db->Execute($query, array($saison));
//on a donc les n licences pour faire la deuxième requete
//on commence à boucler

$rowclass= 'row1';
$rowarray= array ();


if ($dbresult && $dbresult->RecordCount() > 0)
  {
  // on instancie la classe 

    while ($row= $dbresult->FetchRow())
      {
	$service = new Service();
	$licence = $row['licence'];
	$joueur = $row['joueur'];
     
/**/
	$result = $service->getJoueurParties("$licence");
	$i = 0;
	$comptage = 0;
		foreach($result as $cle =>$tab)
		{
			$comptage++;
			
			//on vérifie que le service est ok sinon on passe au suivant
			if(!is_array($result) && count($result)==0)
			{
				//le service est down
				$designation = "Service coupé ou licence indisponible pour ".$joueur;
				$status = 'Echec';
				$action ='retrieve_all_parties';
				
				ping_admin_ops::ecrirejournal($now, $status, $designation, $action);
			}
			else
			{
				// le service est Ok, on continue
			
				$licence2 = $tab[licence];
				$advlic = $tab[advlic];
				$vd = $tab[vd];
	
					if ($vd =='V'){
						$vd = 1;
						}
					else 
						{$vd = 0;
					}
		
				$numjourn = $tab[numjourn];
			
					if(is_array($numjourn))
					{
						$numjourn = '0';
					}
				
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
	
	/**/			$query2 = "SELECT licence,advlic, numjourn, codechamp, date_event, coefchamp FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND advlic = ? AND numjourn = ? AND codechamp = ? AND date_event = ? AND coefchamp = ?";
				$dbresult2 = $db->Execute($query2, array($licence2, $advlic, $numjourn, $codechamp, $date_event, $coefchamp));
			
					if($dbresult2  && $dbresult2->RecordCount() == 0) 
					{
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_parties (id,saison, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof) VALUES ('',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat = $db->Execute($query3,array( $saison_courante, $licence2, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof));
		
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
	
		//on peut faire la maj_fftt ici
		
		
		$designation = "Inclusion de ".$i." résultats pour ".$joueur;
		if($i==0)
		{
			$designation.=" Service coupé ? Licence absente ?";
		}
		else
		{
			$date_maj = date('Y-m-d');
			$query4 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = ?, fftt = ? WHERE licence = ? AND saison = ?";
			$resultat = $db->Execute($query, array($date_maj, $comptage, $licence2, $saison_courante));
		}
		
		$status = 'Ok';
		$action = 'retrieve_all_parties';
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
		unset($licence2);
		unset($i);
		
		
	}//fin du while
}//fin du if $dbresult

/**/
/*	
	$this->SetMessage($this->Lang('saved_record'));
	$this->RedirectToAdminTab('rencontres');
*/
#
# EOF
#
?>