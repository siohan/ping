<?php

if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$db=$gCms->GetDb();
//$db =& $this->GetDb();
$mois_courant = date('n');
$annee_courante = date('Y');
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;

$message = '';

$query = "SELECT licence, nom, prenom FROM ".cms_db_prefix()."module_ping_joueurs WHERE  actif = '1'";	

$dbresult = $db->Execute($query);
$lignes = $dbresult->RecordCount();
//echo "$lignes <br />";// nombre total de lignes possibles $i est ce compteur

if ($dbresult && $dbresult->RecordCount() > 0)
  {
	$service = new Service();
 	//on instancie un compteur 
	
	for($i=0;$i<=$lignes;$i++)
    	//while ($dbresult && $row = $dbresult->GetRows())
      	{
		$row = $dbresult->FetchRow();
		//nouvelle requete pour savoir si la situation mensuelle  a déjà été insérée
		
		$licence2 = $row['licence'];
		$nom1 = $row['nom'];
		$prenom1 = $row['prenom'];
		echo "$i le joueur est ".$nom1." ".$prenom1." ".$licence2."<br/>";
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
	//	echo "$query <br />";
		$dbresultat = $db->Execute($query, array($licence2,$mois_courant, $annee_courante));
		$nlignes = $dbresultat->RecordCount();
		echo "le nb de lignes retournées est ".$nlignes."<br />";
		if ($dbresultat->RecordCount() == 0)
		{
			//aucune saisie faite, on va d'abord vérifier que la licence de chacun fonctionne au niveau de la fftt (is_array)
			
			//echo "sit mens déjà saisie <br />";
		
			
		
			$result = $service->getJoueur("$licence2");
			//var_dump($result);
			
				if(!is_array($result))
				{
					$message.="Service coupé ou licence absente pour ".$nom." ".$prenom;
				}
				else{
			
				/**/
			//	$cle_appel = 'AP';
			//	$phase = 2;
				//echo "$cle_appel <br />";
			
				$licence = $result[licence];
				//	echo "la licence est $licence <br />";
				$nom = $result[nom];
				$prenom = $result[prenom];
				echo "le deuxième appel est : ".$nom." ".$prenom. "<br />";
				$natio = $result[natio];
				$clglob = $result[clglob];
				$points = $result[point];
				$aclglob = $result[aclglob];
				$apoint = $result[apoint];
				$clnat = $result[clnat];
				$categ = $result[categ];
				$rangreg = $result[rangreg];
				$rangdep = $result[rangdep];
				$valcla = $result[valcla];
				$clpro = $result[clpro];
				$valinit = $result[valinit];
				$progmois = $result[progmois];
				$progann = $result[progann];

					if( $licence == '')
					{
						// il n'y a pas de correspondance
						//ou le joueur est désactivé
						//ou le service est H.S
						//on le reporte dans le journal dédié
						$status = "Error";
						$designation = "Licence absente pour ".$nom1." ".$prenom1." ou coupure du service";
						$message.= $designation;
						echo "$designation";
						$action = "retrieve_all_sit_mens";
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datemaj, status, designation, action) VALUES ('', ?, ?, ?, ?)";
						$dbresult = $db->Execute($query, array($now, $status, $designation, $action));
					
			
					}
					else
					{


						$query = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						//echo $query;
						$dbresultat = $db->Execute($query,array($now,$now,$mois_courant, $annee_courante, $phase, $licence, $nom, $prenom, $points, $clnat, $rangreg, $rangdep, $progmois));

							if(!$dbresultat)
							{
								$message.=$db->ErrorMsg(); 
							}
							else
							{
						
							
								//on envoie un message à la table récup 
								$status = "Ok";
								$designation = "Récupération situation mensuelle de ".$mois_sm." ".$annee_courante." de ".$nom." ".$prenom;
								$message.= $designation;
								echo "$designation<br />";
								$action = 'retrieve_all_sit_mens';
								$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
								$dbquery = $db->Execute($query, array($now,$status,$designation,$action));
								
								if(!$dbquery){
									$message.=$db->ErrorMsg(); 
								}
								//on modifie aussi la table des recup parties
								$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET sit_mens = ?, datemaj = ? WHERE licence = ?";
								//$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, sit_mens, licence) VALUES ('', ?, ?)";
						
								$dbquery2 = $db->Execute($query, array( $mois_sit_mens, $now, $licence2));
								if(!$dbquery2){
									$message.=$db->ErrorMsg(); 
								}
							}
					}//fin du if $licence	
			$status = 'Echec';
			$designation = "Echec situation mensuelle de ".$mois_sm." ".$annee_courante." de ".$nom." ".$prenom;	}//fin du if is_array
			$action = 'retrieve_all_sit_mens';
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
			$dbquery = $db->Execute($query, array($now,$status,$designation,$action));
			
			if(!$dbquery){
				echo $db->sql.'<br/>'.$db->ErrorMsg(); 
			}
			}//fin du if is_array
			else
			{
				echo "sit mens déjà saisie <br />";
			}//fin de la vérification de l'insertion d'une précédente saisie
      }//fin du while
/*//mettre le compteur de réussite d'échec

	$this->SetMessage('Mises à jour OK');
	$this->RedirectToAdminTab('situation');

*/
  }//fin du if db result
else
{
	$this->SetMessage('Pas de mise à jour effectuée');
	$this->RedirectToAdminTab('situation');
}



	
	

#
# EOF
#
?>