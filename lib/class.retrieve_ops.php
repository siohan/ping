<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class retrieve_ops
{
  function __construct() {}


##
##
public function retrieve_parties_spid2( $licence, $player,$cat )
  {
	global $gCms;
	$db = cmsms()->GetDb();
	$designation = "";
	$ping = cms_utils::get_module('Ping');
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$mois_courant = date('m');
	$annee_courante = date('Y');
	
	
	//les classes
	$retrieve_ops = new retrieve_ops;
	$spid_ops = new spid_ops;
	$ping_ops = new ping_admin_ops;
	
	$error_nb = '';//on va stocker les erreurs pour un traitement ultérieur
	#
	#
	
		
		$points = $ping_ops->get_sit_mens($licence,$mois_courant,$annee_courante);
	//	var_dump($points);
		if(FALSE == $points)
		{
			$designation.= "Situation mensuelle manquante pour ".$player;
			$action = "mass_action";
			$status = 'Echec';
			$ping_ops->ecrirejournal($status, $designation,$action);
			
		}
		else
		{
			//on compte le nb de résultats du spid présent ds la bdd pour le joueur


			if(substr($cat,0,1) =='S' || substr($cat,0,1) =='V')
			{
				$senior = 1;
			}
			else
			{
				$senior = 0;
			}
			//echo "senior ?".$senior;
			$service = new Servicen;

			$page = "xml_partie";
			$var = "numlic=".$licence;
			$lien = $service->GetLink($page, $var);
			//echo "<a href=".$lien.">".$lien."</a>";
			$xml   = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			var_dump($xml);
			$array_points = array();

			if($xml === FALSE)
			{
				//echo "le tableau renvoit une erreur";
				$array = 0;
				$lignes = 0;
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				//var_dump($array['resultat']);
				if(isset($array['resultat']))
				{
					//$array['resultat'] = array();
					$lignes = count($array['resultat']);
			
				}
				echo "le nb de lignes est  :".$lignes;
			}




					$compteur = 0;

					foreach($xml as $cle=> $tab)
					{
						//var_dump($array);

						
						$error = 0;//on instancie un compteur d'erreurs

						//on synthétise tous les éléments à récupérer
						//on fera un éventuel traitement ensuite
						$dateevent = (isset($tab->date)?"$tab->date":"");//$tab['date'];

						$chgt = explode("/",$dateevent);
						$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
						$annee = $chgt[2];
						
						$date_mysql = $annee.'-'.$chgt[1].'-'.$chgt[0];
							if (substr($chgt[1], 0,1)==0)
							{
								$mois_event = substr($chgt[1], 1,1);
								//echo "la date est".$date_event;
							}
							else
							{
								$mois_event = $chgt[1];
							}
							
						if($mois_event == date('m') && $annee == date('Y'))
						{
							$nom = (isset($tab->nom)?"$tab->nom":"");//$tab['nom'];
							$classement = (isset($tab->classement)?"$tab->classement":"");
							$victoire = (isset($tab->victoire)?"$tab->victoire":"");
							$forfait = (isset($tab->forfait)?"$tab->forfait":"");
							$epreuve = (isset($tab->epreuve)?"$tab->epreuve":"");//$tab['epreuve'];
							$idpartie = (isset($tab->idpartie)?"$tab->idpartie":"");
							
							$spid_ops->delete_partie_spid($idpartie);
								//on va chercher tous les coeffs connus
								//echo "<br />le nom est : ".$nom;
								//on adapte son nom d'abord
								$nom_global = $ping_ops->get_name($nom);//une fonction qui permet d'extraire le nom et le prénom
								$nom_reel1 = $nom_global[0];
								$nom_reel = addslashes($nom_global[0]);//le nom					
								$prenom_reel = $nom_global[1];//le prénom
								$annee_courante = date('Y');
								//echo "<br /> Le nom final est : ".$nom_reel;

								//classement fourni par le spid
								$cla = substr($classement, 0,1);

									//Avec le nom on va aller chercher la situation mensuelle de l'adversaire
									//on pourra la stocker pour qu'elle re-serve et l'utiliser pour affiner le calcul des points
									//d'abord on va chercher ds la bdd si l'adversaire y est déjà pour le mois et la saison en question
									$get_adv_pts = $ping_ops->get_adv_pts($nom_reel1, $prenom_reel,$mois_event,$annee_courante);



									//on n'a pas d'enregistrement et on est dans le mois courant et l'année courante : on va chercher les points avec la classe pour ensuite l'insérer ds la bdd
									if($get_adv_pts == FALSE)//l'adversaire n'est pas ds la table adversaires
									{
										//on va chercher la sit mens du pongiste
										// D'abord son numéro de licence
										$resultat = $retrieve_ops->advlicence($nom_reel, $prenom =$prenom_reel);
										//var_dump($resultat);
										if($resultat === FALSE)//homonymie ou pas de résultat
										{
											//pas de résultat, on prend le classement fourni par défaut : erreur douce
											$error++;
											if($cla == 'N')
											{
												$newclassement = explode('-', $classement);
												$newclass = $newclassement[1];
											}
											else 
											{
												$newclass = $classement;
											}
											$error_nb.=' Pas de situation mensuelle du joueur adverse';
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
												$error++;
												if($cla == 'N')
												{
													$newclassement = explode('-', $classement);
													$newclass = $newclassement[1];
												}
												else 
												{
													$newclass = $classement;
												}
												$error_nb.=' Pas de situation mensuelle du joueur adverse';
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
										if($cla == 'N')
										{
											$newclassement = explode('-', $classement);
											$newclass = $newclassement[1];
										}
										else 
										{
											$newclass = $classement;
										}
										$error_nb.=' Pas de situation mensuelle du joueur adverse';
									}

									//on va calculer la différence entre le classement de l'adversaire et le classement du joueur du club

								$ecart_reel = $points - $newclass;
								//$coeff = "0.00";//on attribue une valeur par défaut
								//on calcule l'écart selon la grille de points de la FFTT
								$type_ecart = $ping_ops->CalculEcart($ecart_reel);


								//il faut maintenant récupérer le idepreuve et le coeff
								//echo $epreuve;
								//on déclare un tableau pour y mettre la variable
								$type_coeff = $ping_ops->coeff($epreuve,$senior);
								if($type_coeff == FALSE)
								{
									$error++;
								}


								//2 - on récupére le tour s'il existe
								//on va fdonc chercher dans la table calendrier
								$idepreuve  = $ping_ops->code_compet($epreuve);


									if ($victoire =='V')
									{
										$victoire = 1;
									}
									else 
									{
										$victoire = 0;
									}

								//on peut désormais calculer les points 

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
								$add_spid = $spid_ops->add_spid($statut,$saison_courante,$now, $licence, $date_event, $epreuve, $nom, $newclass, $victoire,$ecart_reel,$type_ecart, $type_coeff,$pointres, $forfait, $idpartie);
								if(true == $add_spid)
								{
									$compteur++;
								}

							//on détruit le nb d'erreur
							unset($error);
							}
						}//fin du if mois_courant
							
					}//fin du foreach
			return $compteur;		//$comptage = $i;
			
		
		
		
		
					
  }//fin de la fonction
##

#   Retrieve parties FFTT
 static function retrieve_parties_fftt( $licence )
  { 
	global $gCms;
	$db = cmsms()->GetDb();
	$ping = cms_utils::get_module('Ping');
	//require_once(dirname(__FILE__).'/function.calculs.php');
	$saison_courante = $ping->GetPreference('saison_en_cours');
	$now = trim($db->DBTimeStamp(time()), "'");
	$aujourdhui = date('Y-m-d');
	$designation = "";
	$annee_courante = date('Y');
	$lignes = 0; //on instancie le nb de lignes 0 par défaut
	
	//les classes
	$service = new Servicen;
	$spid_ops = new spid_ops;
	
	$page = "xml_partie_mysql";
	$var = "licence=".$licence;
	$lien = $service->GetLink($page, $var);
	$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
	var_dump($xml);
	if($xml === FALSE)
	{
		$array = 0;
		$lignes = 0;
		$message = "Service coupé ou pas de résultats disponibles"; 
		$status = 'Echec';
		$designation.= $message;
		$action = "mass_action";
		ping_admin_ops::ecrirejournal($status, $designation,$action);
	}
	else
	{
		$array = json_decode(json_encode((array)$xml), TRUE);
		if(isset($array['partie']))
		{
			$lignes = count($array['partie']);
		}
		else
		{
			$lignes = 0;
		}
		
		//var_dump($xml);
	}
		
		
		$i = 0;
		$compteur = 0;
		foreach($xml as $cle =>$tab)
		{
			$compteur++;

			$licence = (isset($tab->licence)?"$tab->licence":"");
			$advlic = (isset($tab->advlic)?"$tab->advlic":"");
			$vd = (isset($tab->vd)?"$tab->vd":"");

				if ($vd =='V')
				{
					$vd = 1;
				}
				else 
				{
					$vd = 0;
				}

			$numjourn = (isset($tab->numjourn)?"$tab->numjourn":"0");

				if(is_array($numjourn))
				{
					$numjourn = '0';
				}
			$nj = (int) $numjourn;
			
			$codechamp = (isset($tab->codechamp)?"$tab->codechamp":"");

			//on essaie de déterminer le nom de cette compet ?
			//$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competition WHERE code_compet = ?";

			$dateevent = (isset($tab->date)?"$tab->date":"");
			$chgt = explode("/",$dateevent);
			//on va en déduire la saison
			if($chgt[1] < 7)
			{
				//on est en deuxième phase
				//on sait donc que l'année est la deuxième année
				$annee_debut = '20'.$chgt[2]-1;
				$annee_fin = '20'.$chgt[2];

			}
			elseif($chgt[1]>=7)
			{
				//on est en première phase
				$annee_debut = '20'.$chgt[2];
				$annee_fin = '20'.$chgt[2]+1;
			}
			$saison = $annee_debut."-".$annee_fin;
			$date_event = $chgt[2]."-".$chgt[1]."-".$chgt[0];
			//echo "la date est".$date_event;

		//	$date_event = conv_date_vers_mysql($dateevent);
			$advsexe = (isset($tab->advsexe)?"$tab->advsexe":"");
			//$advnompre = mysqli_real_escape_string($link,(isset($tab->advnompre)?"$tab->advnompre":""));
			$advnompre =(isset($tab->advnompre)?"$tab->advnompre":"");
			$pointres = (isset($tab->pointres)?"$tab->pointres":"");
			$coefchamp = (isset($tab->coefchamp)?"$tab->coefchamp":"");
			$advclaof = (isset($tab->advclaof)?"$tab->advclaof":"");
			$idpartie = (isset($tab->idpartie)?"$tab->idpartie":"");
			
			$add_fftt = $spid_ops->add_fftt($saison,$licence, $advlic, $vd, $nj, $codechamp, $date_event, $advsexe, $advnompre, $pointres, $coefchamp, $advclaof,$idpartie);
			
			
		}
		return $compteur;

  }//fin de la fonction

//la fonction ci-dessous récupère la situation mensuelle d'un joueur
public function retrieve_sit_mens($licence, $ext="")
  {
	//on vérifie si la situation mensuelle a déjà été prise en compte
	global $gCms;
	$ping = cms_utils::get_module('Ping'); 
	$adherents = cms_utils::get_module('Adherents');
	//$retrieve = new retrieve_ops();
	$ping_ops = new ping_admin_ops;
	$db = cmsms()->GetDb();
	$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
	$annee_courante = date('Y');
	$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
	$mois_reel = $mois_courant - 1;
	$mois_sm = $mois_francais["$mois_reel"];
	$mois_sit_mens = $mois_sm." ".$annee_courante;
	$message = "";
	$saison = $ping->GetPreference('saison_en_cours');
	$phase = $ping->GetPreference('phase_en_cours');
	//var_dump($ext);
	//La situation mensuelle du mois en cours n'existe pas, on l'ajoute.
	$service = new Servicen();
	$page = "xml_joueur";
	$var = "licence=".$licence;
	$lien = $service->GetLink($page, $var);
	$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
//	var_dump($xml);
	if($xml === FALSE)
	{
		$lignes = 0;
		$array = 0;
		$result = 0;
		//var_dump($xml);
		return FALSE;
	}
	else
	{
		$array = json_decode(json_encode((array)$xml), TRUE);
		//var_dump($array);
		if(isset($array['joueur']) )
		{ 
			$lignes = count($array['joueur']);
		}
		else
		{
			$lignes = 0;
		}
	}
	

		if($lignes == 0)
		{
			//le service est coupé ou la licence est inactive
			$player = $ping_ops->name($licence);
			$message.="Licence introuvable ou service coupé pour ".$player;
			$status = 'Echec';
			$designation = $message;
			$action = "mass_action";
			$ping_ops->ecrirejournal($status, $designation,$action);
			return FALSE;
		}
		else
		{
			foreach($xml as $result)
			{
				$licence2 = (isset($result->licence)?"$result->licence":"");
				$nom = (isset($result->licence)?"$result->nom":"");
				$prenom = (isset($result->licence)?"$result->prenom":"");
				$natio = (isset($result->licence)?"$result->natio":"");
				$clglob = (isset($result->licence)?"$result->clglob":"");
				$point = (isset($result->licence)?"$result->point":"");
				$aclglob = (isset($result->licence)?"$result->aclglob":"");
				$apoint = (isset($result->licence)?"$result->apoint":"");
				$clnat = (isset($result->licence)?"$result->clnat":"");
				$categ = (isset($result->licence)?"$result->categ":"");
				$rangreg = (isset($result->licence)?"$result->rangreg":"");
				$rangdep = (isset($result->licence)?"$result->rangdep":"");
				$valcla = (isset($result->licence)?"$result->valcla":"");
				$clpro = (isset($result->licence)?"$result->clpro":"");
				$valinit = (isset($result->licence)?"$result->valinit":"");
			
				
				//on peut faire qqs traitements pour calculer les progressions par exemples
				$progmoisplaces = $aclglob - $clglob;//progression en termes de places
				$progmois = $point - $apoint;//progression du mois en termes de points
				$progann = $point - $valinit; //progression à l'année en termes de points
				
				
				if( $ext === 'True')
				{

					$query5 = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_adversaires (datecreated, datemaj, mois, annee, licence, nom, prenom, points, clnat, rangreg,rangdep, progmois) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					//echo $query5;
					$dbresultat5 = $db->Execute($query5,array($now,$now,$mois_courant, $annee_courante, $licence2, $nom, $prenom, $point, $clnat, $rangreg, $rangdep, $progmois));
					//On vérifie que l'insertion se passe bien
					if(!$dbresultat5)
					{
						$designation = $db->ErrorMsg();
						//echo $db->ErrorMsg();
						$status = 'Ko computer';
						$action = 'mass_action';
						$ping_ops->ecrirejournal($now,$status, $designation,$action);

					}
					else
					{
						return $point;
					}
					
				}
				else
				{
					
					$add_sitMens = $ping_ops->add_sit_mens($licence2, $nom, $prenom, $categ, $point,$apoint,$clglob, $aclglob, $clnat, $rangreg, $rangdep, $progmoisplaces, $progmois, $progann,$valinit, $valcla, $saison);
				
						return  $point;
				}
				
				
			}
			
			
			
		}
	
	



  }
 	function retrieve_compets ($idorga,$type)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$ping_admin_ops = new ping_admin_ops();
		$db = cmsms()->GetDb(); 
		$now = trim($db->DBTimeStamp(time()), "'");
		$i=0;
		
		if($type == 'E')
		{
			$indivs = 0;
		}
		else
		{
			$indivs = 1;
		}
		$page = "xml_epreuve";
		//echo $page;
		$var = "organisme=".$idorga."&type=".$type;
		//echo $var;
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		//echo "le lien est : ".$lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			// Le service est coupé
			$array = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['epreuve']);
		}

		
		//on va tester si la variable est bien un tableau   
			if(!is_array($array) || $lignes == 0)  
			{

				$ping->SetMessage("Le service est coupé ou il n'y a pas encore de résultats");
				$ping->RedirectToAdminTab('epreuves');
			}

		///on initialise un compteur général $i
		
		//on initialise un deuxième compteur
		$compteur=0;
		foreach($xml as $cle =>$tab)
		{

			
			$idepreuve = (isset($tab->idepreuve)?"$tab->idepreuve":"");
			$idorga  = (isset($tab->idorga)?"$tab->idorga":"");
			$libelle = (isset($tab->libelle)?"$tab->libelle":"");			
			
			$tag = $ping_admin_ops->tag($idepreuve, $indivs);
			$epreuv = new EpreuvesIndivs;
			$message = $libelle.' Compétition ajoutée';
			$action = 'classe EpreuvesIndivs';
			$status = 'Ok';
			$add_compet = $epreuv->add_competition($libelle, $indivs,$idepreuve, $tag, $idorga);
			if(true === $add_compet)
			{
				$i++;
				$ping_admin_ops->ecrirejournal($status, $message,$action);
			}
						
		}// fin du foreach
		return $i;
	}
	

	

	function retrieve_poule_rencontres( $record_id,$iddiv,$idpoule,$idepreuve)
	{
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference('saison_en_cours');
		$service = new Servicen;
		
		$page = "xml_result_equ";
		$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//echo "la valeur de cal est :".$cal;
		
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['tour']);
		}
		

		$designation = '';

		if(!is_array($array))
		{ 
				//le tableau est vide, il faut envoyer un message pour le signaler
				$designation.= "le service est coupé";			
		}   
		else
		{
		$i=0;
			$eq_ops = new equipes_ping;
			$details = $eq_ops->details_equipe($record_id);
			$horaire = $details['horaire'];
			$libelle_equipe = $details['libequipe'];
			foreach($xml as $cle =>$tab)
			{

			
				$libelle = (isset($tab->libelle)?"$tab->libelle":"");
				//echo $libelle;
				$extraction = substr($libelle,-8);
				$date_extract = explode('/', $extraction);
				$annee_date = $date_extract[2] + 2000;
				$date_event = $annee_date."-".$date_extract[1]."-".$date_extract[0];
				
				
				//var_dump( $date_event);
				$equa = (isset($tab->equa)?"$tab->equa":"");
				$equb = (isset($tab->equb)?"$tab->equb":"");

				//on fait quelque transformations des infos recueillies
				preg_match_all('#[0-9]+#',$libelle,$extract);
				$tour = $extract[0][0];


				$uploaded = 0;
				
				$cluba = strpos($equa,$libelle_equipe);
				$clubb = strpos($equb,$libelle_equipe);
				$affichage = 0;
					if ($cluba !== false || $clubb !== false)
					{
						$club = 1;
						$affichage = 1;
					}
					else
					{
						$club = 0;
					}

				$scorea = (isset($tab->scorea)?"$tab->scorea":"");
				$scoreb = (isset($tab->scoreb)?"$tab->scoreb":"");
				$lien = (isset($tab->lien)?"$tab->lien":"");
				parse_str($lien, $output);
				//var_dump($output);
				$renc_id = $output['renc_id'];
				$equip_id1 = $output['equip_id1'];
				$equip_id2 = $output['equip_id2'];

				//
				//on vérifie que le score a bien été saisi
				//si le score est saisi on obtient un string pour les variables scorea et scoreb
				//sinon il s'agit d'un array	

					if(is_array($scorea) || $scorea =='')
					{
						//le score n'est pas parvenu ou le match n'a pas été joué
						//On l'enregistre qd même
						$scorea = 0;
								
					}
					if(is_array($scoreb) || $scoreb =='')
					{
						//le score n'est pas parvenu ou le match n'a pas été joué
						//On l'enregistre qd même
						
						$scoreb = 0;
								
					}
				
					//on récupère tout sans rien mettre à jour
					//on vérifie si l'enregistrement est déjà là
					$renc_exists = $eq_ops->renc_exists($renc_id);
					
					
					if( NULL != $renc_exists)
					{
						$add_result = $eq_ops->update_team_result($saison, $idpoule, $iddiv, $club, $affichage, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve, $horaire, $equip_id1, $equip_id2, $renc_id);
					}
					else
					{
						$add_result = $eq_ops->add_team_result($record_id,$renc_id,$saison,$idpoule, $iddiv, $club, $affichage, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve, $horaire, $equip_id1, $equip_id2);
					}
					if(true == $add_result)
					{
						$i++;
					}
					
					
			}//fin du foreach
			return $i;
			
        	}//fin du if is_array($result)
	}
	//fin de la fonction
	function retrieve_all_classements($record_id)
	{
		
		$db = cmsms()->GetDb();
		$designation = '';
		$ping = cms_utils::get_module('Ping'); 
		$service = new Servicen();
		$eq_ops = new equipes_ping;
		$details = $eq_ops->details_equipe($record_id);
		$j_ops = new ping_admin_ops;
		$eq = $details['libequipe'];
		if($details['friendlyname'] !='')
		{
			$eq = $details['friendlyname'];
		}
		
		
		$page = 'xml_result_equ';
		$var = "action=classement&auto=1&D1=".$details['iddiv']."&cx_poule=".$details['idpoule'];
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			$array = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['classement']);
		}
		
		//on vérifie que le resultat est bien un array

		//tt va bien, on continue
		//on supprime tt ce qui était ds la bdd pour cette poule
		if(!is_array($array))
		{
			$status = "Ko";
			$designation= "le service est coupé pour l'équipe ".$eq;
			$action = 'retrieve_classement';
			$j_ops->ecrirejournal($status,$designation,$action);
		}
		else
		{
			
	
			$del_class = $eq_ops->delete_classement($record_id);
			
			if(true == $del_class)
			{
				$i=0;//on initialise un compteur 
				//on récupère le résultat et on fait le foreach
				foreach($xml as $cle =>$tab)
				{
					$poule = (isset($tab->poule)?"$tab->poule":"");
					$clt = (isset($tab->clt)?"$tab->clt":"");
					$equipe = (isset($tab->equipe)?"$tab->equipe":"");
					$num_equipe = (isset($tab->idequipe)?"$tab->idequipe":"");
					$joue = (isset($tab->joue)?"$tab->joue":"");
					$pts = (isset($tab->pts)?"$tab->pts":"");
					$totvic = (isset($tab->totvic)?"$tab->totvic":"");
					$totdef = (isset($tab->totdef)?"$tab->totdef":"");
					$numero = (isset($tab->numero)?"$tab->numero":"");
					$idclub = (isset($tab->idclub)?"$tab->idclub":"");
					$vic = (isset($tab->vic)?"$tab->vic":"");
					$def = (isset($tab->def)?"$tab->def":"");
					$nul = (isset($tab->nul)?"$tab->nul":"");
					$pf = (isset($tab->pf)?"$tab->pf":"");
					$pg = (isset($tab->pg)?"$tab->pg":"");
					$pp = (isset($tab->pp)?"$tab->pp":"");
					
					if($numero == $ping->GetPreference('club_number'))
					{
						$maj_idequipe = $eq_ops->maj_idequipe($record_id, $idequipe);
					}
					$add_clas = $eq_ops->add_classement($record_id, $details['saison'], $details['iddiv'], $details['idpoule'], $poule, $clt, $equipe, $joue, $pts, $totvic, $totdef, $numero, $idclub, $vic, $def, $nul, $pf, $pg, $pp, $num_equipe);
					$maj_class_equipe = $eq_ops->maj_class($record_id);
					
				}
			
			
			}
			$designation.= $eq.": Récup classement Ok";
			$status = "Ok";
			
			
		}
		$action = 'getPouleclassement';
		$j_ops->ecrirejournal($status,$designation,$action);
	}
	
	function insert_cgcalendar ($name,$tag,$date_debut,$date_fin)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		//on vérifie d'abord que l'événement n'est pas déjà ds la base
		$query = "SELECT event_title, event_date_start FROM ".cms_db_prefix()."module_cgcalendar_events WHERE event_title = ? AND event_date_start = ? AND event_date_end = ?";
		$dbresult = $db->Execute($query, array($name, $date_debut, $date_fin ));
		if($dbresult && $dbresult->RecordCount() == 0)
			{
				// on récupère id ds différentes tables
				//Tout d'abord celui de la table events
				$query1 = "SELECT id FROM ".cms_db_prefix()."module_cgcalendar_events_seq";
				$dbresult1 = $db->Execute($query1);
				$row = $dbresult1->FetchRow();
				$id_event = $row['id']+1;
				//on met le statut à Publié 
				$event_status = 'P';
				$query_cal = "INSERT INTO ".cms_db_prefix()."module_cgcalendar_events
				           (event_id, event_title, event_details, event_date_start, event_date_end, event_status)
				            VALUES (?, ?, ? , ?, ?, ?)";
				$dbresult_cal = $db->Execute($query_cal, array($id_event,$name,$tag,$date_debut,$date_fin, $event_status));
				//on insère aussi l'événement dans une categorie par défaut la générale donc 1
				$cat = 1;
				$query_cat = "INSERT INTO ".cms_db_prefix()."module_cgcalendar_events_to_categories (category_id, event_id) VALUES (?,?)";
				$dbresult_cat = $db->Execute($query_cat, array($cat,$id_event));
				//on modifie le events_seq
				$query = "UPDATE ".cms_db_prefix()."module_cgcalendar_events_seq SET id = id+1";
				$dbresult = $db->Execute($query);
			}
	}
	function retrieve_users()
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$club_number = $ping->GetPreference('club_number');
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_licence_b";
		$service = new Servicen;
		//paramètres nécessaires 
		$var="club=".$club_number;
		$lien = $service->GetLink($page,$var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		if($xml === FALSE)
		{
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['licence']);
		}
		//echo "le nb de lignes est : ".$lignes;
		if($lignes == 0)
		{
			$message = "Pas de lignes à récupérer !";
		//	$this->SetMessage("$message");
			//$this->RedirectToAdminTab('joueurs');
		}
		else
		{
			$joueurs =  new joueurs;//on supprime l'existant ? Oui.
			$spid_ops = new spid_ops;
			$query = "DELETE FROM ".cms_db_prefix()."module_ping_joueurs";
			$dbresult = $db->Execute($query);

			foreach($xml as $tab)
			{
				//$licence = (isset($tab->licence)?"$tab->licence":"");
				//on supprime le joueur pour l'inclure à nouveau
			
				$idlicence = (isset($tab->idlicence)?"$tab->idlicence":"");						
				$nom = (isset( $tab->nom)?"$tab->nom":"");
				$prenom = (isset($tab->prenom)?"$tab->prenom": "");
				$licence = (isset($tab->licence)?"$tab->licence":"");
				$numclub = (isset($tab->numclub)?"$tab->numclub":"");
				$nomclub = (isset($tab->nomclub)?"$tab->nomclub":"");
				$actif = 1;
				$sexe = (!empty($tab->sexe)?"$tab->sexe":"");
				$type = (!empty($tab->type)?"$tab->type" :"");
				if($type =='')
				{
					$actif = 0;
				}
				$certif = (!empty($tab->certif)?"$tab->certif":"");
				$validation = (!empty($tab->validation)?"$tab->validation":"");
				//on met la date au format MySQL
				$day = (int) substr($validation, 0,2);
				$month = (int) substr($validation, 3, 2);
				$year = (int) substr($validation, 6, 2);
				
				$valid = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year) );
			/*	
				$mutation = (isset($tab->mutation)?"$tab->mutation":"");
				$natio = (isset($tab->natio)?"$tab->natio":"");
				$arb = (isset($tab->arb)?"$tab->arb":"");;
				$ja = (isset($tab->ja)?"$tab->ja":"");;
				$tech = (isset($tab->tech)?"$tab->tech":"");
			*/	
			//	$echelon = (!empty($tab->echelon)?"$tab->echelon":"");
			//	$place = (int) (!empty($tab->place)?"$tab->place":"");
				$clast = (!empty($tab->point)?"$tab->point":"");
				$cat = (!empty($tab->cat)?"$tab->cat":"");
				
				$add_joueur = $joueurs->add_joueur($licence,$nom, $prenom,$actif, $sexe, $type, $certif, $valid, $cat,$clast);//,$mutation,$natio,$arb,$ja,$tech);
				
				if(true == $add_joueur)
				{
					if($type == 'T')
					{						
							$spid_ops->create_spid_account($licence);
					}
				}
			
			}// fin du foreach

	
		}
	}//fin de la fonction
	function retrieve_users_fftt()
	{
		global $gCms;
		$adherents = new adherents();
		$ping = cms_utils::get_module('Ping');
		$saison = $ping->GetPreference ('saison_en_cours');
		$ping_ops = new ping_admin_ops();
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$aujourdhui = date('Y-m-d');
		$club_number = $adherents->GetPreference('club_number');
		//echo $club_number;
		
		
			$page = "xml_liste_joueur";
			$service = new Servicen();
			//paramètres nécessaires 
			
			$var = "club=".$club_number;
			$lien = $service->GetLink($page,$var);
			//echo $lien;
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//	var_dump($xml);
			
			if($xml === FALSE)
			{
				$array = 0;
				$lignes = 0;
				return FALSE;
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				$lignes = count($array['joueur']);
			}
			//echo "le nb de lignes est : ".$lignes;
			if($lignes == 0)
			{
				$message = "Pas de lignes à récupérer !";
				//$this->SetMessage("$message");
				//$this->RedirectToAdminTab('joueurs');
			}
			else
			{
				//on supprime tt
				$query = "TRUNCATE TABLE ".cms_db_prefix()."module_ping_joueurs";
				$dbresult = $db->Execute($query);
				if($dbresult)
				{
					$i =0;//compteur pour les nouvelles inclusions
					$a = 0;//compteur pour les mises à jour
					$joueurs_ops = new ping_admin_ops();
					foreach($xml as $tab)
					{
						$licence = (isset($tab->licence)?"$tab->licence":"");
						$nom = (isset($tab->nom)?"$tab->nom":"");
						$prenom = (isset($tab->prenom)?"$tab->prenom":"");
						$club = (isset($tab->club)?"$tab->club":"");
						$nclub = (isset($tab->nclub)?"$tab->nclub":"");
						$clast = (isset($tab->clast)?"$tab->clast":"");
						$actif = 1;

						$insert = $joueurs_ops->add_joueur($actif, $licence, $nom, $prenom, $club, $nclub, $clast);
						$player_exists = $joueurs_ops->player_exists($licence);
					//	var_dump($player_exists);
						if($insert === TRUE && $player_exists === FALSE)
						{
							$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (saison, datemaj, licence, sit_mens, fftt, maj_fftt, spid, maj_spid) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
							$dbresult = $db->Execute($query, array($saison,$aujourdhui,$licence,'Janvier 2000', '0', '1970-01-01', '0', '1970-01-01'));
							
						}//$a++;
					 	

					}// fin du foreach
					
				}
				
			}
			//on redirige sur l'onglet joueurs
			
		
		
		
	}//fin de la fonction
	function advlicence ($nom,$prenom="")
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		//echo "le nom est : ".$nom;
		//echo "<br /> le prénom est : ".$prenom;
		$nom_final = str_replace(' ','%20',$nom);
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_liste_joueur";
		$var ="nom=".$nom_final."&prenom=".$prenom;
		$lignes = 0;
		
		//	$var.="&action=poule";

		
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		//echo "<br />".$lien."<br />";
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['joueur']);
		}
		//echo "le nb de lignes est : ".$lignes;
		$i = 0;
		
		if($lignes == 1 )//&& $lignes <2)//un seul joueur
		{
			foreach($xml as $tab)
			{
				$licence = (isset($tab->licence)?"$tab->licence":"");
				//echo "la licence est : <br />".$licence;
				$nom = (isset($tab->nom)?"$tab->nom":"");
				$prenom = (isset($tab->prenom)?"$tab->prenom":"");
				$club = (isset($tab->club)?"$tab->club":"");
				$nclub = (isset($tab->classement)?"$tab->classement":"");
				$clast = (isset($tab->clast)?"$tab->clast":"");
				
				
			}
			return $licence;
		}
		else
		{
			return FALSE;
		}
			
	}
	
	function retrieve_teams ($type)
	{
		global $gCms;
		//$adherents = new adherents();
		$ping = cms_utils::get_module('Ping');
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$club_number = $ping->GetPreference('club_number');
		$i=0;
		//echo $club_number;
		$saison= $ping->GetPreference('saison_en_cours');
		$service = new Servicen();
		$ping_ops = new ping_admin_ops;
		
			$page = "xml_equipe";
			$var = "numclu=".$club_number;

				if (isset($type) && $type == 'U')
				{
					//$result = $service->getEquipesByClub("$club_number");

					$chpt = "A"; //pour autres championnat
					$type_compet = 'U';//pour undefined
					$var.="";
				}
				elseif($type =='M')
				{

					$type_compet = '1';
					$var.="&type=M";
				}
				elseif($type == 'F')
				{
					$var.="&type=F";
					$type_compet = '1';

				}
				$lien = $service->GetLink($page,$var);
				$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
				var_dump($xml);
				
				if($xml === FALSE)// || strlen($xml) <=1)
				{
					
					//$this->SetMessage("Le service est coupé");
					echo "une erreur est apparue ou déjà en bdd";
					$status = 'Echec';
					$designation='Pas d\'équipes à télécharger !';
					$action = "retrieve_teams";
					$message = $ping->ecrirejournal($now,$status, $designation,$action);
					
				}
				else
				{
					$array = json_decode(json_encode((array)$xml), TRUE);
					
						
						//on initialise un deuxième compteur
						$compteur = 0;
						foreach($xml as $cle =>$tab)
						{

							$i++;
							$libequipe = (isset($tab->libequipe)?"$tab->libequipe":"");
							$idepreuve = (isset($tab->idepr)?"$tab->idepr":"");
							//on modifie le libellé des équipes pour extraire la phase
							$newphase = explode ("-",$libequipe);
							//echo "la phase est ".$newphase[1];
							$phase = substr($newphase[1], -1);
							$new_equipe = trim(html_entity_decode($newphase[0]));
							//echo "la phase est ".$phase;
							$numero_equipe = preg_replace('#[^0-9]#','',$new_equipe);
							$libdivision = (isset($tab->libdivision)?"$tab->libdivision":"");
							$liendivision = (isset($tab->liendivision)?"$tab->liendivision":"");
							$tableau = parse_str($liendivision, $output);
							//echo $tableau;
							$idpoule = $output['cx_poule'];
							$iddiv = $output['D1'];
							$idorga = $output['organisme_pere'];

							//on crée un tag à la volée
							
							$query2 = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_equipes (saison, phase,numero_equipe, libequipe, libdivision, liendivision, idpoule, iddiv, type_compet, idepreuve) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query2;
							$compteur++;
							$dbresultat = $db->Execute($query2,array($saison, $phase, $numero_equipe,$new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet,$idepreuve));

							if(!$dbresultat)
							{
								$designation = $db->ErrorMsg();		
							}
							else
							{
								//on inclut le tag
								$insert_id = $db->Insert_ID();
								$tag = $ping_ops->tag_equipe($insert_id);
								$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET tag = ? WHERE id = ?";
								$dbresult = $db->Execute($query, array($tag, $insert_id));
								
							}

								
									echo "une erreur est apparue ou déjà en bdd";
					


						}// fin du foreach
						
				}
			return $i;
			
		
	}//fin de la fonction
	
	//pour les organismes
	function organismes()
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$designation = '';
		$tableau = array('F','Z','L','D');
		//on instancie la classe servicen
		$service = new Servicen();
		$page = "xml_organisme";
		foreach($tableau as $valeur)
		{
			$var = "type=".$valeur;
			//echo $var;
			$scope = $valeur;
			//echo "la valeur est : ".$valeur;
			$lien = $service->GetLink($page,$var);
			//echo $lien;
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($xml === FALSE)
			{
				$designation.= "service coupé";
				$now = trim($db->DBTimeStamp(time()), "'");
				$status = 'Echec';
				$action = 'retrieve_ops';
				ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				///on initialise un compteur général $i
				$i=0;
				//on initialise un deuxième compteur
				$compteur=0;
			//	var_dump($xml);

					foreach($xml as $cle =>$tab)
					{

						$i++;
						$idorga = (isset($tab->id)?"$tab->id":"");
						$code  = (isset($tab->code)?"$tab->code":"");
						$libelle = (isset($tab->libelle)?"$tab->libelle":"");
						// 1- on vérifie si cette épreuve est déjà dans la base
						$query = "SELECT idorga FROM ".cms_db_prefix()."module_ping_organismes WHERE idorga = ?";
						$dbresult = $db->Execute($query, array($idorga));

							if($dbresult  && $dbresult->RecordCount() == 0) 
							{
								$query = "INSERT INTO ".cms_db_prefix()."module_ping_organismes (libelle, idorga, code, scope) VALUES (?, ?, ?, ?)";
								//echo $query;
								$compteur++;
								$dbresultat = $db->Execute($query,array($libelle,$idorga,$code,$scope));

								if(!$dbresultat)
								{
									$designation.= $db->ErrorMsg();			
								}

							}
							


					}// fin du foreach

			}
			unset($scope);
			unset($var);
			unset($lien);
			unset($xml);
			sleep(1);
		}//fin du premier foreach
		

		$designation.= $compteur." organisme(s) récupéré(s)";
		$now = trim($db->DBTimeStamp(time()), "'");
		$status = 'Ok';
		$action = 'retrieve_ops';
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);

			
		
	}//fin de la fct pour les organismes
	
	
	
	function retrieve_detail_club($club_number)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$service = new Servicen;
		$page = "xml_club_detail";
		$var = "club=".$club_number;
		$lien = $service->GetLink($page,$var);
		//echo $lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		
		if($xml === FALSE)
		{
			$designation.= "service coupé";
			$now = trim($db->DBTimeStamp(time()), "'");
			$status = 'Echec';
			$action = 'retrieve_ops';
			ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			///on initialise un compteur général $i
			$i=0;
			//on initialise un deuxième compteur
			$compteur=0;

				foreach($xml as $cle =>$tab)
				{
					$idclub = (isset($tab->idclub)?"$tab->idclub":"");
					$numero  = (isset($tab->numero)?"$tab->numero":"");
					$nom = (isset($tab->nom)?"$tab->nom":"");
					$nomsalle = (isset($tab->nomsalle)?"$tab->nomsalle":"");
					$adressesalle1 = (isset($tab->adressesalle1)?"$tab->adressesalle1":"");
					$adressesalle2 = (isset($tab->adressesalle2)?"$tab->adressesalle2":"");
					$codepsalle = (isset($tab->codepsalle)?"$tab->codepsalle":"");
					$villesalle = (isset($tab->villesalle)?"$tab->villesalle":"");
					$web = (isset($tab->web)?"$tab->web":"");
					$nomcor = (isset($tab->nomcor)?"$tab->nomcor":"");
					$prenomcor = (isset($tab->prenomcor)?"$tab->prenomcor":"");
					$mailcor = (isset($tab->mailcor)?"$tab->mailcor":"");
					$telcor = (isset($tab->telcor)?"$tab->telcor":"");
					$lat = (!empty($tab->latitude)?"$tab->latitude":"0.00");
					
					$lng = (!empty($tab->longitude)?"$tab->longitude":"0.00");
				}
				
				$add_coordonnees = $this->add_coordonnees($idclub, $numero, $nom, $nomsalle, $adressesalle1, $adressesalle2, $codepsalle, $villesalle, $web, $nomcor, $prenomcor, $mailcor, $telcor, $lat, $lng);
		
		}
	}
	
	function calendrier( $iddiv,$idpoule,$idepreuve,$libequipe)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		//echo "la valeur de cal est :".$cal;
		
		$ping = cms_utils::get_module('Ping');
		//require_once(dirname(__FILE__).'/function.calculs.php');
		//echo "glop2";	
		$aujourdhui = date('Ymd');
		$aujourdhui = new DateTime( $aujourdhui );
		$aujourdhui = $aujourdhui->format('Ymd');
		//var_dump($aujourdhui);
		$saison = $ping->GetPreference('saison_en_cours');
		$service = new Servicen();
		$page = "xml_result_equ";
		$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//echo "la valeur de cal est :".$cal;
		var_dump($xml);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['tour']);
		}
	

		$designation = '';
		
		if(!is_array($array))
		{ 

				//le tableau est vide, il faut envoyer un message pour le signaler
				$designation.= "le service est coupé";
		}   
		else
		{
		$i=0;
			foreach($xml as $cle =>$tab)
			{

				
				$libelle = (isset($tab->libelle)?"$tab->libelle":"");
				$extraction = substr($libelle,-8);
				$date_extract = explode('/', $extraction);
				$annee_date = $date_extract[2] + 2000;
				$date_event = $annee_date."-".$date_extract[1]."-".$date_extract[0];				
				$equa = (isset($tab->equa)?"$tab->equa":"");
				$equb = (isset($tab->equb)?"$tab->equb":"");

				//on fait quelque transformations des infos recueillies
				preg_match_all('#[0-9]+#',$libelle,$extract);
				$tour = $extract[0][0];
				$uploaded = 0;
			
				preg_match_all("/$libequipe/",$equa,$compa);
				preg_match_all("/$libequipe/",$equb,$compb);
		
				if((true === is_array($compa[0]) && count($compa[0]) > 0) || (true === is_array($compb[0]) && count($compb[0]) > 0))
				{
					$club = 1;
					$affichage = 1;
				}
				else
				{
					$club = 0;
				}
		
				$scorea = (int)(isset($tab->scorea)?"$tab->scorea":"");
				$scoreb = (int)(isset($tab->scoreb)?"$tab->scoreb":"");
				$lien = (isset($tab->lien)?"$tab->lien":"");
				$renc_prep = explode('&',$lien);
				$renc_id_prep = explode('=',$renc_prep['4']);
				$renc_id = $renc_id_prep['1'];

				//
				//on vérifie que le score a bien été saisi
				//si le score est saisi on obtient un string pour les variables scorea et scoreb
				//sinon il s'agit d'un array	

					if(is_array($scorea) && is_array($scoreb))
					{
						//le score n'est pas parvenu ou le match n'a pas été joué
						//On l'enregistre qd même
						$scorea = 0;
						$scoreb = 0;
						$update = 0;		
					}				
				
			
					//on récupère tout sans rien mettre à jour
					//on vérifie si l'enregistrement est déjà là
					$query = "SELECT id,lien, scorea, scoreb, renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";
					$dbresult = $db->Execute($query, array($renc_id));

					//il n'y a pas d'enregistrement auparavant, on peut continuer
						
						if($dbresult->RecordCount() == 0) 
						{
							$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (renc_id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien, idepreuve) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query1,array($renc_id,$saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve));

								if(!$dbresultat)
								{
									$designation.= $db->ErrorMsg();


								}
								
								
								//on prépare le tag
							$indivs = 0;//puisqu'on est dans un contexte d'équipes
							$tag = "{Ping action='par-equipes'";
							$tag.=" idepreuve='$idepreuve'";

								if(isset($date_event) && $date_event !='')
								{
									$tag.= " date_debut='$date_event'";
								}
								if(isset($date_event) && $date_event !='')
								{
									$tag.= " date_fin='$date_event'";
								}
							$tag.="}";
							//On fait l'inclusion ds la bdd
							// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
						
								// on insert aussi dans CGCalendar ?
								// Chiche !
								$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
								$dbresult = $db->Execute($query, array($idepreuve));
								$row = $dbresult->FetchRow();
								$name = $row['name'];
								
							//	retrieve_ops::insert_cgcalendar($name,$tag,$date_event,$date_event);
						}
						elseif($dbresult->RecordCount() > 0)
						{
								//il y a déjà un enregistrement, le score est-il à jour ?
								$row = $dbresult->FetchRow();
								$scoA = $row['scorea'];
								$scoB = $row['scoreb'];
								$update = 1;
								

									if($scoA == 0 && $scoB == 0)
									{
										$query5 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE renc_id = ?";
										$dbresultA = $db->Execute($query5, array($scorea, $scoreb, $renc_id));
										$i++;
										if(!$dbresultA)
										{
											$designation.= $db->ErrorMsg();
										}
									}
									else
									{
									//	echo "rien à mettre à jour !";
									}
						}
							

			}//fin du foreach	
				
        	}//fin du if is_array($result)
	}//fin de la fonction
	//récupère la feuille de rencontre et l'ordre des parties
    function rencontre_details($renc_id)
    {
    	$db = cmsms()->GetDb();
    	$service = new Servicen();
    	$ren_ops = new rencontres;
    	$details = $ren_ops->details_rencontre($renc_id);
    	$link = $details['lien'];
		$page = "xml_chp_renc";
		$var = $link;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
			//$this->RedirectToAdminTab('poules');
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['resultat']);
			$array['joueur'] = array();
			$lignes_joueurs = count($array['joueur']);
		}
		//echo "le nb de joueurs est : ".$lignes_joueurs;
		//$result = $service->getRencontre("$lien");

		//var_dump($xml);//print_r($result);

			if(!is_array($array) || $lignes == 0 || $lignes_joueurs == 0)
			{ 

				//le tableau est vide, il faut envoyer un message pour le signaler
				//$designation.= "Les résultats ne sont pas encore disponibles";
				//$this->SetMessage("$designation");
				//$this->RedirectToAdminTab('poules');
			}   
			else
			{
			//on essaie de faire qqs calculs
			$tableau1 = array();
			$tab2 = array();
			$compteur = count($array['joueur']);
			$compteur_parties = count($array['partie']);

			//on scinde le tableau principal en plusieurs tableaux ?
			$tab1 = array_slice($array,0,1);
			$tab2 = array_slice($array,1,1);
			$tab3 = array_slice($array,2,1);
			//print_r($tab1);
			//print_r($tab2);
			//print_r($tab3);
			//echo "le compteur est : ".$compteur;
			//echo "le nb de parties disputées est : ".$comptage;
				$i=0;
				$a=0;

					for($i=0;$i<$compteur;$i++)
					{
						//la feuille de rencontre...
						$xja = 'xja'.$i;//ex : $xja = 'xja0';
						$xca = 'xca'.$i; //on met aussi le classement du joueurex : xca0, xca1,xca2, etc...
						$xjb = 'xjb'.$i;//ex : $xja = 'xja0';
						$xcb = 'xcb'.$i;
						$$xja = $tab2['joueur'][$i]['xja'];//ex : $xja0 = '';
						$$xca = $tab2['joueur'][$i]['xca'];
						$$xjb = $tab2['joueur'][$i]['xjb'];//ex : $xja0 = '';
						$$xcb = $tab2['joueur'][$i]['xcb'];
						//on insère le tout dans la bdd
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_feuilles_rencontres ( fk_id, xja, xca, xjb, xcb) VALUES ( ?, ?, ?, ?, ?)";
						$dbresult3 = $db->Execute($query3, array($renc_id, $$xja,$$xca,$$xjb,$$xcb));
					}
					for($i=0;$i<$compteur_parties;$i++)
					{


						//on s'occupe maintenant des parties
						$ja = 'ja'.$i;
						$scorea = 'scoreA'.$i;
						$jb = 'jb'.$i;
						$scoreb = 'scoreB'.$i;
						$$ja = $tab3['partie'][$i]['ja'];
						$$scorea = $tab3['partie'][$i]['scorea'];
						$$jb = $tab3['partie'][$i]['jb'];
						$$scoreb = $tab3['partie'][$i]['scoreb'];
						//on insère aussi dans la bdd
						if($$scorea == '-')
						{
							$$scorea = 0;
						}
						if($$scoreb == '-')
						{
							$$scoreb = 0;
						}
						$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_rencontres_parties ( fk_id, joueurA, scoreA, joueurB, scoreB) VALUES ( ?, ?, ?, ?, ?)";
						$dbresult4 = $db->Execute($query4, array($renc_id, $$ja,$$scorea, $$jb, $$scoreb));

					
					}

			}
					
    }	
	//ajoute les coordonnées de la salle et du correspondant
	function add_coordonnees($idclub, $numero, $nom, $nomsalle, $adressesalle1, $adressesalle2, $codepsalle, $villesalle, $web, $nomcor, $prenomcor, $mailcor, $telcor, $lat, $lng)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_coordonnees(idclub, numero, nom, nomsalle, adressesalle1, adressesalle2, codepsalle, villesalle, web, nomcor, prenomcor, mailcor, telcor, lat, lng)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($idclub, $numero, $nom, $nomsalle, $adressesalle1, $adressesalle2, $codepsalle, $villesalle, $web, $nomcor, $prenomcor, $mailcor, $telcor, $lat, $lng));
	}
} // end of class

#
# EOF
#
?>
