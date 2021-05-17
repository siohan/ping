<?php
   if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
//$nom_equipes = $this->GetPreference('nom_equipes');
$saison = $this->GetPreference('saison_en_cours');
$db = cmsms()->GetDb();
global $themeObject;
$result= array();
$parms = array();
$rowarray = array();
//$rowarray1 = array();
$query = "SELECT DISTINCT date_event FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event<=NOW()";//GROUP BY date_debut ORDER BY date_debut DESC";


if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$query.=" AND idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
}
if(isset($params['saison']) && $params['saison'] != '')
{
	$saison = $params['saison'];
	$query.= " AND saison = ?";
	$parms['saison']  = $saison;
}

if(isset($params['template']) && $params['template'] !="")
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats Par Equipes');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats des équipes introuvable');
        return;
    }
    $template = $tpl->get_name();
}

	$query.=" GROUP BY date_event ORDER BY date_event DESC";
	$dbresult = $db->Execute($query,$parms);

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
			
			
			$query2 = "SELECT ren.id AS ren_id, ren.equa,ren.uploaded, ren.equb, eq.id AS eq_id, eq.libequipe,eq.friendlyname, ren.scorea, ren.scoreb, ren.renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule AND (eq.libequipe = ren.equa OR eq.libequipe = ren.equb) AND ren.saison = eq.saison  AND ren.date_event = ? ";//AND (ren.scorea !=0 OR scoreb !=0)";
			$parms2['date_event'] = $date_debut;
			
			
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
			$dbresultat = $db->Execute($query2, $parms2);
			$rowarray2 = array();

			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				
				$rowclass= 'row1';
				$renc_ops = new rencontres;
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
					$onerow2->eq_id = $row2['eq_id'];
					$onerow2->renc_id = $row2['renc_id'];
					$onerow2->ren_id= $row2['ren_id'];
					$onerow2->date_event= $row2['date_event'];
					$onerow2->equb = $row2['equb'];
					$onerow2->equa = $row2['equa'];
					$onerow2->friendlyname = $row2['friendlyname'];
					$onerow2->libequipe = $libequipe;
					$onerow2->uploaded = $renc_ops->is_uploaded($row2['renc_id']);//$uploaded;
					//echo "equipe B est : ".$equb;

					//$onerow->equipe= $row['equipe'];
					$onerow2->libelle=  $row2['libelle'] ;
					
					
						if (rtrim($libequipe) == $equa)
						{
							if(isset($friendlyname) && $friendlyname !='')
							{
								$onerow2->equa= $this->CreateFrontendLink($id,$returnid,'equipe',$contents=$row2['friendlyname'], array('record_id'=>$eq_id));
							}
							else
							{
								$onerow2->equa= $this->CreateFrontendLink($id,$returnid,'equipe',$contents=$row2['equa'], array('record_id'=>$eq_id));//$row2['equb'];
							}//$onerow2->equa= $row2['friendlyname'];

					}
					else
					{
						$onerow2->equa= $row2['equa'];
					}
					
					//$onerow2->equa= $row2['equa'];
					$onerow2->scorea= $row2['scorea'];
					$onerow2->scoreb= $row2['scoreb'];
					
					
						if (rtrim($libequipe) == $equb)
						{
								if(isset($friendlyname) && $friendlyname !='')
								{
									$onerow2->equb= $this->CreateFrontendLink($id,$returnid,'equipe',$contents=$row2['friendlyname'], array('record_id'=>$eq_id));
								}
								else
								{
									$onerow2->equb= $this->CreateFrontendLink($id,$returnid,'equipe',$contents=$row2['equb'], array('record_id'=>$eq_id));//$row2['equb'];
								}
						}

						else
						{
							$onerow2->equb= $row2['equb'];
						}
					
					//$onerow2->details= $this->CreateFrontendLink($id, $returnid,'details', $contents='Détails', array('record_id'=>$row2['renc_id']));
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
				//echo 'Pas de résultats correspondant à votre demande. Consultez l\'aide si nécessaire...';
			}
			
			
		}//fin du premier while
		
	}//fin du premier if dbresult
	else
	{
		echo 'Pas de résultats correspondant à votre demande. Consultez l\'aide si nécessaire...';
	}
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
	$tpl->display();
//echo $this->ProcessTemplate('details_rencontre.tpl');

#
?>