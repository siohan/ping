<?php
   if (!isset($gCms)) exit;
################################################################################
## Cette page liste les compétitions par équipes                              ##
################################################################################
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$nom_equipes = $this->GetPreference('nom_equipes');
$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
//echo 'la saison courantest : '.$saison_courante;
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$rowarray = array();
$parameters = 0;//pour implémenter les parametres // 0 = pas de parametres
//$rowarray1 = array();
$i=0;

		
		$parameters = 1;
		//$date_debut = $params['date_debut'];			
			
		//la requete maintenant : 
		$query1 = "SELECT eq.id AS ind1,ren.equa,ren.equb,ren.scorea,ren.scoreb,ren.date_event, eq.friendlyname, ren.id AS ren_id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0)";//"  AND ren.date_event = ?";
		//$parms['date_debut'] = $params['date_debut'];
			
			if(isset($params['type_compet']) && $params['type_compet'])
			{
				$type_compet = $params['type_compet'];
				$query1.=" AND eq.type_compet = ?";
				$parms['type_compet'] = $type_compet;//" AND cal.date_debut = '2014-12-06'";
				//$smarty->assign('date_event', $date_debut);				
			}
			elseif(isset($params['idepreuve']) && $params['idepreuve'])
			{
				$idepreuve = $params['idepreuve'];
				$query1.=" AND eq.idepreuve = ?";
				$parms['idepreuve'] = $idepreuve;
			}
			if(isset($params['date_debut']) && $params['date_debut'] != '')
			{
				$date_debut = $params['date_debut'];
				$query1.=" AND ren.date_event = ?";
				$parms['date_debut'] = $date_debut;
			}
			$query1.=" AND ren.club = '1'";
			//echo $query;	
			$dbresult = $db->Execute($query1,$parms);
			
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$onerow = new StdClass();
					$onerow->rowclass = $rowclass;
					$equa = $row['equa'];
					$equb = $row['equb'];
					$scorea = $row['scorea'];
					$scoreb = $row['scoreb'];
					$libequipe = $row['libequipe'];
					$friendlyname = $row['friendlyname'];
					$onerow = new StdClass();
					$onerow->rowclass =$rowclass;
					//$onerow2->id= $row2['id'];
					$onerow->ind= $row['ind1'];
					$onerow->ren_id = $row['ren_id'];
					$onerow->date_event= $row['date_event'];
					$onerow->equb = $row['equb'];
					$onerow->equa = $row['equa'];
					$onerow->friendlyname = $row['friendlyname'];
					$onerow->libequipe = $row['libequipe'];
					//echo "equipe B est : ".$equb;

					//$onerow->equipe= $row['equipe'];
					//$onerow2->libelle=  $row2['libelle'] ;
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equa)
						{
							$onerow->equa= $row['friendlyname'];
						}

						else{
							$onerow->equa= $row['equa'];
						}

					}
					else
					{
						$onerow->equa= $row['equa'];
					}
					$onerow->scorea= $row['scorea'];
					$onerow->scoreb= $row['scoreb'];
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equb)
						{
							$onerow->equb= $row['friendlyname'];
						}

						else{
							$onerow->equb= $row['equb'];
						}

					}
					else
					{ 
						$onerow->equb= $row['equb'];
					}
					//$onerow->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row['id'], 'template'=>'1'));
					//$onerow->class= $this->CreateLink($id, 'details', $returnid, 'Détails', array('record_id'=>$row['ren_id']));
					$onerow->class= $this->CreateFrontendLink($id, $returnid, 'details', $contents='Détails', array('record_id'=>$row['ren_id']));
					$rowarray[] = $onerow;
					
				}
				
				
			}
			$smarty->assign('items', $rowarray);
			$smarty->assign('parameters', $parameters);	

echo $this->ProcessTemplate('details_rencontre.tpl');

#
?>