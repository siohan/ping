<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
//a faire 
//mettre les autorisations
//si pas de record_id redirection
$record_id = $params['record_id'];
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
			$comptage = count($result[partie]);
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
			$equa = $tab1[resultat][equa];
			$resa = $tab1[resultat][resa];
			$equb = $tab1[resultat][equb];
			$resb = $tab1[resultat][resb];
			
				
					for($i=0;$i<$compteur;$i++)
					{
						$xja = 'xja'.$i;//ex : $xja = 'xja0';
						$xca = 'xca'.$i;
						$xjb = 'xjb'.$i;//ex : $xja = 'xja0';
						$xcb = 'xcb'.$i;
						$$xja = $tab2[joueur][$i][xja];//ex : $xja0 = '';
						$$xca = $tab2[joueur][$i][xca];
						$$xjb = $tab2[joueur][$i][xjb];//ex : $xja0 = '';
						$$xcb = $tab2[joueur][$i][xcb];
						//echo $$xja;
					}
						
					for($a=0;$a<$comptage;$a++)
					{
						$ja = 'ja'.$a;//ex $ja = 'ja0';
						$$ja = $tab3[partie][$a][ja];
						$jb = 'jb'.$a;//ex $ja = 'ja0';
						$$jb = $tab3[partie][$a][jb];
						$scorea = 'scorea'.$a;
						$$scorea = $tab3[partie][$a][scorea];
						$scoreb = 'scoreb'.$a;
						$$scoreb = $tab3[partie][$a][scoreb];
						
					}
				
					
				
				
		
				$contenu = '';
				$retour= $this->CreateReturnLink($id, $returnid,'Retour');
				$contenu.="<p>$retour</p>";
				$contenu.= "<table class=\"table table-bordered\">";
				$contenu.="<tr><td>$equa</td><td>$resa</td><td>$resb</td><td>$equb</td></tr>";
				//$contenu.="</table>";
				//$contenu.="<table class=\"table table-bordered\">";
				for($i=0;$i<$compteur;$i++)
				{
					$contenu.="<tr><td> ${'xja'.$i}</td><td>${'xca'.$i}</td><td>${'xjb'.$i}</td><td>${'xcb'.$i}</td></tr>";
				}
				
				//$contenu.="</table>";
			//	$contenu.="<table class=\"table table-bordered\">";
				for($a=0;$a<$comptage;$a++)
				{
					$contenu.="<tr><td>${'ja'.$a}</td><td>${'scorea'.$a}</td><td>${'scoreb'.$a}</td><td>${'jb'.$a}</td></tr>";
				}
				
				//$contenu.="<tr><td>$xja0</td><td>$xca0</td><td>$xjb0</td><td>$xcb0</td></tr>";
				$contenu.="</table>";	
				echo $contenu;	
				
			}//fin du else
	}//fin du while
}
else
{
	echo 'Pas de résultats';
}//fin du if primaire
#
# EOF
#
//echo $this->ProcessTemplate('details_rencontre.tpl');
?>