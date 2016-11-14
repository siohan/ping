<?php
#################################################################
#                      Script CRON                             ##
#          Récupération des résulats des équipes               ##
#################################################################


$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');
$message = '';
$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message.= "Connection impossible";
echo $message;
    
}

//$now = trim($link->DBTimeStamp(time()), "'");

//on fait un tableau qui récapitule toutes les possibilités (F, Z etc...)
//on récupère les préférences...
$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours","Ping_mapi_pref_ligue", "Ping_mapi_pref_zone","Ping_mapi_pref_dep","Ping_mapi_pref_nom_equipes");
foreach($tab as $value)
{
	

	$query = "SELECT sitepref_value FROM ".$config['db_prefix']."siteprefs WHERE sitepref_name LIKE '".$value."'";
	//echo $query;
	$result = $link->query($query); 
	//var_dump($result);
	if($result)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
        		$$value = $row['sitepref_value'];
			//var_dump($row);
			//echo $$value."<br/>";
    		}
	}

}
$iddiv = "";
$idpoule = "";
$idepreuve = "";
$error = 0; //on instancie le compteur d'erreurs
$designation= '';


	
	$i = 0; //on insère un compteur pour les boucles
	//on récupère tts les iddivisions et idepreuve disponible en bdd.
	//$query = "SELECT DISTINCT idepreuve, iddiv, idpoule FROM ".$config['db_prefix']."module_ping_equipes WHERE saison LIKE '".$Ping_mapi_pref_saison_en_cours."' AND phase = '".$Ping_mapi_pref_phase_en_cours."'";
	$query = "SELECT DISTINCT idepreuve, iddiv, idpoule FROM ".$config['db_prefix']."module_ping_type_rencontres WHERE saison LIKE '".$Ping_mapi_pref_saison_en_cours."' ";
	//echo $query." <br />";
	$dbresult = $link->query($query);

	$row_cnt = mysqli_num_rows($dbresult);
	//echo "<br />le nb de résultats est : ".$row_cnt;
	
	if($dbresult && $row_cnt >0)
	{
		while ($row = mysqli_fetch_assoc($dbresult)) 
		{
			$idepreuve = $row['idepreuve'];
			$iddiv = $row['iddiv'];
			$idpoule = $row['idpoule'];
			
			$page = "xml_result_equ";
			$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
			$tm = substr(date('YmdHisu'),0,17);//le timestamp
			$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
			$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
			//echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
			$lien =  file_get_contents($chaine);
			//echo "le lien est : ".$lien;
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
			
			
			//var_dump($xml);
			/**/
			//on va tester la valeur de la variable $result
			//cela permet d'éviter de boucler s'il n'y a rien dans le tableau

			if(!is_array($array))
			{ 

					//le tableau est vide, il faut envoyer un message pour le signaler
					//echo "le service est coupé";
				
			}   
			else
			{
				//echo "le service fonctionne ! <br/>";
			$i=0;
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
					$nom_equipes = $Ping_mapi_pref_nom_equipes;//ping->GetPreference('nom_equipes');
					$cluba = strpos($equa,$nom_equipes);
					$clubb = strpos($equb,$nom_equipes);

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
							//on arrete là on passe au suivant
							//echo "match non joué ou résultat non parvenu";		
						}
						else
						{
							//on récupère tout sans rien mettre à jour
							//on vérifie si l'enregistrement est déjà là
							$query1 = "SELECT id,lien, scorea, scoreb FROM ".$config['db_prefix']."module_ping_poules_rencontres WHERE iddiv = '".$iddiv."' AND idpoule = '".$idpoule."' AND date_event = '".$date_event."' AND equa = '".$equa."' AND equb = '".$equb."'";
							//echo $query1;
							$dbresult1 = $link->query($query1);
							$row_cnt1 = mysqli_num_rows($dbresult1);
							//echo "<br /> le nb de résultats est : ".$row_cnt1."<br />";
							//il n'y a pas d'enregistrement auparavant, on peut continuer

								if($row_cnt1 == 0) 
								{
									$query2 = "INSERT INTO ".$config['db_prefix']."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', '".$Ping_mapi_pref_saison_en_cours."','".$idpoule."', '".$iddiv."', '".$club."', '".$tour."', '".$date_event."', '".$uploaded."', '".$libelle."', '".$equa."', '".$equb."', '".$scorea."', '".$scoreb."', '".$lien."')";
									//echo $query2;
									$i++;
									$uploaded = 0;
									$dbresultat = $link->query($query2);

										if(!$dbresultat)
										{
											$designation.= mysqli_error($link);
											//echo $designation;


										}

										//on prépare le tag
									$indivs = 0;//puisqu'on est dans un contexte d'équipes
									$tag = "{Ping action=\'par-equipes\'";
									$tag.=" idepreuve=\'$idepreuve\'";

										if(isset($date_event) && $date_event !='')
										{
											$tag.= " date_debut=\'".$date_event."\'";
										}
										if(isset($date_event) && $date_event !='')
										{
											$tag.= " date_fin=\'".$date_event."\'";
										}
									$tag.="}";
									//On fait l'inclusion ds la bdd
									// on vérifie d'abord que l'enregistrement n'est pas déjà en bdd
									$query2 = "SELECT numjourn, date_debut, date_fin, idepreuve FROM ".$config['db_prefix']."module_ping_calendrier WHERE  numjourn = '".$tour."' AND date_debut = '".$date_event."' AND date_fin = '".$date_event."'  AND idepreuve = '".$idepreuve."'";//AND scorea !=0 AND scoreb !=0";
									$dbresult2 = $link->query($query2);
									$row_cnt2 = mysqli_num_rows($dbresult2);

										if ($row_cnt2 ==0)
										{



												$query3 = "INSERT INTO ".$config['db_prefix']."module_ping_calendrier (id,date_debut,date_fin,idepreuve, numjourn,tag,saison) VALUES ( '', '".$date_event."','".$date_event."','".$idepreuve."','".$tour."','".$tag."','".$saison."')";
												$dbresult3 = $link->query($query3);
												if($dbresult3)
												{
													$designation.= $db->ErrorMsg();
												}
												// on insert aussi dans CGCalendar ?
												// Chiche !
												$query4 = "SELECT * FROM ".$config['db_prefix']."module_ping_type_competitions WHERE idepreuve = '".$idepreuve."'";
												$dbresult4 = $link->query($query4);
												$row = mysqli_fetch_assoc($dbresult4);
												$name = $row['name'];
												// on récupère id ds différentes tables
												//Tout d'abord celui de la table events
												$query1 = "SELECT id FROM ".$config['db_prefix']."module_cgcalendar_events_seq";
												$dbresult1 = $link->query($query1);
												$row = mysqli_fetch_assoc($dbresult1);

												$id_event = $row['id']+1;
												$query_cal = "INSERT INTO ".$config['db_prefix']."module_cgcalendar_events (event_id, event_title, event_details, event_date_start, event_date_end)
												            VALUES ('".$id_event."','".$name."','".$tag."','".$date_event."','".$date_event."')";
												$dbresult_cal = $link->Execute($query_cal);
												//on insère aussi l'événement dans une categorie par défaut la générale donc 1
												$cat = 1;
												$query_cat = "INSERT INTO ".$config['db_prefix']."module_cgcalendar_events_to_categories (category_id, event_id) VALUES ('".$cat."','".$id_event."')";
												$dbresult_cat = $link->query($query_cat);
												//on modifie le events_seq
												$query = "UPDATE ".$config['db_prefix']."module_cgcalendar_events_seq SET id = id+1";
												$dbresult = $link->query($query);
												//unset($id_event);

										}
										else
										{
											//echo "<br />La date existe déjà dans la table calendrier du module ! ";
										}
								}//fin du if $row_cnt1
								sleep(1);
							}//fin du else is_array
						}


				
					
						



					
			
			
			
				}//fin du foreach
				$message.=$i." rencontres insérées";
			}//fin du else
		}//fin du while
		sleep(1);
	}
	else
	{
		//pas de résultats ou un pb
		//la requete n'est pas bonne ?
		$message.= mysqli_error($link);
		echo $message;
	}
//on envoie le tout par mail ?
$message = wordwrap($message, 70, "\r\n");
// Envoi du mail
mail('claude.siohan@gmail.com', '[Cron] rencontres', $message);
#
# EOF
#
?>