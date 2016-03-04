<?php
#####################################################################
###                  To come                                      ###
###    Cette page affiche les prochaines compétitions à venir     ###
## Params intervalle de temps                                     ###
## Params limit pour limiter le nb de résultats                   ###
#####################################################################
//les compétitions à venir
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
//la requete
$query = "SELECT cal.date_debut, cal.date_fin, cal.type_compet,tc.name, tc.indivs FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc  WHERE tc.idepreuve = cal.idepreuve AND cal.date_debut BETWEEN NOW() ";//AND (NOW() + INTERVAL 7 DAY)";///BETWEEN '2014-12-01' AND ('2014-12-01'+ INTERVAL 7 DAY) ";////
$temps = 14;
$query.=" AND (NOW() + INTERVAL ".$temps." DAY)";
//définir une préférence pour un interval de temps
//Pour chaque résultat savoir s'il s'agit d'une compétition est individuelle ou non
//ici on peut faire des préférences pour affiner les résultats
$limit = '';
$order = '';
$type_compet = '';

	if(isset($params['type_compet']) && $params['type_compet'] !='')
	{
		$query.=" AND cal.type_compet = ?";
		$parms['type_compet'] = $params['type_compet'];
	}
	
$query.=" ORDER BY cal.date_debut ASC, tc.code_compet";	

	if(isset($params['limit']) && $params['limit'] !='')
	{
		$limit = $params['limit'];
		$query.= " LIMIT 0,".$limit;
	}
	
if($type_compet !='')
{
	$dbresult = $db->Execute($query, $parms);
}
else
{
	$dbresult = $db->Execute($query);
}


$rowarray = array();
$i=0;
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$indivs = $row['indivs'];
		$date_debut = $row['date_debut'];
		$date_fin = $row['date_fin'];
		$type_compet = $row['type_compet'];
		$compet = $row['name'];
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->compet = $compet;
		$onerow->date = $date_debut;
		$onerow->indivs = $row['indivs'];
		 //on déclare un nouveau tableau
		$rowarray2 = array();
		if($indivs == 0)    //on est sur une compétition par équipes
		{
			$i++;
			$onerow->valeur = $i;
			//on refait une requete pour extraire les rencontres
			$query2 = "SELECT *,eq.friendlyname, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule AND ren.saison = eq.saison AND ren.club = '1' AND ren.date_event = ? AND eq.type_compet = ?";//" AND date_event >=Now()";
			$dbresultat = $db->Execute($query2,array($date_debut, $type_compet));
			$nblignes = $dbresultat->RecordCount();
			//echo "le nb de lignes est : ".$nblignes;
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				while($row2 = $dbresultat->FetchRow())
				{
					//$valeur = $i;
					$onerow2 = new StdClass();
					$equa = $row2['equa'];
					$equb = $row2['equb'];
					$libequipe = $row2['libequipe'];
					$friendlyname = $row2['friendlyname'];
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equa)
						{
							$onerow2->equa= $row2['friendlyname'];
						}
						
						else{
							$onerow2->equa= $row2['equa'];
						}

					}
					else{
						$onerow2->equa= $row2['equa'];
					}
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equb)
						{
							$onerow2->equb= $row2['friendlyname'];
						}

						else{
							$onerow2->equb= $row2['equb'];
						}

					}
					else{
						$onerow2->equb= $row2['equb'];
					}
					
					//$onerow2->valeur = $valeur;
					$rowarray2[] = $onerow2;
					
				}
				
				$smarty->assign('prods_'.$i,$rowarray2);
				unset($rowarray2);
			//	unset($valeur);
			}
			
		}
		else
		{
			$date_event = $row['date_debut'];
			$name = $row['name'];
			//$onerow->compet = $name;
		}
		$rowarray[]  = $onerow;
		$smarty->assign('items', $rowarray);
		
	}
}
else
{
	$smarty->assign('message', 'Pas de résultats');
	echo 'pas de résultats';
}
echo $this->ProcessTemplate('avenir.tpl');
#
#EOF
#
?>







