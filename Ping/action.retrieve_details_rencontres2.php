<?php
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


$query = "SELECT lien FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE id = ?";
$dbresult = $db->Execute($query, array($record_id));
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$lien = $row['lien'];
		$service = new Service();
		$result = $service->getRencontre("$lien");

		//print_r($result);
		
			if(!is_array($result))
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
			$compteur = count($result[joueur]);
			
			//on scinde le tableau principal en plusieurs tableaux ?
			$tab1 = array_slice($result,0,1);
			$tab2 = array_slice($result,1,1);
			$tab3 = array_slice($result,2,1);
			//print_r($tab1);
			//print_r($tab2);
			//print_r($tab3);
			//echo "le compteur est : ".$compteur;
			//echo "le nb de parties disputées est : ".$comptage;
				$i=0;
				$a=0;
				
					for($i=0;$i<$compteur;$i++)
					{
						$xja = 'xja'.$i;//ex : $xja = 'xja0';
						$xjb = 'xjb'.$i;//ex : $xja = 'xja0';
						$$xja = $tab2[joueur][$i][xja];//ex : $xja0 = '';
						$$xjb = $tab2[joueur][$i][xjb];//ex : $xja0 = '';
						
					$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE (CONCAT_WS(' ',nom, prenom) = ?) OR (CONCAT_WS(' ',nom, prenom) = ?)";
					//echo $query2;
					$dbresult2 = $db->Execute($query2, array($$xjb,$$xja));
						
						if($dbresult2 && $dbresult2->RecordCount()>0)
						{
							while($row2= $dbresult2->FetchRow())
							{
								$licence = $row2['licence'];
								ping_admin_ops::retrieve_parties_spid($licence, $record_id);
								
								
							}
						}
						else
						{
							
						}
						
						
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