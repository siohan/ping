<?php
if( !isset($gCms) ) exit;
require_once(dirname(__FILE__).'/include/travaux.php');

// les préférences nécessaires
$saison = $this->GetPreference('saison_en_cours');
$now = trim($db->DBTimeStamp(time()), "'");
$nom_equipes = $this->GetPreference('nom_equipes');
$designation = '';
//on fait une requete pour extraire toutes les infos afin de préparer une boucle
$query = "SELECT iddiv, idpoule FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
$dbresult = $db->Execute($query, array($saison));

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
		
	
		
    		while ($dbresult && $row = $dbresult->FetchRow())
      		{
			$service = new Service();
	 		//on instancie un compteur
			$iddiv = $row['idddiv'];
			$idpoule = $row['idpoule'];
			$result = $service->getPouleRencontres("$iddiv","$idpoule");


			//var_dump($result);	
			$i=0;
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
				$query = "SELECT id,lien,scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE WHERE iddiv =? AND idpoule = ? AND date_event = ? AND equa = ? AND equb = ?";
				$dbresult = $db->Execute($query, array($iddiv,$idpoule,$date_event,$equa,$equb));
				
					if($dbresult  && $dbresult->RecordCount() == 0) 
					{
						$query = "INSERT INTO ".cms_db_prefix()."module_ping_poules_rencontres (id,saison,idpoule, iddiv, club, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien) VALUES ('', ? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						//	echo $query;
						$i++;
						$uploaded = 0;
						$dbresultat = $db->Execute($query,array($saison,$idpoule, $iddiv, $club, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien));

						if(!$dbresultat)
						{
							$designation .= $db->ErrorMsg(); 
						}
						
							
						
					}
					elseif($dbresult->RecordCount() >0)
					{
						//il y a déjà un enregistrement, le score est-il à jour ?
						$update = 1;
						$row = $dbresult->FetchRow();
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
					
					$comptage = $i;
					$status = 'Poules';
					$designation = "Mise à jour de ".$comptage." rencontres de la poule ".$idpoule;
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
					$action = "retrieve_poules_rencontres";
					$dbresult = $db->Execute($query, array($now,$status, $designation,$action));
					
						if(!$dbresult)
						{
							$designation.= $db->ErrorMsg(); 
						}
				
			}//fin du foreach
			
			
		}//fin du while
	}
	else 
	{
		$this->SetMessage('Pas d\'équipes trouvées');
		$this->RedirectToAdminTab('equipes');
	}//fin du if dbresult




	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('equipes');
	
#
# EOF
#
?>