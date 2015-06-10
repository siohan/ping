<?php
#############################################################################
###          RÉCUPERATION DE TOUTES LES SITUATIONS MENSUELLES             ###
#############################################################################
if( !isset($gCms) ) exit;
//on vérifie les permissions
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$db=$gCms->GetDb();
//$db =& $this->GetDb();
$mois_courant = date('n');
//pour test, je change manuellement le mois courant
//$mois_courant = 2;
$annee_courante = date('Y');
$saison = $this->GetPreference('saison_en_cours');
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;

$message = '';
//je sélectionne toutes les licences du mois en question donc déjà renseignées
// afin de ne récupérer que celles manquantes
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE mois = ? AND annee = ?";
//je les mets ensuite dans un tableau pour faire le NOT IN	

$dbresult = $db->Execute($query, array($mois_courant, $annee_courante));
$row = $dbresult->GetRows();
$lic = array();
//$lic = $row[0]['licence'];
//echo "La valeur est : ".$lic;
$lignes = $dbresult->RecordCount();
for($i=0;$i<=$lignes;$i++)
{
	array_push($lic,$row[$i]['licence']);
	$licen = substr(implode(", ", $lic), 0, -3);
}
if($lignes ==0)
{
	$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif=1";
}
else
{
	$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif=1 AND licence NOT IN ($licen)";
}
//echo $query2;
$dbresult = $db->Execute($query2);

if ($dbresult && $dbresult->RecordCount() > 0)
  {
	$service = new Service();
 	//on instancie un compteur 
	

    	while ($dbresult && $row = $dbresult->FetchRow())
      	{
		$licence2 = $row['licence'];
			
		$result = $service->getJoueur("$licence2");
		//var_dump($result);
			
		if(!is_array($result))
		{
			$message.="Service coupé ou licence absente pour ".$nom." ".$prenom;
		}
		else
		{
			
				
			$nom = $result['nom'];
			$prenom = $result['prenom'];
			$natio = $result['natio'];
			$clglob = $result['clglob'];
			$points = $result['point'];
			$aclglob = $result['aclglob'];
			$apoint = $result['apoint'];
			$clnat = $result['clnat'];
			$categ = $result['categ'];
			$rangreg = $result['rangreg'];
			$rangdep = $result['rangdep'];
			$valcla = $result['valcla'];
			$clpro = $result['clpro'];
			$valinit = $result['valinit'];
			$progmois = $result['progmois'];
			$progann = $result['progann'];

			$query = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id,datecreated, datemaj, saison, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			//echo $query;
			$dbresultat = $db->Execute($query,array($now,$now,$saison,$mois_courant, $annee_courante, $phase, $licence2, $nom, $prenom, $points, $clnat, $rangreg, $rangdep, $progmois));

				if(!$dbresultat)
				{
					$message.=$db->ErrorMsg(); 
					$status = 'Echec';
					$designation = "Echec situation mensuelle de ".$mois_sm." ".$annee_courante." de ".$nom." ".$prenom;	//fin du if is_array
					$action = 'retrieve_all_sit_mens';
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
					$dbquery = $db->Execute($query, array($now,$status,$designation,$action));
					
					if(!$dbquery)
					{
						echo $db->sql.'<br/>'.$db->ErrorMsg(); 
					}
					
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
								
						if(!$dbquery)
						{
							$message.=$db->ErrorMsg(); 
						}
						
						//on modifie aussi la table des recup parties
						$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET sit_mens = ?, datemaj = ? WHERE licence = ?";
						//$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, sit_mens, licence) VALUES ('', ?, ?)";
						
						$dbquery2 = $db->Execute($query, array( $mois_sit_mens, $now, $licence2));
								
						if(!$dbquery2)
						{
							$message.=$db->ErrorMsg(); 
						}
				}
					
			
		}//fin du if is_array
		
        }//fin du while

	$this->SetMessage('Mises à jour OK');
	$this->RedirectToAdminTab('situation');

  }
  

#
# EOF
#
?>