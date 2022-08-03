<?php
if(!isset($gCms) ) exit;
$db = cmsms()->GetDb();
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
$idepreuve = '1073'; //pour commencer
$renc_ops = new rencontres;
echo $saison.' / '.$phase.' / '.$idepreuve;;
$query = "SELECT libequipe FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ? AND idepreuve = ? ORDER BY numero_equipe ASC";
//echo $query;
$dbresult = $db->Execute($query, array($saison, $phase, $idepreuve));
if($dbresult)
{
	if($dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			$libequipe = $row['libequipe'];
			echo $libequipe;
			//maintenant on va chercher chq dernière rencontre de chq équipe (renc_id)
			$rencontre = $renc_ops->derniere_rencontre($libequipe, $idepreuve);
			echo $rencontre;
			//on a le renc_id, on cherche à savoir si le club joue en A ou B
			if(FALSE !== $rencontre)
			{
				$club = $renc_ops->club_en_A($rencontre);
				var_dump($club);
			//	echo 'le club est en '.$club;
				if(TRUE === $club)
				{
					//le club est en A
					//ds la feuille de match on récupère nom et prénom
					$query2 = "SELECT xja FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
					echo $query2;
					$dbresult2 = $db->Execute($query2, array($rencontre));
					if($dbresult2 && $dbresult2->RecordCount()>0)
					{
						while($row2 = $dbresult2->FetchRow())
						{
							$xja = $row2['xja'];
							$query3 = "SELECT SUM(scoreA) AS vic, count(scoreA) AS matchs_totaux FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ? AND joueurA = ?";
							$dbresult3 = $db->Execute($query3, array($rencontre, $xja));
							if($dbresult3 && $dbresult3->recordCount()>0)
							{
								$row3 = $dbresult3->FetchRow();
								$victoires = $row3['vic'];
								$matchs_totaux = $row3['matchs_totaux'];
								$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_victoires (renc_id,joueur, victoires, matchs_totaux ) VALUES (?, ?, ?, ?)";
								$dbresult4 = $db->Execute($query4, array($rencontre,$xja,$victoires, $matchs_totaux));
							}
						}
					}
					
				}
				elseif(FALSE === $club)
				{
					//Ben le club est en B
					//le club est en A
					//ds la feuille de match on récupère nom et prénom
					$query2 = "SELECT xjb FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
					echo $query2;
					$dbresult2 = $db->Execute($query2,array($rencontre));
					if($dbresult2 && $dbresult2->RecordCount()>0)
					{
						while($row2 = $dbresult2->FetchRow())
						{
							$xjb = $row2['xjb'];
							$query3 = "SELECT SUM(scoreB) AS vic, count(scoreB) AS matchs_totaux FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ? AND joueurB = ?";
							$dbresult3 = $db->Execute($query3, array($rencontre, $xjb));
							if($dbresult3 && $dbresult3->recordCount()>0)
							{
								$row3 = $dbresult3->FetchRow();
								$victoires = $row3['vic'];
								$matchs_totaux = $row3['matchs_totaux'];
								$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_victoires (renc_id,joueur, victoires, matchs_totaux ) VALUES (?, ?, ?, ?)";
								$dbresult4 = $db->Execute($query4, array($rencontre,$xjb,$victoires, $matchs_totaux));
							}
						}
					}
				}
			}
			else
			{
				echo 'Pas de rencontre pour '.$libequipe;
			}
		}
	}
	else
	{
		echo 'pas encore de résultats disponibles';
	}
}
else
{
	echo 'pb première requete';
}

?>