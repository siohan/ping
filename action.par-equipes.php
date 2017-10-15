<?php
   if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$nom_equipes = $this->GetPreference('nom_equipes');
$saison = $this->GetPreference('saison_en_cours');
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$rowarray = array();
//$rowarray1 = array();
//on instancie une valeur pour savoir si des parametres sont introduits
$para = 0;
$i=0;
$query = "SELECT *, ren.id AS ren_id FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_calendrier AS cal  WHERE ren.date_event = cal.date_debut ";//AND cal.date_debut<=NOW()";//GROUP BY date_debut ORDER BY date_debut DESC";

if (isset($params['date_debut']) && $params['date_debut'] != '')
{
	$para++;
	//on regarde si la date de fin est aussi spécifiée
	if(isset($params['date_fin']) && $params['date_fin'] != '')
	{
		$date_fin = $params['date_fin'];
		//on initialise une variable pour se souvenir de cette condition
		$fill = 1;
		$parms['date_fin'] = $date_fin;

	}
	
	$date_debut = $params['date_debut'];
	$parms['date_debut'] = $date_debut;
	$query.= " AND cal.date_debut = ?";
	$parms['date_debut'] = $date_debut;
	
	if($fill == 1)
	{
		$query.= " AND cal.date_fin = ?";
	}

	
	
		
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$para++;
	$idepreuve = $params['idepreuve'];
	$query.=" AND cal.idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
}
if(isset($params['saison']) && $params['saison'] != '')
{
	$para++;
	$saison = $params['saison'];
	$query.= " AND cal.saison = ?";
	$parms['saison']  = $saison;
}
if($para>0)
{
	$query.=" GROUP BY ren.date_event ORDER BY ren.date_event DESC";
	$dbresult = $db->Execute($query,$parms);
}
else
{
	$query.= " AND cal.date_debut<=NOW()";
	$query.=" GROUP BY ren.date_event ORDER BY ren.date_event DESC";
	$dbresult = $db->Execute($query);
}
/*
$query.=" AND type_compet = ?";
$parms['type_compet']  = '+';
*/



//$dbresult = $db->Execute($query);

	if($dbresult && $dbresult->RecordCount()>0)
	{
		$parms2 = array();
		while($row = $dbresult->FetchRow())
		{
			$i++;
			$date_debut = $row['date_event'];
			//echo "la date début est :".$date_debut;
			$datearr = explode('-', $date_debut);
			$datefr = $datearr[2] . '-' . $datearr[1] . '-' . $datearr[0];
			$ren_id = $row['ren_id'];
			$onerow = new StdClass();
			$onerow->rowclass = $rowclass;
			$onerow->date_event = $datefr;
			$onerow->valeur = $i;
			
			
			$query2 = "SELECT ren.id AS ren_id, ren.equa,ren.uploaded, ren.equb, eq.id AS eq_id, eq.libequipe,eq.friendlyname, ren.scorea, ren.scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule AND (eq.libequipe = ren.equa OR eq.libequipe = ren.equb) AND ren.saison = eq.saison  AND ren.date_event = ? ";//AND (ren.scorea !=0 OR scoreb !=0)";
			$parms2['date_event'] = $date_debut;
			
			if(isset($params['type_compet']) && $params['type_compet'])
			{
					$query2.=" AND eq.type_compet = ?";
					$parms2['type_compet'] = $params['type_compet'];
			}
			if(isset($params['idepreuve']) && $params['idepreuve'])
			{
					$query2.=" AND eq.idepreuve = ?";
					$parms2['idepreuve'] = $params['idepreuve'];
			}
			
			//mon club uniquement ?
			if($this->GetPreference('affiche_club_uniquement') == 'Oui')
			{
				$query2.=" AND (ren.club = '1' OR ren.affiche = '1')";
			}
		//	echo $query2;
			$dbresultat = $db->Execute($query2, $parms2);
			$rowarray2 = array();
			//var_dump($parms2);
		//	echo "essai !";	
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				
				$rowclass= 'row1';
				
				while($row2 = $dbresultat->FetchRow())
				{
					
				
					$equa = $row2['equa'];
					$equb = $row2['equb'];
					$scorea = $row2['scorea'];
					$scoreb = $row2['scoreb'];
					$eq_id = $row2['eq_id'];
					$uploaded = $row2['uploaded'];
					$libequipe = $row2['libequipe'];
					$friendlyname = $row2['friendlyname'];
					$onerow2 = new StdClass();
					$onerow2->rowclass =$rowclass;
					$onerow2->ren_id= $row2['ren_id'];
					$onerow2->date_event= $row2['date_event'];
					$onerow2->equb = $row2['equb'];
					$onerow2->equa = $row2['equa'];
					$onerow2->friendlyname = $row2['friendlyname'];
					$onerow2->libequipe = $libequipe;
					$onerow2->uploaded = $uploaded;
					//echo "equipe B est : ".$equb;

					//$onerow->equipe= $row['equipe'];
					$onerow2->libelle=  $row2['libelle'] ;
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if (rtrim($libequipe) == $equa)
						{
							//$onerow2->equa= $row2['friendlyname'];
							$onerow2->equa= $this->CreateFrontendLink($id,$returnid,'equipe',$contents=$row2['friendlyname'], array('record_id'=>$eq_id));
						}

						else
						{
							$onerow2->equa= $row2['equa'];
						}

					}
					else{
						$onerow2->equa= $row2['equa'];
					}
					
					//$onerow2->equa= $row2['equa'];
					$onerow2->scorea= $row2['scorea'];
					$onerow2->scoreb= $row2['scoreb'];
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if (rtrim($libequipe) == $equb)
						{
							//$onerow2->equa= $row2['friendlyname'];
							$onerow2->equb= $this->CreateFrontendLink($id,$returnid,'equipe',$contents=$row2['friendlyname'], array('record_id'=>$eq_id));
						}

						else
						{
							$onerow2->equb= $row2['equb'];
						}

					}
					else{ 
						$onerow2->equb= $row2['equb'];
					}
					
					//$onerow2->equb= $row2['equb'];
					//$onerow2->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row2['id'], 'template'=>'1'));
					$onerow2->details= $this->CreateFrontendLink($id, $returnid,'details', $contents='Détails', array('record_id'=>$row2['ren_id'], 'template'=>'1'));
					$rowarray2[] = $onerow2;
					
					
				}//fin du deuxième while
				$smarty->assign('prods_'.$i,$rowarray2);
				unset($rowarray2);
				unset($idepreuve2);
				
				$rowarray[]  = $onerow;
				$smarty->assign('items', $rowarray);
			}// fin du if $dbresultat
			else
			{
				echo 'Pas de résultats correspondant à votre demande. Consultez l\'aide si nécessaire...';
			}
			
			
		}//fin du premier while
		
	}//fin du premier if dbresult
	else
	{
		echo 'Pas de résultats correspondant à votre demande. Consultez l\'aide si nécessaire...';
	}

echo $this->ProcessTemplate('details_rencontre.tpl');

#
?>