<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//if (isset($params['cancel'])) { $this->Redirect($id, 'defaultadmin', $returnid); }
require_once(dirname(__FILE__).'/function.calculs.php');
require_once(dirname(__FILE__).'/include/prefs.php');

$designation = '';

/*$id_user = '';*/
	if ( isset($params['record_id'] ))
	{
		$record_id = $params['record_id'];
	}
	if(isset($params['duplicate']) && $params['duplicate'] =='1')
	{
		$query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
	
		$dbresult = $db->Execute($query, array($record_id));
		
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$saison = $row['licence'];
					//pas de datemaj
					$licence = $row['licence'];
					$date_event = $row['date_event'];
					$epreuve = $row['epreuve'];
					$nom = $row['nom'];
					$numjourn = $row['numjourn'];
					$classement = $row['classement'];
					$victoire = $row['victoire'];
					$ecart = $row['ecart'];
					$type_ecart = $row['type_ecart'];
					$coeff = $row['coeff'];
					$pointres = $row['pointres'];
					$forfait = $row['forfait'];
										
					$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id, saison, datemaj, licence, date_event, epreuve, nom, numjourn, classement, victoire, ecart, type_ecart, coeff, pointres, forfait) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$dbresult2 = $db->Execute($query2, array($saison_courante,$now, $licence,$date_event, $epreuve, $nom, $numjourn, $classement, $victoire, $ecart, $type_ecart, $coeff, $pointres, $forfait));
					$designation.="Enregistrement dupliqué";
					
				}
			}
	}
	else
	{
		if (isset($params['epreuve'])) 
		{
			$epreuve = $params['epreuve'];
			$coefficient = coeff($epreuve);
		}


		if (isset($params['numjourn']))
		{
			$numjourn = $params['numjourn'];
		}
		if (isset($params['nom']))
		{
				$nom = $params['nom'];
		}

		if (isset($params['classement']))
		{
				$classement = $params['classement'];
		}
		if (isset($params['ecart']))
		{
				$ecart = $params['ecart'];
		}
		if (isset($params['coeff']))
		{
				$coeff = $params['coeff'];
		}
		if (isset($params['victoire']))
		{
				$victoire = $params['victoire'];
		}
		//on vérifie le coeff de l'épreuve : 

			if ($coefficient !=$coeff)
			{
					//on vérifie si le coeff est différent de 0 ds la bdd des compétitions
					if($coefficient == '' && $coeff != '')
					{
						//alors on peut mettre le coeff à jour en bdd
						$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET coefficient = ? WHERE name = ?";
						$dbresult = $db->Execute($query, array($coeff, $epreuve));
						$designation.= "Coefficient mis à jour";
					}
					else
					{
						$designation.="Le coefficient et l'épreuve ne correspondent pas !";
					}
					
			}
		//on fait les calculs nécessaires

		//tout d'abord, y a t-il eu forfait ?
		//Si oui, inutile de calculer les points

			if($forfait ==1)
			{
					$pointres = 0;
			}
			else
			{
				//on détermine le type d'écart entre les deux joueurs
				$type_ecart = CalculEcart($ecart);
				$points1 = CalculPointsIndivs($type_ecart, $victoire);
				$pointres = $points1*$coeff; 

			}
			
			$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET nom = ?, numjourn = ?, classement = ?, victoire = ?, ecart = ?, coeff = ?, pointres = ?, statut = 1 WHERE id = ?";
				
			
			$dbresult = $db->Execute($query, array($nom, $numjourn, $classement, $victoire, $ecart, $coeff,$pointres, $record_id));
	
				if (!$dbresult) 
				{
					$designation.=$db->ErrorMsg();
				}
				else
				{
					$designation.="Enregistrement modifié.";
				}
	}
	
		
			
			
		$this->SetMessage($designation);
		$this->RedirectToAdminTab('results');

?>