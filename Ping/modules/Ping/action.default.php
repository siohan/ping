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
//$rowarray = array();
//$rowarray1 = array();
$i=0;
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_calendrier WHERE date_fin<=NOW() GROUP BY date_debut ORDER BY date_debut DESC";
$dbresult = $db->Execute($query);

	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$i++;
			$date_debut = $row['date_debut'];
			//echo "la date début est :".$date_debut;
			$datearr = explode('-', $date_debut);
			$datefr = $datearr[2] . '-' . $datearr[1] . '-' . $datearr[0];
			
			$query2 = "SELECT *, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0)  AND ren.date_event = ?";
			//$query2 = "SELECT * FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event = ?";
			//mon club uniquement ?
			$query2.=" AND club = '1'";
			$dbresultat = $db->Execute($query2, array($date_debut));
			
				
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				
				$contenu = '';				
				$contenu.= "<h3>Les résultats du  ".$datefr."</h3>";
				$contenu.="<table class=\"table table-bordered\">";
				
				while($row2 = $dbresultat->FetchRow())
				{
					
				
					
					$id= $row2['id'];
					$date_event= $row2['date_event'];
					$equb = $row2['equb'];
					$equa = $row2['equa'];
					$friendlyname = $row2['friendlyname'];
					$libequipe = $row2['libequipe'];
					//echo "equipe B est : ".$equb;

					//$onerow->equipe= $row['equipe'];
					$libelle=  $row2['libelle'] ;
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equa)
						{
							$equa= $row2['friendlyname'];
						}

						else{
							$equa= $row2['equa'];
						}

					}
					else{
						$equa= $row2['equa'];
					}
					$scorea= $row2['scorea'];
					$scoreb= $row2['scoreb'];
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equb)
						{
							$equb= $row2['friendlyname'];
						}

						else{
							$equb= $row2['equb'];
						}

					}
					else{
						$equb= $row2['equb'];
					}
					$details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row2['id'], 'template'=>'1'));
					$contenu.="<tr>";
					//$contenu.="<td>$id</td>";
					$contenu.="<td>$equa</td>";
					$contenu.="<td>$scorea</td>";
					$contenu.="<td>$scoreb</td>";
					$contenu.="<td>$equb</td>";
					$contenu.="<td>$details</td>";
					$contenu.="</tr>";
					
				}
				
				
				$contenu.="</table>";
				echo $contenu;
			}
			
			
		}
		
	}
if(isset($params['template']) && $params['template'] == '1')	
{
echo $this->ProcessTemplate('details_rencontre.tpl');
}
#
?>