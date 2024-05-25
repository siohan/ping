<?php
#####################################################################
###                  To come                                      ###
#####################################################################
//les compétitions à venir
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
global $themeObject;
//le record_id est défini, on peut récupérer toutes les variables nécessaires
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = (int)$params['record_id'];
	$smarty->assign('record_id', $record_id);
	$eq_ops = new equipes_ping;
	$details = $eq_ops->details_equipe($record_id);
	$friendlyname = $details['friendlyname'];	
	$saison = $details['saison'];
	$idepreuve = $details['idepreuve'];
	$phase = $details['phase'];
	$tag = $details['tag'];
	$indivs = 0;
	if( null == $tag)
	{
		$ping_ops = new ping_admin_ops;
		$tag = $ping_ops->tag_equipe($record_id, $idepreuve);
	}
	$smarty->assign('tag', $tag);
}
include 'include/action.navigation.php';



$query2 = "SELECT cl.clt, cl.joue,cl.equipe,cl.pts,cl.vic, cl.nul, cl.def, cl.pg, cl.pp, cl.pf,eq.libequipe,eq.friendlyname, cl.num_equipe, cl.idclub FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq  WHERE eq.id = cl.idequipe   AND cl.idequipe = ? AND cl.saison = ? ORDER BY cl.id ASC";
$dbresult2= $db->Execute($query2, array($record_id,$saison));

$rowarray = array();
$rowclass2 = '';
if($dbresult2 && $dbresult2->RecordCount()>0)
{
	while($row2 = $dbresult2->FetchRow())
	{
		$classement = $row2['clt'];
		$joue = $row2['joue'];
		$friendlyname = $row2['friendlyname'];
		if($classement=='0' || $joue =='0' )
		{
			$classement = '-';
		}
		//on va vérifier si un logo existe
		$idclub = $row2['idclub'];
		
		$img= '';
		$dir = '../modules/Ping/images/logos/';
		$ext_list = array('.gif', '.jpg', '.png','.jpeg');
		foreach($ext_list as $ext)
		{
 			if(true == file_exists($dir.$idclub.$ext))
 			{
  				$img = $idclub.$ext;
 			}
		}
		
		$onerow2= new StdClass();
		$onerow2->friendlyname= $row2['friendlyname'];
		$onerow2->clt=  $classement;
		$onerow2->equipe= $row2['equipe'];
		$onerow2->joue= $row2['joue'];
		$onerow2->pts= $row2['pts'];
		$onerow2->vic= $row2['vic'];
		$onerow2->nul= $row2['nul'];
		$onerow2->def= $row2['def'];
		$onerow2->pg= $row2['pg'];
		$onerow2->pp= $row2['pp'];
		$onerow2->pf= $row2['pf'];
		$onerow2->idclub= $row2['idclub'];
		$onerow2->logo = $img;
		($rowclass2 == "row1" ? $rowclass2= "row2" : $rowclass2= "row1");
		$onerow2->rowclass2= $rowclass2;
		$rowarray[]= $onerow2;
	}
}
else
{
	//pas de résultats ?
}
$smarty->assign('libequipe', $friendlyname);
$smarty->assign('tag', $tag);
$smarty->assign('itemsfound2', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount2', count($rowarray));
$smarty->assign('items2', $rowarray);		
	
		
		
		
//la requete

$query = "SELECT DISTINCT date_event, tour FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE eq_id = ? ORDER BY date_event ASC ";
$dbresult = $db->Execute($query, array($record_id));
$rowarray = array();
$rowclass = '';
$i=0;
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		
		$date_debut = $row['date_event'];
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->date = $row['date_event'];
		$onerow->tour = $row['tour'];
		 //on déclare un nouveau tableau
		$rowarray2 = array();
		
			$i++;
			$onerow->valeur = $i;
			//on refait une requete pour extraire les rencontres
			$query2 = "SELECT DISTINCT ren.id AS ren_id,ren.renc_id,ren.eq_id, ren.scorea, ren.scoreb, ren.equa, ren.equb,ren.iddiv,eq.idepreuve, ren.idpoule,eq.friendlyname, ren.club,ren.uploaded,eq.libequipe,eq.id,ren.date_event,ren.affiche FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule AND ren.saison = eq.saison AND ren.eq_id = eq.id";
			$query2.= "  AND ren.date_event = ?";
			$query2.=" AND eq.id = ?";
			
			$dbresultat = $db->Execute($query2,array($date_debut,$record_id));
			
			
			
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				//on instancie la classe ping_admin_ops
				$ping_ops = new rencontres;
				$nblignes = $dbresultat->RecordCount();
				while($row2 = $dbresultat->FetchRow())
				{
					//$valeur = $i;
					$onerow2 = new StdClass();
					$onerow2->eq_id = $row2['eq_id'];
					//$onerow2->eq_id = $row2['id'];
					$onerow2->iddiv = $row2['iddiv'];
					$onerow2->idpoule = $row2['idpoule'];
					$onerow2->scorea = $row2['scorea'];
					$onerow2->scoreb = $row2['scoreb'];
					$onerow2->club = $row2['club'];
					$onerow2->date_event = $row2['date_event'];
					$onerow2->affiche = $row2['affiche'];
					$onerow2->uploaded = $ping_ops->is_really_uploaded($row2['renc_id']);//row2['uploaded'];
					$onerow2->libequipe = $row2['libequipe'];
					$friendlyname = $row2['friendlyname'];
					$onerow2->idepreuve = $row2['idepreuve'];
					$onerow2->renc_id = $row2['renc_id'];
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($row2['libequipe'] == $row2['equa'] && isset($friendlyname) && $friendlyname !='' )
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
						if ($row2['libequipe'] == $row2['equb'])
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
					
					$rowarray2[] = $onerow2;
					
				}
				
				$smarty->assign('prods_'.$i,$rowarray2);
			//	$smarty->assign('attention_img', '<img src="'. $this->GetModuleURLPath.'/images/warning.gif" alt="'.$this->Lang('new_topic_label').'" title="'.$this->Lang('new_topic_label').'" width="16" height="16" />');
				unset($rowarray2);
			//	unset($valeur);
			}
			
		
		
		$rowarray[]  = $onerow;
		$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('date_courante', date('Y-m-d'));
		//$smarty->assign('tag', $tag);
		
	}
}
/*
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Afficher sur le site"=>"display_on_frontend","Ne plus afficher sur le site"=>"do_not_display","Supprimer"=>"delete_team_results");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
*/
echo $this->ProcessTemplate('resultats.tpl');
#
#EOF
#
?>







