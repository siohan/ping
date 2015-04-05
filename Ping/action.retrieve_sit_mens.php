<?php
#################################################################################
###                   Récupération de la situation mensuelle                  ###
###                   Auteur Claude SIOHAN                                    ###
#################################################################################

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

//les préférences
$mois_courant = date('n');
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$annee_courante = date('Y');
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;

$designation = ''; //instanciation du message de sortie

//echo "le mois de la situation mensuelle est : ".$mois_sit_mens;
$now = trim($db->DBTimeStamp(time()), "'");

$licence = '';

	if(!isset($params['licence']) && $params['licence'] =='')
	{
		$designation .= 'Pas de n° de licence';
		$this->SetMessage($designation);
		$this->RedirectToAdminTab('recup');
	}
	else
	{
		$licence = $params['licence'];
	}

//on vérifie que le joueur en question est bien actif
$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
$dbresult = $db->Execute($query, array($licence));
//le joueur ne remplit pas les conditions de la requete, on renvoit avec un message
if ($dbresult && $dbresult->RecordCount() == 0)
{
	$this->SetMessage("Joueur désactivé");
	$this->RedirectToAdminTab('situation');
}
else
{
//le joueur est actif, on va vérifier si sa situation mensuelle est déjà enregistrée
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
$dbresultat = $db->Execute($query, array($licence,$mois_courant,$annee_courante));
	
	if($dbresultat && $dbresultat->RecordCount()>0){
		//la situation mensuelle est déjà à jour, on passe
		$this->SetMessage('Situation mensuelle déjà à jour !');
		$this->RedirectToAdminTab('joueurs');
		
	}
	else
	{

//echo 'la licence est : '.$licence;
//echo "le mois courant est le : ".$mois_courant." annee courante :  ".$annee_courante;

	$service = new Service();
	$result = $service->getJoueur("$licence");
	$row = $dbresult->FetchRow();
	$player = $row['player'];
//var_dump($result);
//echo "la licence est $result[licence]";
			
		$licence2 = $result[licence];
	//	echo "la licence est $licence <br />";
		$nom = $result[nom];
		$prenom = $result[prenom];
		$natio = $result[natio];
		$clglob = $result[clglob];
		$point = $result[point];
		$aclglob = $result[aclglob];
		$apoint = $result[apoint];
		$clnat = $result[clnat];
		$categ = $result[categ];
		$rangreg = $result[rangreg];
		$rangdep = $result[rangdep];
		$valcla = $result[valcla];
		$clpro = $result[clpro];
		$valinit = $taresultb[valinit];
		$progmois = $result[progmois];
		$progann = $result[progann];
		
		if( $licence2 == '')
		{
			// il n'y a pas de correspondance
			//ou le joueur est désactivé
			//ou le service est H.S
			//on le reporte dans le journal dédié
			$status = "error";
			$designation = "Licence absente pour ".$player." ou coupure du service";
			$action = "retrieve_sit_mens";
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datemaj, status, designation, action) VALUES ('', ?, ?, ?, ?)";
			$dbresult = $db->Execute($query, array($now, $status, $designation, $action));
			$this->SetMessage("licence absente à la FFTT ou coupure du service");
				$this->RedirectToAdminTab('situation');
			
		}
		else
		{
			
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_sit_mens (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			//echo $query;
			$dbresultat = $db->Execute($query,array($now,$now,$mois_courant, $annee_courante, $phase, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
				//On vérifie que l'insertion se passe bien
				
				if(!$dbresultat)
				{
					$message.= $db->ErrorMsg(); 
					$this->SetMessage("$message");
					$this->RedirectToAdminTab('joueurs');
				//break;
				}
				else 
				{
				
			
					//on insère aussi l'enegistrement dans le journal
					$designation = "Récupération situation mensuelle de  ".$mois_sm." ".$annee_courante." de ".$nom." ".$prenom;
					$status = 'Sit_mens';
					/*
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datemaj, status,designation, action) VALUES ('', ?, ?, ?, ?)";
					$action = "retrieve_sit_mens";
					$dbresult = $db->Execute($query, array($now, $status, $designation,$action));
					*/
					//on écrit dans le journal
					ping_admin_ops::ecrirejournal($now,$status,$designation, $action);
					/*
					
						if(!$dbresult)
						{
							echo $db->sql.'<br/>'.$db->ErrorMsg(); 
						}
			
					*/
					$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
					$dbresult = $db->Execute($query, array($licence2));
			
						if($dbresult->RecordCount() == 0) 
						{
							$fftt = 0;
							$spid = 0;
							$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens, fftt, spid) VALUES ('', ?, ?, ?, ?, ?, ?)";
							$dbresult = $db->Execute($query, array($saison, $now, $licence2, $mois_sit_mens, $fftt, $spid));
				
							$this->SetMessage("Situation mensuelle ajoutée");
							$this->RedirectToAdminTab('situation');
						}
						else 
						{
							$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET datemaj = ? , sit_mens = ? WHERE licence = ?";
							$dbresult = $db->Execute($query, array($now, $mois_sit_mens, $licence2));

								if(!$dbresult)
								{
									$message = $db->ErrorMsg();
								}
								else
								{

									$message = "Situation mensuelle mise à jour";
								}
					
								$this->SetMessage("$message");
								$this->RedirectToAdminTab('situation');
						}
				}//fin du if si l'insertion se passe bien
		}//fin du if $licence				
	}//fin de la vérification de la sit_mens en bdd
	}//fin du test si le joueur est actif en bdd


/*	
	$this->SetMessage($this->Lang('saved_record'));
	$this->RedirectToAdminTab('situation');
*/
#
# EOF
#
?>