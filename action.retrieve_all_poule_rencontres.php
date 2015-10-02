<?php
if( !isset($gCms) ) exit;
require_once(dirname(__FILE__).'/include/travaux.php');

// les préférences nécessaires
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
$now = trim($db->DBTimeStamp(time()), "'");
$nom_equipes = $this->GetPreference('nom_equipes');
$designation = '';
//on fait une requete pour extraire toutes les infos afin de préparer une boucle
$query1 = "SELECT DISTINCT iddiv, idpoule FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ?";
$dbresult1 = $db->Execute($query1, array($saison,$phase));

	if ($dbresult1 && $dbresult1->RecordCount() > 0)
  	{
		
	
		
    		while ($dbresult1 && $row = $dbresult1->FetchRow())
      		{
			
			//$service = new Service();
	 		//on instancie un compteur
			$iddiv = $row['iddiv'];
			$idpoule = $row['idpoule'];
			$service = new Servicen();
			$page = "xml_result_equ";
			$var = "auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
			$lien = $service->GetLink($page, $var);
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			if($xml === FALSE)
			{
				//Le lien ne retourne rien le service est coupé
				//le tableau est vide, il faut envoyer un message pour le signaler
				$designation.= "le service est coupé";
				$result = 0;
				$this->SetMessage("$designation");
				$this->RedirectToAdminTab('poules');
			}
			else
			{
				$array = json_decode(json_encode((array)$xml),TRUE);
				$lignes = count($array['tour']);
			}

			//il faut tester si le tableau est vide ou non
			if(!is_array($array) || $lignes ==0)
			{
				
			}
			else
			{
				//tt va bien on continue
			
				//var_dump($result);	
				$i=0;
				foreach($xml as $cle =>$tab)
				{


					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$equa = (isset($tab->equa)?"$tab->equa":"");
					$equb = (isset($tab->equb)?"$tab->equb":"");

					//on fait quelque transformations des infos recueillies
					preg_match_all('#[0-9]+#',$libelle,$extract);
					$tour = $extract[0][0];

					$extraction = substr($libelle,-8);
					$date_extract = explode('/', $extraction);
					$annee_date = $date_extract[2] + 2000;
					$date_event = $annee_date."-".$date_extract[1]."-".$date_extract[0];
					$uploaded = 0;

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
						}
					//on vérifie si l'enregistrement est déjà là
					$query2 = "SELECT id,lien,scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
					$dbresult2 = $db->Execute($query2, array($iddiv,$idpoule,$date_event,$equa,$equb));
				
						if($dbresult2  && $dbresult2->RecordCount() == 0) 
						{
							$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//	echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query3,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

							if(!$dbresultat)
							{
								$designation .= $db->ErrorMsg(); 
							}
						
							
						
						}
						elseif($dbresult2 && $dbresult2->RecordCount() >0)
						{
							//il y a déjà un enregistrement, le score est-il à jour ?
							$update = 1;
							$row = $dbresult2->FetchRow();
							$id = $row['id'];
							$scoreA = $row['scorea'];
							$scoreB = $row['scoreb'];

								if($scoreA ==0 && $scoreB ==0)
								{
									$query3 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE id = ?";
									$dbresultA = $db->Execute($query3, array($scorea, $scoreb, $id));
									$i++;
									if(!$dbresultA)
									{
										$designation.= $db->ErrorMsg();
									}
								}
						}
					
					
				
					}//fin du foreach
				/*
				foreach($result as $cle =>$tab)
				{


					$libelle = $tab[libelle];
					$equa = $tab[equa];
					$equb = $tab[equb];

					//on fait quelque transformations des infos recueillies
					preg_match_all('#[0-9]+#',$libelle,$extract);
					$tour = $extract[0][0];

					$extraction = substr($libelle,-8);
					$date_extract = explode('/', $extraction);
					$annee_date = $date_extract[2] + 2000;
					$date_event = $annee_date."-".$date_extract[1]."-".$date_extract[0];
					$uploaded = 0;

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
					
					$scorea = $tab[scorea];
					$scoreb = $tab[scoreb];
					$lien = $tab[lien];	
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
					//on vérifie si l'enregistrement est déjà là
					$query2 = "SELECT id,lien,scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
					$dbresult2 = $db->Execute($query2, array($iddiv,$idpoule,$date_event,$equa,$equb));
				
						if($dbresult2  && $dbresult2->RecordCount() == 0) 
						{
							$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							//	echo $query;
							$i++;
							$uploaded = 0;
							$dbresultat = $db->Execute($query3,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

							if(!$dbresultat)
							{
								$designation .= $db->ErrorMsg(); 
							}
						
							
						
						}
						elseif($dbresult2 && $dbresult2->RecordCount() >0)
						{
							//il y a déjà un enregistrement, le score est-il à jour ?
							$update = 1;
							$row = $dbresult2->FetchRow();
							$id = $row['id'];
							$scoreA = $row['scorea'];
							$scoreB = $row['scoreb'];

								if($scoreA ==0 && $scoreB ==0)
								{
									$query3 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET scorea = ?, scoreb = ? WHERE id = ?";
									$dbresultA = $db->Execute($query3, array($scorea, $scoreb, $id));
									$i++;
									if(!$dbresultA)
									{
										$designation.= $db->ErrorMsg();
									}
								}
						}
					
					
				
					}//fin du foreach
					*/
				}//fin du if !is_array vérification du tableau
			$comptage = $i;
			$status = 'Poules';
			$designation = "Mise à jour de ".$comptage." rencontres de la poule ".$idpoule;
			$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
			$action = "retrieve_poules_rencontres";
			$dbresult4 = $db->Execute($query4, array($now,$status, $designation,$action));
			
				if(!$dbresult4)
				{
					$designation.= $db->ErrorMsg(); 
				}
			
		}//fin du while
	}
	else 
	{
		$this->SetMessage('Pas d\'équipes trouvées');
		$this->RedirectToAdminTab('equipes');
	}//fin du if dbresult




	
	$this->SetMessage("Retrouvez les infos dans le journal");
	$this->RedirectToAdminTab('resultats');
	
#
# EOF
#
?>