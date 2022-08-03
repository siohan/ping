<?php
class spid_ops
{
	function __construct() {}
	
	function details_recup($licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query="SELECT id, licence, sit_mens, fftt, maj_fftt,spid, spid_total, spid_errors, maj_spid, pts_spid, pts_fftt FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$details_recup = array();
			while($row = $dbresult->FetchRow())
			{
				$details_recup['id'] = $row['id'];
				$details_recup['licence'] = $row['licence'];
				$details_recup['sit_mens'] = $row['sit_mens'];
				$details_recup['fftt'] = $row['fftt'];
				$details_recup['maj_fftt'] = $row['maj_fftt'];
				$details_recup['spid'] = $row['spid'];
				$details_recup['spid_total'] = $row['spid_total'];
				$details_recup['spid_errors'] = $row['spid_errors'];
				$details_recup['maj_spid'] = $row['maj_spid'];
				$details_recup['pts_spid'] = $row['pts_spid'];
				$details_recup['pts_fftt'] = $row['pts_fftt'];
			}
			return $details_recup;	
			
		}
		else
		{
			return false;
		}
		
	}
	function add_spid($statut,$saison_courante,$now, $licence, $date_event, $epreuve, $nom, $newclass, $victoire,$ecart,$type_ecart, $coeff,$pointres, $forfait, $idpartie)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_parties_spid (statut, saison, datemaj, licence, date_event,epreuve, nom,classement, victoire, ecart, type_ecart, coeff, pointres,forfait, idpartie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($statut,$saison_courante,$now, $licence, $date_event, $epreuve, $nom, $newclass, $victoire,$ecart,$type_ecart, $coeff,$pointres, $forfait, $idpartie));

		if(!$dbresult)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	function recalcul_spid($record_id)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "SELECT id, licence,nom, victoire,epreuve, classement, forfait, date_event FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";//" AND MONTH(date_event) = ? AND saison LIKE ?";
		$dbresult = $db->Execute($query, array($record_id));//, $date_event, $saison));
		$message='';
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$ping_ops = new ping_admin_ops;
				$retrieve_ops = new retrieve_ops;
				$joueurs_ops = new joueurs;
				$error = 0;
				while($row = $dbresult->FetchRow())
				{
					$mois_courant = date('n'); //mois sans zéro initial
					$annee_courante = date('Y');
					$licence = $row['licence'];
					$nom = $row['nom'];
					$victoire = $row['victoire'];
					$epreuve = $row['epreuve'];
					$classement = $row['classement'];
					$forfait = $row['forfait'];
					$date_event = $row['date_event'];
					
					//on regarde si la situation mensuelle du joueur est à jour !
					$points = $ping_ops->get_sit_mens($licence,$mois_courant,$annee_courante);
					//echo $points;
					$mois_event = date('m');
					$annee_courante = date('Y');
					if($points == FALSE)//la situation mensuelle du joueur du club n'est pas renseignée !!
					{
						//ping_admin_ops::ecrirejournal();
						$message.='Situation mensuelle manquante !!';
					}
					else
					{
						//on extrait d'abord le nom de l'adversaire
						$nom_global = $ping_ops->get_name($nom);
						$nom_reel1 = $nom_global[0];
						$nom_reel = addslashes($nom_global[0]);//le nom					
						$prenom_reel = $nom_global[1];//le prénom
				
						//on vérifie si le classement est dispo ds la table adversaires
						$get_adv_pts = $ping_ops->get_adv_pts($nom_reel1, $prenom_reel,$mois_event,$annee_courante);
						if($get_adv_pts == FALSE)//l'adversaire n'est pas ds la table adversaires
						{
							//on va chercher la sit mens du pongiste
							// D'abord son numéro de licence
							$resultat = $retrieve_ops->advlicence($nom_reel, $prenom =$prenom_reel);
							//var_dump($resultat);
							if($resultat === FALSE)
							{
								//pas de résultat, on prend le classement fourni par défaut : erreur douce
								$newclass = $classement;						
							}
							else
							{
								$licence_adv = $resultat;//on a bien un numéro de licence, on peut donc récupérer la situation mensuelle en cours
								//echo "<br />".$licence_adv.'<br />';

								$insert_adv = $retrieve_ops->retrieve_sit_mens($licence_adv, $ext='True');
								//var_dump($insert_adv);
								//
								if($insert_adv === FALSE)//pas de résultats !
								{
									$newclass = $classement;
						
								}
								else
								{
									$newclass = $insert_adv;
								}
							}
						}
						else
						{
							//troisième cas : 
							//on n'a pas les points et on n'est pas dans le mois courant, on n'insère pas et on utilise le classement fourni
							$error++;
					
								$newclass = $classement;
				
						}
					
						$ecart_reel = $points - $newclass;
						
						//on calcule l'écart selon la grille de points de la FFTT
						$type_ecart = $ping_ops->CalculEcart($ecart_reel);

					
						//il faut maintenant récupérer le idepreuve et le coeff
						//echo $epreuve;
						
						$senior = $joueurs_ops->isSenior($licence);
						//echo $senior;
						$type_coeff = $ping_ops->coeff($epreuve,$senior);
						if($type_coeff == FALSE)
						{
							$error++;
							$message.=' Le coefficient de l\épreuve '.$epreuve.' est introuvable';
						}
						$points1 = $ping_ops->CalculPointsIndivs($type_ecart, $victoire);
						$pointres = $points1*$type_coeff;
						//$tab['forfait'];

						if($error >0)
						{
							$statut = 0;
						}
						else
						{
							$statut = 1;
						}
						$now = date('Y-m-d H:i:s');
						$ping_ops->ecrirejournal($now, $statut='OKO', $message, $action='recalcul');
						$update_spid = $this->update_spid_calcul($record_id, $ecart_reel, $type_ecart, $type_coeff, $pointres);
						/*
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (statut,saison, datemaj, licence, date_event, epreuve, nom, numjourn,classement, victoire,ecart,type_ecart, coeff, pointres, forfait) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$i++;
						//echo $query;
						$dbresultat3 = $db->Execute($query3,array($statut,$saison_courante,$now, $licence, $date_event, $epreuve, $nom, $numjourn, $newclass, $victoire,$ecart_reel,$type_ecart, $type_coeff,$pointres, $forfait));

						if(!$dbresultat3)
						{
								$message = $db->ErrorMsg(); 
								$status = 'Echec';
								$designation = $message;
								$action = "mass_action";
								$ping_ops->ecrirejournal($now,$status, $designation,$action);
						}
						*/				
						
					}
					
				}//fin du while
			}
		}
	}
	//compte le nb de rencontres spid d'un joueur
	public static function compte_spid($licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping_ops = new ping_admin_ops;
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		$mois = date('m');
		$query = "SELECT count(*) AS spid FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ? AND MONTH(date_event) = ?";
		$dbresult = $db->Execute($query, array($licence,$saison,$mois));
		$row = $dbresult->FetchRow();
		$nb = $row['spid'];
		$ping_ops->maj_recup_parties($licence,$nb,$table='SPID');
		return $nb;


	}
	//compte le nb d'erreurs spid d'un joueur
	public static function compte_spid_errors($licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$mois_courant = date('m');
		$ping = cms_utils::get_module('Ping');
		$ping_ops = new ping_admin_ops();
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT count(*) AS spid_errors FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ? AND MONTH(date_event) = ? AND statut = 0";
		$dbresult = $db->Execute($query, array($licence,$saison,$mois_courant));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$spid_errors = $row['spid_errors'];
			$nb = $spid_errors;
			$ping_ops->maj_recup_parties($licence,$nb,$table='SPID_ERRORS');
			return $spid_errors;
		}


	}
	//compte le nb de points spid d'un joueur
	public static function compte_spid_points($licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$mois_courant = date('m');
		$ping = cms_utils::get_module('Ping');
		$ping_ops = new ping_admin_ops();
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT SUM(pointres) AS spid_points FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND saison = ? AND MONTH(date_event) = ?";
		$dbresult = $db->Execute($query, array($licence,$saison,$mois_courant));
		if($dbresult)
		{	
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$spid_points = $row['spid_points'];
				return $spid_points;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}


	}
	//met à jour le calcul effectué précédemment
	function update_spid_calcul($record_id, $ecart, $type_ecart, $coeff, $pointres)
	{
		$db = cmsms()->GetDb();
		$statut = 1;
		$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET datemaj = NOW(), statut = ?, ecart = ?, type_ecart = ?, coeff = ?, pointres = ? WHERE id = ?";		
		$dbresult = $db->Execute($query,array($statut,$ecart,$type_ecart, $coeff,$pointres, $record_id));

		if($dbresult)
		{
			$ping_ops = new ping_admin_ops;
			$message = $db->ErrorMsg(); 
			$status = 'Ok';
			$designation = $message;
			$action = "mass_action";
			$now = date('Y-m-d H:i:s');
			$ping_ops->ecrirejournal($now,$status, $designation,$action);
			return true;
		}
		else
		{
			return false;
		}
	}
	//élimine les parties spid obsoletes 
	function delete_spid()
	{
		$db = cmsms()->GetDb();
		$mois = date('n')-1;
		//$mois_courant = $mois-1;
		$annee_courante = date('Y');
		$day = '31';
		$jour = date('d');
		
		$aujourdhui = $annee_courante.'-'.$mois.'-'.$day;
		$query = "DELETE FROM  ".cms_db_prefix()."module_ping_parties_spid WHERE date_event <= ?";
		$dbretour = $db->Execute($query, array($aujourdhui));
		if ($dbretour)
		{
		    return true;

		}
		else
		{
		return false;
		}
	}
	//élimine les adversaires de la table dédiée , infos obsoletes.
	function delete_adversaires()
	{
		$db = cmsms()->GetDb();
		$mois_courant = date('n');//mois sans le zéro initial
		$annee_courante = date('Y');
		$query = "DELETE FROM  ".cms_db_prefix()."module_ping_adversaires WHERE mois < ? AND annee <= ?";
		$dbretour = $db->Execute($query, array($mois_courant, $annee_courante));
		if ($dbretour && $dbretour->RecordCount() > 0)
		{
		    return true;

		}
		else
		{
		return false;
		}
	}
	
	//recalcule le spid pour un seul joueur
	function recalcul($licence)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT id FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		if($dbresult && $dbresult->recordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$id = $row['id'];
				$this->recalcul_spid($id);
			}		
		}
	}
	//vérifie si la partie existe dans la table Spid
	function spid_exists($idpartie)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT idpartie FROM ".cms_db_prefix()."module_ping_parties_spid WHERE idpartie = ? AND coeff !=''";
		$dbresult = $db->Execute($query, array($idpartie));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			return true;
		}
		else
		{return false;}
	}
	//met la somme des points spid à jour pour un joueur donné
	function maj_points_spid($licence, $points)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET pts_spid = ?, maj_spid = UNIX_TIMESTAMP() WHERE licence = ?";
		$dbresult = $db->Execute($query, array($points, $licence));
	}
	
	//vérifie si le compte spid existe
	function has_spid_account($licence)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			return true; 
		}
		else
		{
			return false;
		}
	}
	
	//on créé un compte si le joueur n'en a pas
	function create_spid_account($licence)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_recup_parties (saison, datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total, pts_spid) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array('2020-2021',date('Y-m-d H:i:s'),$licence,'Janvier 2000',0,time(),0,time(),0,0, 0));
		if($dbresult)
		{
			return true; 
		}
		else
		{
			return false;
		}
	}
	function delete_partie_spid ($idpartie)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE idpartie = ?";
		$dbresult = $db->Execute($query, array($idpartie));
	}
	////FFTT
	function add_fftt($saison,$licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof, $idpartie)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_parties (saison, licence, advlic, vd, numjourn, codechamp, date_event, advsexe, advnompre, pointres, coefchamp, advclaof, idpartie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($saison,$licence, $advlic, $vd, $numjourn, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof, $idpartie));

		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//compte le nb de matchs FFTT d'une personne
	public static function compte_fftt($licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$ping_ops = new ping_admin_ops;
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT count(*) AS fftt FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($licence,$saison));

		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb = $row['fftt'];
				$ping_ops->maj_recup_parties($licence,$nb,$table='FFTT');
			}
		}
		else
		{
			return false;
		}


	}
	//compte le nb de points FFTT d'une personne
	public static function pts_fftt($licence)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$ping_ops = new ping_admin_ops;
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT count(pointres) AS fftt FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($licence,$saison));

		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$row = $dbresult->FetchRow();
				$nb = $row['fftt'];
				return $nb;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}


	}
	//compte le nb de points FFTT d'une personne
	public static function maj_pts_fftt($licence,$nb)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET pts_fftt = ?, maj_fftt = UNIX_TIMESTAMP() WHERE licence = ?";
		$dbresult = $db->Execute($query, array($nb, $licence));

		if($dbresult)
		{
			return true;
		}
		
		else
		{
			return false;
		}


	}
	function verif_spid_fftt()
	{
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		
		$saison = $ping->GetPreference('saison_en_cours');
		$query = "SELECT DISTINCT sp.id AS record_id,p.date_event AS date_fftt,p.codechamp,sp.date_event AS date_spid,sp.licence as licence_spid,sp.epreuve, p.licence as licence_fftt,sp.nom as nom_spid, p.advnompre AS nom_fftt, sp.numjourn AS numjourn_spid, p.numjourn AS numjourn_fftt, sp.victoire AS victoire_spid, p.vd AS victoire_fftt, sp.coeff AS coeff_spid, p.coefchamp AS coeff_fftt, sp.pointres AS points_spid, p.pointres AS points_fftt FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_parties AS p WHERE sp.idpartie = p.idpartie  AND sp.saison = ? ORDER BY sp.id ASC";
		$dbresult = $db->Execute($query, array($saison));
		$rowarray = array();
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$ep_ops = new EpreuvesIndivs;
			while($row = $dbresult->FetchRow())
			{
				//on va faire les corrections directement
				//l'important est de corriger la table des épreuves
				$codechamp = $row['codechamp'];
				$coefchamp = $row['coeff_fftt'];
				$epreuve = $row['epreuve'];
				$update = $ep_ops->update_epreuve($epreuve, $codechamp, $coefchamp);

			}
		}
	}
	##
	//vérifie si le joueur a un compte situation mensuelle
	function has_sitmens_account($licence)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	//créé un compte pour les situations mensuelles
	//on créé un compte si le joueur n'en a pas
	function create_sitmens_account($licence)
	{
		$db = cmsms()->GetDb();
		$add_sitMens = $ping_admin_ops->add_sit_mens($licence2, $nom, $prenom, $categ, $point,$apoint,$clglob, $aclglob, $clnat, $rangreg, $rangdep, $progmoisplaces, $progmois, $progann,$valinit, $valcla, $saison);
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_sit_mens (saison, datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array('2019-2020',NOW(),$licence,'Janvier 2000',0,time(),0,time(),0,0));
		if($dbresult)
		{
			return true; 
		}
		else
		{
			return false;
		}
	}
	//supprime les parties spid sélectionnées
	function supp_spid($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));
	}
	

	
#End of class
}
?>
