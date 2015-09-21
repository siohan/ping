<?php
########################################################################################
## Cette page récupère les résultats de chaque joueur ds une compétition par équipes ###
########################################################################################
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
//a faire 
//mettre les autorisations
//si pas de record_id redirection
$record_id = '';
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
}
else
{
	$designation = "Paramètres manquants";
	$this->SetMessage("$designation");
	$$this->RedirectToAdminTab('poules');
}
//on va utiliser cette variable (record_id) comme clé secondaire dans la nouvelle table


$query = "SELECT saison, lien,idpoule, iddiv, date_event, tour FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE id = ?";
$dbresult = $db->Execute($query, array($record_id));
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$lien = $row['lien'];
		$service = new Servicen();
		$page = "xml_chp_renc";
		$var = $lien;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['resultat']);
			$lignes_joueurs = count($array['joueur']);
		}
		//echo "le nb de joueurs est : ".$lignes_joueurs;
		//$result = $service->getRencontre("$lien");

		//var_dump($xml);//print_r($result);
		
			if(!is_array($array))
			{ 

				//le tableau est vide, il faut envoyer un message pour le signaler
				$designation.= "le service est coupé";
				$this->SetMessage("$designation");
				$this->RedirectToAdminTab('poules');
			}   
			else
			{
			//on essaie de faire qqs calculs
			$tableau1 = array();
			$tab2 = array();
			$compteur = count($array['joueur']);
			$compteur_parties = count($array['parties']);
			
			//on scinde le tableau principal en plusieurs tableaux ?
			$tab1 = array_slice($array,0,1);
			$tab2 = array_slice($array,1,1);
			$tab3 = array_slice($array,2,1);
			//print_r($tab1);
			//print_r($tab2);
			//print_r($tab3);
			//echo "le compteur est : ".$compteur;
			//echo "le nb de parties disputées est : ".$comptage;
				$i=0;
				$a=0;
				
					for($i=0;$i<$compteur;$i++)
					{
						//la feuille de rencontre...
						$xja = 'xja'.$i;//ex : $xja = 'xja0';
						$xca = 'xca'.$i; //on met aussi le classement du joueurex : xca0, xca1,xca2, etc...
						$xjb = 'xjb'.$i;//ex : $xja = 'xja0';
						$xca = 'xcb'.$i;
						$$xja = $tab2[joueur][$i][xja];//ex : $xja0 = '';
						$$xca = $tab2[joueur][$i][xca];
						$$xjb = $tab2[joueur][$i][xjb];//ex : $xja0 = '';
						$$xcb = $tab2[joueur][$i][xcb];
						//on insère le tout dans la bdd
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_feuilles_rencontres (id, fk_id, joueurA, cltA, joueurB, cltB) VALUES ('', ?, ?, ?, ?, ?)";
						$dbresult3 = $db->Execute($query3, array($record_id, $$xja,$$xca,$$xjb,$$xcb));
					}
					for($i=0;$i<$compteur_parties;$i++)
					{
						
						
						//on s'occupe maintenant des parties
						$ja = 'ja'.$i;
						$scorea = 'scoreA'.$i;
						$jb = 'jb'.$i;
						$scoreb = 'scoreB'.$i;
						$$ja = $tab3[partie][$i][ja];
						$$scorea = $tab3[partie][$i][scorea];
						$$jb = $tab3[partie][$i][jb];
						$$scoreb = $tab3[partie][$i][scoreb];
						//on insère aussi dans la bdd
						$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_rencontres_parties (id, fk_id, joueurA, scoreA, joueurB, scoreB) VALUES ('', ?, ?, ?, ?, ?)";
						$dbresult4 = $db->Execute($query4, array($record_id, $$ja,$$scorea, $$jb, $$scoreb));
						
						$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE (CONCAT_WS(' ',nom, prenom) = ?) OR (CONCAT_WS(' ',nom, prenom) = ?)";
						//echo $query2;
						$dbresult2 = $db->Execute($query2, array($$xjb,$$xja));
						
							if($dbresult2 && $dbresult2->RecordCount()>0)
							{
								while($row2= $dbresult2->FetchRow())
								{
									$serv = new retrieve_ops();
									$licence = $row2['licence'];
									$retrieve = $serv->retrieve_parties_spid($licence, $record_id);
								
								
								}
							}
							else
							{
							
							}
						
							//on pourrait aussi récupérer ces infos pour les mettre en bdd	
							//echo $$xja;
					}
						
//on met la valeur uploaded à 1
$query3 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET `uploaded` = 1 WHERE id = ?";
$dbresultat = $db->Execute($query3, array($record_id));				
				
					
				
				
		
				
				
				
				
			}//fin du else
	}//fin du while
}//fin du if primaire
$this->SetMessage('Retrouvez les infos dans le journal');
$this->RedirectToAdminTab('poules');
#
# EOF
#
//echo $this->ProcessTemplate('details_rencontre.tpl');
?>