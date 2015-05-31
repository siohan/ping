<?php
   if (!isset($gCms)) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$nom_equipes = $this->GetPreference('nom_equipes');
$saison = $this->GetPreference('saison_en_cours');
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$rowarray = array();
//$rowarray1 = array();
$i=0;
$query = "SELECT *, ren.id FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_calendrier AS cal  WHERE ren.date_event = cal.date_debut AND cal.date_debut<=NOW()";//GROUP BY date_debut ORDER BY date_debut DESC";
/*
$query.=" AND type_compet = ?";
$parms['type_compet']  = '+';

$dbresult = $db->Execute($query,$parms);
*/
$query.=" GROUP BY ren.date_event ORDER BY ren.date_event DESC";
$dbresult = $db->Execute($query);

	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$i++;
			$date_debut = $row['date_event'];
			//echo "la date début est :".$date_debut;
			$datearr = explode('-', $date_debut);
			$datefr = $datearr[2] . '-' . $datearr[1] . '-' . $datearr[0];
			$id = $row['id'];
			$onerow = new StdClass();
			$onerow->rowclass = $rowclass;
			$onerow->date_event = $datefr;
			$onerow->valeur = $i;
			
			
			$query2 = "SELECT *,ren.equa, ren.equb, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0)  AND ren.date_event = ?";
			$parms['date_event'] = $date_debut;
			
			if(isset($params['type_compet']) && $params['type_compet'])
			{
					$query2.=" AND eq.type_compet = ?";
					$parms['type_compet'] = $params['type_compet'];
			}
			
			//mon club uniquement ?
			$query2.=" AND ren.club = '1'";
			$dbresultat = $db->Execute($query2, $parms);
			$rowarray2 = array();
				
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				
				$rowclass= 'row1';
				
				while($row2 = $dbresultat->FetchRow())
				{
					
				
					$equa = $row2['equa'];
					$equb = $row2['equb'];
					$scorea = $row2['scorea'];
					$scoreb = $row2['scoreb'];
					$libequipe = $row2['libequipe'];
					$friendlyname = $row2['friendlyname'];
					$onerow2 = new StdClass();
					$onerow2->rowclass =$rowclass;
					$onerow2->id= $row2['id'];
					$onerow2->date_event= $row2['date_event'];
					$onerow2->equb = $row2['equb'];
					$onerow2->equa = $row2['equa'];
					$onerow2->friendlyname = $row2['friendlyname'];
					$onerow2->libequipe = $row2['libequipe'];
					//echo "equipe B est : ".$equb;

					//$onerow->equipe= $row['equipe'];
					$onerow2->libelle=  $row2['libelle'] ;
					
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
					$onerow2->scorea= $row2['scorea'];
					$onerow2->scoreb= $row2['scoreb'];
					
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
					$onerow2->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row2['id'], 'template'=>'1'));
					$rowarray2[] = $onerow2;
					
					
				}//fin du deuxième while
				$smarty->assign('prods_'.$i,$rowarray2);
				unset($rowarray2);
				
				$rowarray[]  = $onerow;
				$smarty->assign('items', $rowarray);
			}// fin du if $dbresultat
			
			
		}
		
	}

echo $this->ProcessTemplate('details_rencontre.tpl');

#
?>