<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class retrieve_ops
{
  function __construct() {}


##
##
public function retrieve_parties_spid2( $licence)//, $player,$cat )
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
	$compteur = 0;
	
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
			$designation.= "Situation mensuelle manquante";
			$action = "mass_action";
			$status = 'Echec';
			$ping_ops->ecrirejournal($status, $designation,$action);
			
		}
		else
		{
			
			$service = new Servicen;

			$page = "xml_partie";
			$var = "numlic=".$licence;
			$lien = $service->GetLink($page, $var);
			//echo "<a href=".$lien.">".$lien."</a>";
			$xml   = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			var_dump($xml);
		}	
					
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

  }//fin de la fonction

//la fonction ci-dessous récupère la situation mensuelle d'un joueur
public function retrieve_sit_mens($licence, $ext="")
  {
	//on vérifie si la situation mensuelle a déjà été prise en compte
	global $gCms;
		
	$service = new Servicen();
	$page = "xml_joueur";
	$var = "licence=".$licence;
	$lien = $service->GetLink($page, $var);
	$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
	var_dump($xml);
  }
 	function retrieve_compets ($idorga,$type)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$saison = $ping->GetPreference('saison_en_cours');
		$ping_admin_ops = new ping_admin_ops();
		$curl = curl_init();
		//curl_setopt($curl,CURLOPT_URL, $url);
		$db = cmsms()->GetDb(); 
		$now = trim($db->DBTimeStamp(time()), "'");
		$i=0;
		
		
		$page = "xml_epreuve";		
		$var = "organisme=".$idorga."&type=".$type;
		
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);

		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
	}
	

	

	function retrieve_poule_rencontres( $eq_id,$iddiv,$idpoule,$idepreuve)
	{
		$db = cmsms()->GetDb();
		$service = new Servicen;		
		$page = "xml_result_equ";
		$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		
	}
	//fin de la fonction
	function retrieve_all_classements($record_id)
	{
		
		$db = cmsms()->GetDb();
		$ping = cms_utils::get_module('Ping'); 
		$service = new Servicen();
		$eq_ops = new equipes_ping;
		$details = $eq_ops->details_equipe($record_id);
		$j_ops = new ping_admin_ops;
		$eq = $details['libequipe'];
		$page = 'xml_result_equ';
		$var = "action=classement&auto=1&D1=".$details['iddiv']."&cx_poule=".$details['idpoule'];
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		
	}
	
	
	function retrieve_users()
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$club_number = $ping->GetPreference('club_number');
		$page = "xml_licence_b";
		$service = new Servicen;
		//paramètres nécessaires 
		$var="club=".$club_number;
		$lien = $service->GetLink($page,$var);
		
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
	}//fin de la fonction
	
	
	function retrieve_users_fftt()
	{
		global $gCms;
		
		$ping = cms_utils::get_module('Ping');		
		$db = cmsms()->GetDb();		
		$club_number = $ping->GetPreference('club_number');
		$page = "xml_liste_joueur";
		$service = new Servicen();			
		$var = "club=".$club_number;
		$lien = $service->GetLink($page,$var);
		//echo $lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);		
	}//fin de la fonction
	
	
	
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
		$service = new Servicen;
		$ping_ops = new ping_admin_ops;
		$eq_ops = new equipes_ping;
		$epr_ops = new EpreuvesIndivs;
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
			var_dump($xml);
			

		}//fin du premier foreach

		
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
		
					
    }	
	//ajoute les coordonnées de la salle et du correspondant
	function add_coordonnees($idclub, $numero, $nom, $nomsalle, $adressesalle1, $adressesalle2, $codepsalle, $villesalle, $web, $nomcor, $prenomcor, $mailcor, $telcor, $lat, $lng)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_coordonnees(idclub, numero, nom, nomsalle, adressesalle1, adressesalle2, codepsalle, villesalle, web, nomcor, prenomcor, mailcor, telcor, lat, lng)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($idclub, $numero, $nom, $nomsalle, $adressesalle1, $adressesalle2, $codepsalle, $villesalle, $web, $nomcor, $prenomcor, $mailcor, $telcor, $lat, $lng));
	}
	
	//tout sur les épreuves individuelles
	function retrieve_divisions ($idorga,$idepreuve,$type = '')
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$fede = $ping->GetPreference('fede');
		$zone = $ping->GetPreference('zone');
		$ligue = $ping->GetPreference('ligue');
		$dep = $ping->GetPreference('dep');
		$saison = $ping->GetPreference('saison_en_cours');
		$now = trim($db->DBTimeStamp(time()), "'");
		$indivs = 1; //par défaut car on récupère les épreuves individuelles seulement
		$type = 'I';
		$page="xml_division";
		//on instancie la classe service
		$service = new Servicen();


			$var = "organisme=".$idorga."&epreuve=".$idepreuve."&type=".$type;
				//echo $valeur;
				if($idorga == $fede) {$scope = 'F';}
				if($idorga == $zone) {$scope = 'Z';}
				if($idorga == $ligue) {$scope = 'L';}
				if($idorga == $dep) {$scope = 'D';}
				//
				$lien = $service->GetLink($page,$var);
				var_dump($lien);
				$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
				//var_dump($xml);
				if($xml === FALSE )
				{
					//le service est coupé
					$array = 0;
					$lignes = 0;
				}
				else
				{
					$array = json_decode(json_encode((array)$xml), TRUE);
					
					if(isset($array['division']))
					{
						$lignes = count($array['division']);
					
				
						//echo "le nb de lignes est : ".$lignes;
						$i=0;
						//on initialise un deuxième compteur
						$compteur=0;
						
						foreach($xml as $value)
						{

							$i++;
							$iddivision = htmlentities($value->iddivision);
							$libelle = htmlentities($value->libelle);
							$query = "INSERT INTO ".cms_db_prefix()."module_ping_divisions (idorga, idepreuve,iddivision,libelle,saison,indivs,scope) VALUES (?, ?, ?, ?, ?, ?, ?)";
							//echo $query;
							$compteur++;
							$dbresultat = $db->Execute($query,array($idorga,$idepreuve,$iddivision,$libelle,$saison,$indivs,$scope));

							if(!$dbresultat)
							{
								$designation .= $db->ErrorMsg();			
							}
							else
							{
								//on peut écrire ds le journal
								$message = $idepreuve." - >".$idorga."->".$libelle." - >".$iddivision; 
								$status = 'Ok';
								//$designation.= $message;
								$action = "retrieve_ops";
								ping_admin_ops::ecrirejournal($now,$status, $message,$action);
								
							}

								

								unset($message);
						}// fin du foreach
						
					}
				unset($scope);
				}
			//}//fin du premier foreach
		
	}
	
	function retrieve_div_tours ($idepreuve,$iddivision)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision;
		
			$var.="&action=poule";

		
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		
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
			$lignes = count($array['tour']);
		}
		//echo "le nb de lignes est : ".$lignes;
		$i = 0;
		foreach($xml as $value)
		{
			//$libelle = $tab['libelle'];
			//$lien = $tab['lien'];
			$libelle = htmlentities($value->libelle);
			//on va extraire le tour
			$tour1 = explode(" ",$libelle);
			$tour2 = trim($tour1[0],'T');

			$lien = htmlentities($value->lien);
			$tab1 = explode("&",$value->lien);

			$tableau = trim($tab1[2], 'cx_tableau=');

			if($tableau != '')
			{
				
				//On a récupéré les éléments, on peut faire l'insertion dans notre bdd
				//on va d'abord vérifier si ces éléments sont présents ou on créé un index sur la table
				$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_tours (idepreuve,iddivision,libelle, tour, tableau, lien,saison) VALUES (?, ?, ?, ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$libelle,$tour2, $tableau,$lien,$saison));
				if($dbresult)
				{
				$i++;
				
				//et si on continuait ?
				//reprendre les infos ci dessus pour les traiter !
				//on pourrait préparer les différents tags : poule, classement, partie.
				//on met à tjour la table divisions pour dire qu'on a bien uploadé
				$uploaded = 1;
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_divisions SET uploaded = ? WHERE iddivision = ? AND saison = ?";
				$dbresult2 = $db->Execute($query2, array($uploaded, $iddivision, $saison));
				
				//on écrit dans le journal
				$status = 'Ok';
				$action = 'retrieve_div_tours';
				$designation = $i." tour(s) inséré(s) pour l\'épreuve ".$idepreuve;
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				}
			}




		}
	}
	
	function retrieve_div_classement ($idepreuve,$iddivision,$tableau)
	{
		global $gCms;
		$ping = cms_utils::get_module('Ping'); 
		$db = cmsms()->GetDb();
		$saison = $ping->GetPreference('saison_en_cours');
		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision."&cx_tableau=".$tableau;
		
			$var.="&action=classement";

		//echo $var;
		$service = new Servicen();
		$lien = $service->GetLink($page, $var);
		
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		if($xml === FALSE )
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			if(isset($array['classement']))
			{
				$lignes = count($array['classement']);
			}
			else
			{
				$lignes = 0;
			}
		}
		//echo "le nb de lignes est : ".$lignes;
		if($lignes != 0)
		{
			
			foreach($xml as $value)
			{
				//$libelle = $tab['libelle'];
				//$lien = $tab['lien'];
				$rang = htmlentities($value->rang);
				$nom = htmlentities($value->nom);
				$clt = htmlentities($value->clt);
				$club = htmlentities($value->club);

				//on fait une conditionnelle pour récupérer la licence du joueur du club
				$nom_equipes = $ping->GetPreference('nom_equipes');
				$club2 = stristr($nom_equipes,$club);
				if(true == $club2)//stristr('RP FOUESNANT',$club) === 'true')
				{
					
					//ça match !!
					$cool = 1;
					//on ecrit dans le journal
					$status = 'Ok';
					$designation.= $nom." finit à la place ".$rang;
					$action = 'Récup classement';
					ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
				}
			//	$points = htmlentities($value->points);

				//On a récupéré les éléments, on peut faire l'insertion dans notre bdd			
				//On fait une conditionnelle pour inclure uniquement les gens du club ?
				//il fait faire une nouvelle préférence



				$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_classement (idepreuve,iddivision,tableau,rang, nom,clt,club, saison) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query;
				$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$tableau,$rang, $nom, $clt, $club,$saison));

				if(!$dbresult)
				{
					$designation .= $db->ErrorMsg();
				}
				
				
			}
			//la requete a fonctionné, on peut mettre le statut du tour a "uploadé"
			$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded_classement = 1 WHERE id = ?";
			$dbresult2 = $db->Execute($query2,array($value));
			$designation.= 'récup tableau '.$tableau.' du tour '.$tour.' de l\'épreuve '.$idepreuve;
			$status = 'OK';
			$action = 'div_classement';
			ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
		}
	}
} // end of class

#
# EOF
#
?>
