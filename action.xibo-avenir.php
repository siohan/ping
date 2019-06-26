<?php
   if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$saison = $this->GetPreference('saison_en_cours');
$phase = 2;
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$rowarray = array();
//$rowarray1 = array();


$query = "SELECT numero_equipe, libequipe, saison, phase, idepreuve FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ? ";//GROUP BY date_debut ORDER BY date_debut DESC";
$parms['saison'] = $saison;
$parms['phase'] = $phase;
if(isset($params['numero_equipe']) && $params['numero_equipe'] != '')
{
	$numero_equipe = $params['numero_equipe'];
	$tableau = explode(',', $numero_equipe);	
	$tab = implode(',', $tableau);
	
	$query.= " AND numero_equipe IN ($tab)";
	//$parms['numero_equipe']  = $tab;
		
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$query.=" AND idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
	// l'épreuve est spécifiée ? On peut connaitre le factuer LIMIT de la requete
	$ping_ops = new ping_admin_ops;
//	$nb_equipes = $ping_ops->teams_per_idepreuve($idepreuve, $saison, $phase);
//	var_dump($nb_equipes);
}


$dbresult = $db->Execute($query, $parms);
if($dbresult)
{
	if($dbresult->RecordCount()>0)
	{
		//il y a des résultats, on continue
		$rowclass = 'row1';
		$rowarray2 = array();
		while($row = $dbresult->FetchRow())
		{
			$numero_equipe = $row['numero_equipe'];
			$libequipe = $row['libequipe'];
			
			$query2 = "SELECT equa, equb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison LIKE ? AND idepreuve = ? AND date_event >= NOW() AND (equa LIKE ? OR equb LIKE ?) ORDER BY date_event ASC LIMIT 1";
			$dbresult2 = $db->Execute($query2,array($saison,$idepreuve,$libequipe, $libequipe ));
			if($dbresult2)
			{
				while($row2 = $dbresult2->FetchRow())
				{
					$ping_ops = new ping_admin_ops;
					$equa = $row2['equa'];
					$friendlyname_equa = $ping_ops->get_friendlyname($saison, $phase,$idepreuve,$libequipe=$equa);
					
					if(FALSE === $friendlyname_equa || NULL == $friendlyname_equa)
					{
						$friendlyname_equa = $row2['equa'];
					}
				
					$equb = $row2['equb'];
					$friendlyname_equb = $ping_ops->get_friendlyname($saison, $phase,$idepreuve,$libequipe=$equb);
					if(FALSE === $friendlyname_equb || NULL == $friendlyname_equb)
					{
						$friendlyname_equb = $row2['equb'];
					}
				
					$onerow2 = new StdClass();
					$onerow2->rowclass =$rowclass;
					$onerow2->equb = $friendlyname_equb;
					$onerow2->equa = $friendlyname_equa;					
					$rowarray2[] = $onerow2;
				}
				$smarty->assign('items', $rowarray2);
			}
			else
			{
				echo $db->ErrorMsg();
				echo 'erreur deuxième requete !';
			}
		}		
	}
	else
	{
		echo "pas de résultats à la première requete";
	}
}
else
{
	echo "première requete HS";
}




echo $this->ProcessTemplate('xibo_prochaines_rencontres.tpl');

#
?>